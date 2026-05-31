<?php

namespace App\Http\Controllers\Driver;

use App\Http\Controllers\Controller;
use App\Models\Delivery;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $driver = Auth::user();
        
        // Ensure driver profile exists
        if (!$driver->driverProfile) {
            $driver->driverProfile()->create([
                'vehicle_type' => 'motorcycle',
                'vehicle_plate' => 'PENDING',
                'availability' => 'available'
            ]);
            $driver->refresh();
        }

        $activeDeliveries = Delivery::where('driver_id', $driver->id)
            ->whereNotIn('status', ['delivered', 'failed'])
            ->with(['order.user', 'order.zone'])
            ->latest()
            ->get();

        $stats = [
            'today_deliveries' => Delivery::where('driver_id', $driver->id)
                ->where('status', 'delivered')
                ->whereDate('delivered_at', today())
                ->count(),
            'total_deliveries' => Delivery::where('driver_id', $driver->id)
                ->where('status', 'delivered')
                ->count(),
            'pending_deliveries' => $activeDeliveries->count(),
        ];

        return view('driver.dashboard', compact('driver', 'activeDeliveries', 'stats'));
    }

    public function updateAvailability(Request $request)
    {
        $request->validate([
            'availability' => 'required|in:available,offline'
        ]);

        $driver = Auth::user();
        $driver->driverProfile->update([
            'availability' => $request->availability
        ]);

        return back()->with('success', 'Status updated successfully.');
    }
}
