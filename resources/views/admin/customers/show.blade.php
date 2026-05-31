@extends('layouts.admin')

@section('page-title', 'Customer Details')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <a href="{{ route('admin.customers.index') }}" class="text-decoration-none text-muted small fw-bold"><i class="bi bi-arrow-left me-1"></i> Back to Customers</a>
</div>

<div class="row g-4">
    <div class="col-lg-4">
        <div class="card border-0 shadow-sm rounded-4 bg-white mb-4">
            <div class="card-body p-4 text-center">
                <div class="avatar bg-primary bg-opacity-10 text-primary rounded-circle d-inline-flex align-items-center justify-content-center mb-3" style="width: 80px; height: 80px;">
                    <span class="fs-2 fw-bold">{{ substr($user->name, 0, 1) }}</span>
                </div>
                <h4 class="fw-bold mb-1">{{ $user->name }}</h4>
                <p class="text-muted small mb-3">{{ $user->email }}</p>
                
                <form action="{{ route('admin.customers.status', $user) }}" method="POST">
                    @csrf @method('PATCH')
                    <input type="hidden" name="status" value="{{ $user->status == 'active' ? 'suspended' : 'active' }}">
                    <button type="submit" class="btn btn-{{ $user->status == 'active' ? 'outline-danger' : 'success' }} rounded-pill w-100 fw-bold">
                        {{ $user->status == 'active' ? 'Suspend Account' : 'Activate Account' }}
                    </button>
                </form>
            </div>
            <div class="card-footer bg-white border-top p-4">
                <div class="mb-3">
                    <small class="text-muted text-uppercase fw-bold d-block mb-1">Phone Number</small>
                    <div class="fw-medium">{{ $user->phone ?? 'Not provided' }}</div>
                </div>
                <div>
                    <small class="text-muted text-uppercase fw-bold d-block mb-1">Joined Date</small>
                    <div class="fw-medium">{{ $user->created_at->format('F d, Y') }}</div>
                </div>
            </div>
        </div>
        
        <div class="card border-0 shadow-sm rounded-4 bg-white">
            <div class="card-body p-4">
                <h5 class="fw-bold mb-4">Customer Value</h5>
                <div class="d-flex justify-content-between mb-3 border-bottom pb-3">
                    <span class="text-muted fw-bold">Total Orders</span>
                    <span class="fw-bold fs-5 font-mono text-primary">{{ $totalOrders }}</span>
                </div>
                <div class="d-flex justify-content-between">
                    <span class="text-muted fw-bold">Total Spent</span>
                    <span class="fw-bold fs-5 font-mono text-success">KES {{ number_format($totalSpent) }}</span>
                </div>
            </div>
        </div>
    </div>

    <div class="col-lg-8">
        <div class="card border-0 shadow-sm rounded-4 bg-white">
            <div class="card-header bg-white p-4 border-bottom">
                <h5 class="fw-bold mb-0">Recent Orders</h5>
            </div>
            <div class="table-responsive">
                <table class="table align-middle mb-0">
                    <thead class="table-light">
                        <tr>
                            <th class="ps-4 py-3 border-0">Order ID</th>
                            <th class="py-3 border-0">Amount</th>
                            <th class="py-3 border-0">Status</th>
                            <th class="pe-4 py-3 border-0 text-end">Date</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($user->orders as $order)
                        <tr>
                            <td class="ps-4 py-3"><a href="{{ route('admin.orders.show', $order) }}" class="fw-bold text-decoration-none">#{{ $order->order_number }}</a></td>
                            <td class="py-3 font-mono">KES {{ number_format($order->total_amount) }}</td>
                            <td class="py-3">
                                <span class="badge bg-{{ $order->order_status == 'delivered' ? 'success' : 'warning' }} text-capitalize px-2 py-1 rounded-pill">
                                    {{ str_replace('_', ' ', $order->order_status) }}
                                </span>
                            </td>
                            <td class="pe-4 py-3 text-end text-muted small">{{ $order->created_at->format('M d, Y') }}</td>
                        </tr>
                        @empty
                        <tr><td colspan="4" class="text-center py-4 text-muted">No orders placed yet.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
