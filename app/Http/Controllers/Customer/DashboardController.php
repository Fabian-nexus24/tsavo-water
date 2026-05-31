<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    /**
     * Display the customer dashboard.
     */
    public function index()
    {
        $user = Auth::user();

        // Active order (most recent non-final status)
        $activeOrder = Order::where('user_id', $user->id)
            ->whereNotIn('order_status', ['delivered', 'cancelled'])
            ->with(['delivery.driver', 'items'])
            ->latest()
            ->first();

        // Recent orders
        $recentOrders = Order::where('user_id', $user->id)
            ->with('items')
            ->latest()
            ->take(5)
            ->get();

        // Statistics
        $stats = [
            'total_orders' => Order::where('user_id', $user->id)->count(),
            'total_spent' => Order::where('user_id', $user->id)
                ->where('payment_status', 'paid')
                ->sum('total_amount'),
            'pending_orders' => Order::where('user_id', $user->id)
                ->whereNotIn('order_status', ['delivered', 'cancelled'])
                ->count(),
            'delivered_orders' => Order::where('user_id', $user->id)
                ->where('order_status', 'delivered')
                ->count(),
        ];

        // Last completed order for quick reorder
        $lastOrder = Order::where('user_id', $user->id)
            ->where('order_status', 'delivered')
            ->with('items.product')
            ->latest()
            ->first();

        // Time-based greeting
        $hour = now()->hour;
        if ($hour < 12) {
            $greeting = 'Good Morning';
        } elseif ($hour < 17) {
            $greeting = 'Good Afternoon';
        } else {
            $greeting = 'Good Evening';
        }

        return view('customer.dashboard', compact(
            'user', 'activeOrder', 'recentOrders', 'stats', 'lastOrder', 'greeting'
        ));
    }
}
