<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class CustomerController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->get('search');
        
        $customers = User::where('role', 'customer')
            ->when($search, function($query) use ($search) {
                $query->where(function($q) use ($search) {
                    $q->where('name', 'like', "%{$search}%")
                      ->orWhere('email', 'like', "%{$search}%")
                      ->orWhere('phone', 'like', "%{$search}%");
                });
            })
            ->withCount('orders')
            ->orderBy('created_at', 'desc')
            ->paginate(15);

        return view('admin.customers.index', compact('customers'));
    }

    public function show(User $user)
    {
        if ($user->role !== 'customer') {
            abort(404);
        }

        $user->load(['orders' => function($query) {
            $query->latest()->limit(10);
        }]);

        $totalSpent = $user->orders()->where('payment_status', 'paid')->sum('total_amount');
        $totalOrders = $user->orders()->count();

        return view('admin.customers.show', compact('user', 'totalSpent', 'totalOrders'));
    }

    public function updateStatus(Request $request, User $user)
    {
        if ($user->role !== 'customer') {
            abort(404);
        }

        $request->validate([
            'status' => 'required|in:active,suspended'
        ]);

        $user->update(['status' => $request->status]);

        return back()->with('success', 'Customer status updated successfully.');
    }
}
