@extends('layouts.admin')

@section('page-title', 'Business Reports')

@section('content')
<div class="row g-4 mb-4">
    <div class="col-sm-4">
        <div class="card border-0 shadow-sm rounded-4 h-100 bg-white">
            <div class="card-body p-4 text-center">
                <h6 class="text-muted text-uppercase small fw-bold mb-3">Total Sales Revenue</h6>
                <h2 class="fw-bold mb-0 text-success font-mono">KES {{ number_format($totalSales) }}</h2>
            </div>
        </div>
    </div>
    <div class="col-sm-4">
        <div class="card border-0 shadow-sm rounded-4 h-100 bg-white">
            <div class="card-body p-4 text-center">
                <h6 class="text-muted text-uppercase small fw-bold mb-3">Total Orders Placed</h6>
                <h2 class="fw-bold mb-0 text-primary font-mono">{{ number_format($totalOrders) }}</h2>
            </div>
        </div>
    </div>
    <div class="col-sm-4">
        <div class="card border-0 shadow-sm rounded-4 h-100 bg-white">
            <div class="card-body p-4 text-center">
                <h6 class="text-muted text-uppercase small fw-bold mb-3">Successful Deliveries</h6>
                <h2 class="fw-bold mb-0 text-info font-mono">{{ number_format($successfulDeliveries) }}</h2>
            </div>
        </div>
    </div>
</div>

<div class="card border-0 shadow-sm rounded-4 bg-white mb-4">
    <div class="card-header bg-white p-4 border-bottom">
        <h5 class="fw-bold mb-0">Recent Order Activity</h5>
    </div>
    <div class="table-responsive">
        <table class="table align-middle mb-0">
            <thead class="table-light">
                <tr>
                    <th class="ps-4 py-3 border-0">Order ID</th>
                    <th class="py-3 border-0">Customer</th>
                    <th class="py-3 border-0">Amount</th>
                    <th class="py-3 border-0">Status</th>
                    <th class="pe-4 py-3 border-0 text-end">Date</th>
                </tr>
            </thead>
            <tbody>
                @forelse($recentOrders as $order)
                <tr>
                    <td class="ps-4 py-3 fw-bold text-primary font-mono">#{{ $order->order_number }}</td>
                    <td class="py-3">{{ $order->user->name ?? 'Unknown' }}</td>
                    <td class="py-3 font-mono fw-medium">KES {{ number_format($order->total_amount) }}</td>
                    <td class="py-3">
                        <span class="badge bg-{{ $order->order_status == 'delivered' ? 'success' : 'warning' }} text-capitalize px-2 py-1 rounded-pill">
                            {{ str_replace('_', ' ', $order->order_status) }}
                        </span>
                    </td>
                    <td class="pe-4 py-3 text-end text-muted small">{{ $order->created_at->format('M d, Y') }}</td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="text-center py-4 text-muted">No orders found.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
