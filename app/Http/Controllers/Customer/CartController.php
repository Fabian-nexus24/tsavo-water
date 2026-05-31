<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Cart;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{
    /**
     * Display the cart.
     */
    public function index()
    {
        $cartItems = Cart::where('user_id', Auth::id())
            ->with('product.category')
            ->get();

        $subtotal = $cartItems->sum(function ($item) {
            return $item->product->effective_price * $item->quantity;
        });

        return view('customer.cart.index', compact('cartItems', 'subtotal'));
    }

    /**
     * Add a product to the cart.
     */
    public function store(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|integer|min:1|max:100',
        ]);

        $product = Product::findOrFail($request->product_id);

        if ($product->status !== 'active' || $product->stock < $request->quantity) {
            return back()->with('error', 'This product is currently unavailable or out of stock.');
        }

        $cartItem = Cart::where('user_id', Auth::id())
            ->where('product_id', $request->product_id)
            ->first();

        if ($cartItem) {
            $newQty = $cartItem->quantity + $request->quantity;
            if ($newQty > $product->stock) {
                return back()->with('error', 'Not enough stock available.');
            }
            $cartItem->update(['quantity' => $newQty]);
        } else {
            Cart::create([
                'user_id' => Auth::id(),
                'product_id' => $request->product_id,
                'quantity' => $request->quantity,
            ]);
        }

        return back()->with('success', "{$product->name} added to cart!");
    }

    /**
     * Update cart item quantity.
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'quantity' => 'required|integer|min:1|max:100',
        ]);

        $cartItem = Cart::where('user_id', Auth::id())->findOrFail($id);
        $product = $cartItem->product;

        if ($request->quantity > $product->stock) {
            return back()->with('error', 'Not enough stock available.');
        }

        $cartItem->update(['quantity' => $request->quantity]);

        return back()->with('success', 'Cart updated.');
    }

    /**
     * Remove item from cart.
     */
    public function destroy($id)
    {
        $cartItem = Cart::where('user_id', Auth::id())->findOrFail($id);
        $cartItem->delete();

        return back()->with('success', 'Item removed from cart.');
    }
}
