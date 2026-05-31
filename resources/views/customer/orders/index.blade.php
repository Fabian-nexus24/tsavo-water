@extends('layouts.customer')

@section('title', 'My Orders')

@section('content')
<div class="row mb-4">
    <div class="col-12">
        <h2 class="fw-bold mb-1">My Orders</h2>
        <p class="text-muted">Track your deliveries and view past purchases.</p>
    </div>
</div>

<div class="card border-0 shadow-sm rounded-4">
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0 border-white">
                <thead class="table-light">
                    <tr>
                        <th class="ps-4 py-3 text-muted text-uppercase small fw-bold border-0">Order #</th>
                        <th class="py-3 text-muted text-uppercase small fw-bold border-0">Date</th>
                        <th class="py-3 text-muted text-uppercase small fw-bold border-0">Status</th>
                        <th class="py-3 text-muted text-uppercase small fw-bold border-0">Payment</th>
                        <th class="py-3 text-muted text-uppercase small fw-bold border-0">Total</th>
                        <th class="pe-4 py-3 border-0"></th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($orders as $order)
                    <tr>
                        <td class="ps-4 py-4 border-light">
                            <span class="fw-bold text-primary font-mono">{{ $order->order_number }}</span>
                        </td>
                        <td class="py-4 border-light text-muted">
                            {{ $order->created_at->format('M d, Y') }}<br>
                            <small>{{ $order->created_at->format('h:i A') }}</small>
                        </td>
                        <td class="py-4 border-light">
                            <span class="badge badge-{{ $order->order_status }} text-capitalize px-3 py-2">
                                {{ str_replace('_', ' ', $order->order_status) }}
                            </span>
                        </td>
                        <td class="py-4 border-light">
                            <div class="d-flex align-items-center gap-2">
                                @if($order->payment_method == 'mpesa')
                                    <i class="bi bi-phone text-success"></i>
                                @else
                                    <i class="bi bi-cash-stack text-muted"></i>
                                @endif
                                <span class="text-capitalize small">{{ $order->payment_status }}</span>
                            </div>
                        </td>
                        <td class="py-4 border-light fw-bold font-mono text-dark">
                            KES {{ number_format($order->total_amount) }}
                        </td>
                        <td class="pe-4 py-4 border-light text-end">
                            <a href="{{ route('customer.orders.show', $order) }}" class="btn btn-sm btn-outline-primary rounded-pill px-3">View Details</a>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="text-center py-5">
                            <div class="bg-light rounded-circle d-inline-flex align-items-center justify-content-center mb-3" style="width: 80px; height: 80px;">
                                <i class="bi bi-receipt fs-2 text-muted"></i>
                            </div>
                            <h5 class="fw-bold">No orders found</h5>
                            <p class="text-muted mb-4">You haven't placed any orders yet.</p>
                            <a href="{{ route('customer.products.index') }}" class="btn btn-primary rounded-pill px-4">Start Shopping</a>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    @if($orders->hasPages())
    <div class="card-footer bg-white p-4 border-0 border-top">
        {{ $orders->links() }}
    </div>
    @endif
</div>
@endsection
