<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{
    /**
     * Display a listing of the customer's orders.
     */
    public function index()
    {
        $orders = Order::where('user_id', Auth::id())
            ->with(['items', 'payment', 'delivery'])
            ->latest()
            ->paginate(10);

        return view('customer.orders.index', compact('orders'));
    }

    /**
     * Display the specified order.
     */
    public function show(Order $order)
    {
        if ($order->user_id !== Auth::id()) {
            abort(403);
        }

        $order->load(['items.product', 'payment', 'delivery.driver', 'zone']);

        return view('customer.orders.show', compact('order'));
    }
}
