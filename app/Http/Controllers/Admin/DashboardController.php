<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\User;
use App\Models\Product;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        // KPIs
        $stats = [
            'total_revenue' => Order::where('payment_status', 'paid')->sum('total_amount'),
            'total_orders' => Order::count(),
            'pending_orders' => Order::whereIn('order_status', ['pending', 'confirmed'])->count(),
            'total_customers' => User::customers()->count(),
            'total_drivers' => User::drivers()->count(),
            'active_products' => Product::where('status', 'active')->count(),
        ];

        // Recent Orders
        $recentOrders = Order::with(['user', 'delivery.driver'])
            ->latest()
            ->take(6)
            ->get();

        return view('admin.dashboard', compact('stats', 'recentOrders'));
    }
}
