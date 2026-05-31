@extends('layouts.admin')

@section('page-title', 'Dashboard')

@section('content')
<div class="row g-4 mb-4">
    <div class="col-sm-6 col-xl-3">
        <div class="card border-0 shadow-sm rounded-4 h-100 bg-white">
            <div class="card-body p-4">
                <div class="d-flex align-items-center justify-content-between mb-3">
                    <div class="bg-primary bg-opacity-10 text-primary rounded-3 p-3">
                        <i class="bi bi-wallet2 fs-4"></i>
                    </div>
                    <span class="badge bg-success bg-opacity-10 text-success rounded-pill px-2 py-1"><i class="bi bi-arrow-up me-1"></i>12%</span>
                </div>
                <h6 class="text-muted text-uppercase fw-bold mb-1 small">Total Revenue</h6>
                <h3 class="fw-bold mb-0 font-mono">KES {{ number_format($stats['total_revenue']) }}</h3>
            </div>
        </div>
    </div>
    
    <div class="col-sm-6 col-xl-3">
        <div class="card border-0 shadow-sm rounded-4 h-100 bg-white">
            <div class="card-body p-4">
                <div class="d-flex align-items-center justify-content-between mb-3">
                    <div class="bg-info bg-opacity-10 text-info rounded-3 p-3">
                        <i class="bi bi-cart-check fs-4"></i>
                    </div>
                </div>
                <h6 class="text-muted text-uppercase fw-bold mb-1 small">Total Orders</h6>
                <h3 class="fw-bold mb-0 font-mono">{{ number_format($stats['total_orders']) }}</h3>
            </div>
        </div>
    </div>
    
    <div class="col-sm-6 col-xl-3">
        <div class="card border-0 shadow-sm rounded-4 h-100 bg-white">
            <div class="card-body p-4">
                <div class="d-flex align-items-center justify-content-between mb-3">
                    <div class="bg-warning bg-opacity-10 text-warning rounded-3 p-3">
                        <i class="bi bi-hourglass-split fs-4"></i>
                    </div>
                </div>
                <h6 class="text-muted text-uppercase fw-bold mb-1 small">Pending Orders</h6>
                <h3 class="fw-bold mb-0 font-mono">{{ number_format($stats['pending_orders']) }}</h3>
            </div>
        </div>
    </div>
    
    <div class="col-sm-6 col-xl-3">
        <div class="card border-0 shadow-sm rounded-4 h-100 bg-white">
            <div class="card-body p-4">
                <div class="d-flex align-items-center justify-content-between mb-3">
                    <div class="bg-secondary bg-opacity-10 text-secondary rounded-3 p-3">
                        <i class="bi bi-people fs-4"></i>
                    </div>
                </div>
                <h6 class="text-muted text-uppercase fw-bold mb-1 small">Customers</h6>
                <h3 class="fw-bold mb-0 font-mono">{{ number_format($stats['total_customers']) }}</h3>
            </div>
        </div>
    </div>
</div>

<div class="row g-4">
    <div class="col-12">
        <div class="card border-0 shadow-sm rounded-4 bg-white">
            <div class="card-header bg-white p-4 border-bottom d-flex justify-content-between align-items-center">
                <h5 class="fw-bold mb-0">Recent Orders</h5>
                <a href="{{ route('admin.orders.index') }}" class="btn btn-sm btn-outline-primary rounded-pill px-3">View All</a>
            </div>
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-light">
                        <tr>
                            <th class="ps-4 py-3 text-muted text-uppercase small fw-bold border-0">Order ID</th>
                            <th class="py-3 text-muted text-uppercase small fw-bold border-0">Customer</th>
                            <th class="py-3 text-muted text-uppercase small fw-bold border-0">Amount</th>
                            <th class="py-3 text-muted text-uppercase small fw-bold border-0">Status</th>
                            <th class="py-3 text-muted text-uppercase small fw-bold border-0">Date</th>
                            <th class="pe-4 py-3 border-0 text-end">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($recentOrders as $order)
                        <tr>
                            <td class="ps-4 py-3"><span class="fw-bold text-primary font-mono">{{ $order->order_number }}</span></td>
                            <td class="py-3">
                                <div class="d-flex align-items-center gap-2">
                                    <div class="avatar bg-light text-primary rounded-circle d-flex align-items-center justify-content-center" style="width: 32px; height: 32px; font-size: 14px;">
                                        {{ substr($order->user->name ?? 'U', 0, 1) }}
                                    </div>
                                    <div>
                                        <div class="fw-medium">{{ $order->user->name ?? 'Unknown User' }}</div>
                                        <div class="small text-muted">{{ $order->delivery_city }}</div>
                                    </div>
                                </div>
                            </td>
                            <td class="py-3 fw-bold font-mono">KES {{ number_format($order->total_amount) }}</td>
                            <td class="py-3">
                                <span class="badge badge-{{ $order->order_status }} text-capitalize px-3 py-2 rounded-pill">
                                    {{ str_replace('_', ' ', $order->order_status) }}
                                </span>
                            </td>
                            <td class="py-3 text-muted small">
                                {{ $order->created_at->diffForHumans() }}
                            </td>
                            <td class="pe-4 py-3 text-end">
                                <a href="{{ route('admin.orders.show', $order) }}" class="btn btn-sm btn-light rounded-pill px-3">Manage</a>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="text-center py-5 text-muted">
                                <i class="bi bi-inbox fs-2 mb-3 d-block text-black-50"></i>
                                No recent orders.
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
