<?php

namespace App\Http\Controllers\Driver;

use App\Http\Controllers\Controller;
use App\Models\Delivery;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DeliveryController extends Controller
{
    public function index()
    {
        $deliveries = Delivery::where('driver_id', Auth::id())
            ->with(['order.user', 'order.zone'])
            ->latest()
            ->paginate(15);

        return view('driver.deliveries.index', compact('deliveries'));
    }

    public function show(Delivery $delivery)
    {
        if ($delivery->driver_id !== Auth::id()) {
            abort(403);
        }

        $delivery->load(['order.items.product', 'order.user', 'order.zone']);
        return view('driver.deliveries.show', compact('delivery'));
    }

    public function markPickedUp(Delivery $delivery)
    {
        if ($delivery->driver_id !== Auth::id()) abort(403);

        $delivery->update([
            'status' => 'picked_up',
            'picked_up_at' => now()
        ]);

        $delivery->order->update(['order_status' => 'out_for_delivery']);

        return back()->with('success', 'Delivery marked as Picked Up.');
    }

    public function markDelivered(Delivery $delivery)
    {
        if ($delivery->driver_id !== Auth::id()) abort(403);

        $delivery->update([
            'status' => 'delivered',
            'delivered_at' => now()
        ]);

        $delivery->order->update([
            'order_status' => 'delivered',
            // Also mark as paid if it's COD and successfully delivered
            'payment_status' => $delivery->order->payment_method == 'cash' ? 'paid' : $delivery->order->payment_status
        ]);

        return back()->with('success', 'Delivery marked as Completed.');
    }

    public function markFailed(Request $request, Delivery $delivery)
    {
        if ($delivery->driver_id !== Auth::id()) abort(403);

        $request->validate(['notes' => 'required|string']);

        $delivery->update([
            'status' => 'failed',
            'notes' => $request->notes
        ]);

        // Keep order status as out_for_delivery or mark as pending for review
        $delivery->order->update(['order_status' => 'confirmed']);

        return back()->with('error', 'Delivery marked as Failed. Order returned to pool.');
    }
}
