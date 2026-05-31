<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\User;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;

class OrderController extends Controller
{
    public function index(Request $request)
    {
        $orders = Order::with(['user', 'zone', 'delivery.driver'])
            ->when($request->status, function ($query) use ($request) {
                return $query->where('order_status', $request->status);
            })
            ->when($request->search, function ($query) use ($request) {
                return $query->where('order_number', 'like', '%' . $request->search . '%')
                             ->orWhereHas('user', function ($q) use ($request) {
                                 $q->where('name', 'like', '%' . $request->search . '%')
                                   ->orWhere('email', 'like', '%' . $request->search . '%');
                             });
            })
            ->latest()
            ->paginate(15)
            ->withQueryString();
            
        $drivers = User::drivers()->where('status', 'active')->get();

        return view('admin.orders.index', compact('orders', 'drivers'));
    }

    public function show(Order $order)
    {
        $order->load(['items.product', 'payment', 'delivery.driver', 'zone', 'user']);
        $drivers = User::drivers()->where('status', 'active')->get();
        
        return view('admin.orders.show', compact('order', 'drivers'));
    }

    public function updateStatus(Request $request, Order $order)
    {
        $request->validate([
            'status' => 'required|in:pending,confirmed,processing,assigned,out_for_delivery,delivered,cancelled'
        ]);

        $order->update(['order_status' => $request->status]);

        return back()->with('success', 'Order status updated successfully.');
    }

    public function assignDriver(Request $request, Order $order)
    {
        $request->validate([
            'driver_id' => 'required|exists:users,id'
        ]);

        // If delivery record exists, update it, else create it
        if ($order->delivery) {
            $order->delivery->update([
                'driver_id' => $request->driver_id,
                'status' => 'assigned',
                'assigned_at' => now(),
            ]);
        } else {
            $order->delivery()->create([
                'driver_id' => $request->driver_id,
                'status' => 'assigned',
                'assigned_at' => now(),
            ]);
        }

        $order->update(['order_status' => 'assigned']);

        return back()->with('success', 'Driver assigned successfully.');
    }

    public function cancel(Request $request, Order $order)
    {
        $order->update(['order_status' => 'cancelled']);
        return back()->with('success', 'Order cancelled.');
    }

    public function invoice(Order $order)
    {
        $order->load(['user', 'items', 'zone']);

        $options = new \Dompdf\Options();
        $options->set('defaultFont', 'Helvetica');
        $options->set('isRemoteEnabled', true);
        $options->set('dpi', 96);

        $dompdf = new \Dompdf\Dompdf($options);
        $dompdf->setPaper('A4', 'portrait');

        $html = view('admin.orders.invoice', compact('order'))->render();
        $dompdf->loadHtml($html);
        $dompdf->render();

        return response($dompdf->output(), 200, [
            'Content-Type'        => 'application/pdf',
            'Content-Disposition' => 'attachment; filename="Invoice_' . $order->order_number . '.pdf"',
        ]);
    }
}
