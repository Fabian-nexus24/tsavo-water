<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AnalyticsController extends Controller
{
    public function index()
    {
        // KPI: Total Revenue (from delivered or successful orders)
        // Let's assume 'delivered' is the final successful state
        $successfulOrders = Order::where('order_status', 'delivered')->get();
        
        $totalRevenue = $successfulOrders->sum('total_amount');
        $totalOrders = $successfulOrders->count();
        $averageOrderValue = $totalOrders > 0 ? $totalRevenue / $totalOrders : 0;

        // Calculate Total Profit
        // We need to look at each OrderItem to get the exact cost of the products sold
        $totalCost = 0;
        foreach ($successfulOrders as $order) {
            foreach ($order->items as $item) {
                // If product has a cost_price, use it, otherwise assume 0
                $cost = $item->product ? ($item->product->cost_price ?? 0) : 0;
                $totalCost += ($cost * $item->quantity);
            }
        }
        $totalProfit = $totalRevenue - $totalCost;

        // Chart Data: Revenue & Profit over the last 30 days
        $thirtyDaysAgo = Carbon::now()->subDays(30)->startOfDay();
        
        $dailyData = Order::with('items.product')
            ->where('order_status', 'delivered')
            ->where('created_at', '>=', $thirtyDaysAgo)
            ->get()
            ->groupBy(function($date) {
                return Carbon::parse($date->created_at)->format('Y-m-d');
            });

        $chartLabels = [];
        $chartRevenue = [];
        $chartProfit = [];

        // Pre-fill the last 30 days with 0 so the chart doesn't have gaps
        for ($i = 30; $i >= 0; $i--) {
            $date = Carbon::now()->subDays($i)->format('Y-m-d');
            $chartLabels[] = Carbon::now()->subDays($i)->format('M d');
            
            if (isset($dailyData[$date])) {
                $dayOrders = $dailyData[$date];
                $dayRevenue = $dayOrders->sum('total_amount');
                
                $dayCost = 0;
                foreach ($dayOrders as $order) {
                    foreach ($order->items as $item) {
                        $cost = $item->product ? ($item->product->cost_price ?? 0) : 0;
                        $dayCost += ($cost * $item->quantity);
                    }
                }
                $dayProfit = $dayRevenue - $dayCost;
                
                $chartRevenue[] = $dayRevenue;
                $chartProfit[] = $dayProfit;
            } else {
                $chartRevenue[] = 0;
                $chartProfit[] = 0;
            }
        }

        // Top Selling Products (by revenue)
        $topProducts = OrderItem::join('orders', 'order_items.order_id', '=', 'orders.id')
            ->join('products', 'order_items.product_id', '=', 'products.id')
            ->where('orders.order_status', 'delivered')
            ->select('products.name', DB::raw('SUM(order_items.quantity * order_items.product_price) as total_revenue'), DB::raw('SUM(order_items.quantity) as total_sold'))
            ->groupBy('products.id', 'products.name')
            ->orderByDesc('total_revenue')
            ->take(5)
            ->get();

        // Recent Transactions (Orders)
        $recentTransactions = Order::with('user')
            ->latest()
            ->take(10)
            ->get();

        return view('admin.analytics.index', compact(
            'totalRevenue', 
            'totalProfit', 
            'averageOrderValue', 
            'totalOrders',
            'chartLabels',
            'chartRevenue',
            'chartProfit',
            'topProducts',
            'recentTransactions'
        ));
    }
}
