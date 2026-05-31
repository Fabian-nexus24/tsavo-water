<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Cart;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Payment;
use App\Models\Delivery;
use App\Models\DeliveryZone;
use App\Services\MpesaService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class CheckoutController extends Controller
{
    /**
     * Display the checkout page.
     */
    public function index()
    {
        $cartItems = Cart::where('user_id', Auth::id())
            ->with('product')
            ->get();

        if ($cartItems->isEmpty()) {
            return redirect()->route('customer.cart.index')
                ->with('error', 'Your cart is empty.');
        }

        $subtotal = $cartItems->sum(function ($item) {
            return $item->product->effective_price * $item->quantity;
        });

        $zones = DeliveryZone::where('is_active', true)->get();
        $user = Auth::user();

        return view('customer.checkout.index', compact('cartItems', 'subtotal', 'zones', 'user'));
    }

    /**
     * Process the checkout and create an order.
     */
    public function store(Request $request)
    {
        $request->validate([
            'delivery_address' => 'required|string|max:500',
            'delivery_city' => 'required|string|max:100',
            'zone_id' => 'nullable|exists:delivery_zones,id',
            'payment_method' => 'required|in:cash,mpesa,card',
            'notes' => 'nullable|string|max:1000',
        ]);

        $cartItems = Cart::where('user_id', Auth::id())
            ->with('product')
            ->get();

        if ($cartItems->isEmpty()) {
            return back()->with('error', 'Your cart is empty.');
        }

        // Validate stock availability
        foreach ($cartItems as $item) {
            if ($item->product->stock < $item->quantity) {
                return back()->with('error', "Not enough stock for {$item->product->name}.");
            }
        }

        $subtotal = $cartItems->sum(function ($item) {
            return $item->product->effective_price * $item->quantity;
        });

        // Calculate delivery fee
        $deliveryFee = 0;
        if ($request->zone_id) {
            $zone = DeliveryZone::find($request->zone_id);
            $deliveryFee = $zone ? $zone->base_fee : 0;
        }

        $totalAmount = $subtotal + $deliveryFee;

        DB::beginTransaction();

        try {
            // Create order
            $order = Order::create([
                'user_id' => Auth::id(),
                'zone_id' => $request->zone_id,
                'delivery_address' => $request->delivery_address,
                'delivery_city' => $request->delivery_city,
                'delivery_lat' => $request->delivery_lat,
                'delivery_lng' => $request->delivery_lng,
                'payment_method' => $request->payment_method,
                'payment_status' => $request->payment_method === 'cash' ? 'pending' : 'pending',
                'order_status' => 'pending',
                'subtotal' => $subtotal,
                'delivery_fee' => $deliveryFee,
                'total_amount' => $totalAmount,
                'notes' => $request->notes,
            ]);

            // Create order items & reduce stock
            foreach ($cartItems as $item) {
                OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $item->product_id,
                    'product_name' => $item->product->name,
                    'product_price' => $item->product->effective_price,
                    'quantity' => $item->quantity,
                    'subtotal' => $item->product->effective_price * $item->quantity,
                ]);

                // Reduce stock
                $item->product->decrement('stock', $item->quantity);
            }

            // Create payment record
            Payment::create([
                'order_id' => $order->id,
                'user_id' => Auth::id(),
                'amount' => $totalAmount,
                'method' => $request->payment_method,
                'status' => $request->payment_method === 'cash' ? 'pending' : 'pending',
            ]);

            // Create delivery record
            Delivery::create([
                'order_id' => $order->id,
                'status' => 'pending',
            ]);

            // Clear cart
            Cart::where('user_id', Auth::id())->delete();

            DB::commit();

            // If cash payment, mark order as confirmed
            if ($request->payment_method === 'cash') {
                $order->update(['order_status' => 'confirmed']);
            }

            return redirect()->route('customer.checkout.success', $order)
                ->with('success', 'Order placed successfully!');

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Something went wrong. Please try again.');
        }
    }

    /**
     * Display the order success page.
     */
    public function success(Order $order)
    {
        if ($order->user_id !== Auth::id()) {
            abort(403);
        }

        $order->load(['items', 'payment', 'delivery']);

        return view('customer.checkout.success', compact('order'));
    }

    /**
     * Trigger M-Pesa STK Push.
     */
    public function stkPush(Request $request)
    {
        $request->validate([
            'phone' => 'required|string|min:10|max:15',
            'order_id' => 'required|exists:orders,id',
        ]);

        $order = Order::where('user_id', Auth::id())->findOrFail($request->order_id);

        try {
            $mpesa = new MpesaService();
            $response = $mpesa->stkPush(
                $request->phone,
                $order->total_amount,
                $order->order_number
            );

            if (isset($response['CheckoutRequestID'])) {
                // Update payment with M-Pesa details
                $order->payment->update([
                    'mpesa_phone' => $request->phone,
                    'mpesa_checkout_request_id' => $response['CheckoutRequestID'],
                    'mpesa_merchant_request_id' => $response['MerchantRequestID'],
                ]);

                return response()->json([
                    'success' => true,
                    'message' => 'STK Push sent. Check your phone.',
                    'checkout_request_id' => $response['CheckoutRequestID'],
                ]);
            }

            return response()->json([
                'success' => false,
                'message' => 'Failed to initiate M-Pesa payment.',
            ], 400);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'M-Pesa service error. Please try again.',
            ], 500);
        }
    }
}
