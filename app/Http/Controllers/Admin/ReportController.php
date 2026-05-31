<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Delivery;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    public function index()
    {
        // Simple aggregates for the dashboard
        $totalSales = Order::where('payment_status', 'paid')->sum('total_amount');
        $totalOrders = Order::count();
        $successfulDeliveries = Delivery::where('status', 'delivered')->count();
        
        $recentOrders = Order::with('user')->latest()->limit(5)->get();

        return view('admin.reports.index', compact('totalSales', 'totalOrders', 'successfulDeliveries', 'recentOrders'));
    }

    public function sales() { return "Sales Report (To be implemented)"; }
    public function deliveries() { return "Deliveries Report (To be implemented)"; }
    public function products() { return "Products Report (To be implemented)"; }
    public function export($type) { return "Exporting $type (To be implemented)"; }
}
