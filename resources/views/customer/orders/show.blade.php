@extends('layouts.customer')

@section('title', 'Order Details')

@section('content')
<div class="row mb-4 align-items-center">
    <div class="col-md-6">
        <a href="{{ route('customer.orders.index') }}" class="text-decoration-none text-muted small fw-bold mb-2 d-inline-block"><i class="bi bi-arrow-left me-1"></i> Back to Orders</a>
        <h2 class="fw-bold mb-1">Order <span class="text-primary font-mono">#{{ $order->order_number }}</span></h2>
        <p class="text-muted">Placed on {{ $order->created_at->format('l, F j, Y \a\t h:i A') }}</p>
    </div>
    <div class="col-md-6 text-md-end mt-3 mt-md-0">
        <span class="badge badge-{{ $order->order_status }} fs-6 px-4 py-2 text-capitalize rounded-pill">
            {{ str_replace('_', ' ', $order->order_status) }}
        </span>
    </div>
</div>

<div class="row g-4">
    <div class="col-lg-8">
        <!-- Items -->
        <div class="card border-0 shadow-sm rounded-4 mb-4">
            <div class="card-header bg-white p-4 border-bottom">
                <h5 class="fw-bold mb-0">Items in Order</h5>
            </div>
            <div class="card-body p-0">
                <ul class="list-group list-group-flush">
                    @foreach($order->items as $item)
                    <li class="list-group-item p-4 border-light">
                        <div class="d-flex justify-content-between align-items-center">
                            <div class="d-flex align-items-center gap-3">
                                <div class="bg-light rounded-3 d-flex align-items-center justify-content-center p-2" style="width: 50px; height: 50px;">
                                    <i class="bi bi-droplet text-primary fs-4"></i>
                                </div>
                                <div>
                                    <h6 class="mb-1 fw-bold">{{ $item->product_name }}</h6>
                                    <span class="text-muted small">Qty: {{ $item->quantity }} &times; KES {{ number_format($item->product_price) }}</span>
                                </div>
                            </div>
                            <span class="fw-bold font-mono">KES {{ number_format($item->subtotal) }}</span>
                        </div>
                    </li>
                    @endforeach
                </ul>
            </div>
            <div class="card-footer bg-light p-4 border-0 rounded-bottom-4">
                <div class="row">
                    <div class="col-md-6 offset-md-6">
                        <div class="d-flex justify-content-between mb-2">
                            <span class="text-muted">Subtotal</span>
                            <span class="fw-medium font-mono">KES {{ number_format($order->subtotal) }}</span>
                        </div>
                        <div class="d-flex justify-content-between mb-3">
                            <span class="text-muted">Delivery Fee ({{ $order->zone->name ?? 'Standard' }})</span>
                            <span class="fw-medium font-mono">KES {{ number_format($order->delivery_fee) }}</span>
                        </div>
                        @if($order->discount > 0)
                        <div class="d-flex justify-content-between mb-3 text-success">
                            <span>Discount</span>
                            <span class="fw-medium font-mono">- KES {{ number_format($order->discount) }}</span>
                        </div>
                        @endif
                        <div class="d-flex justify-content-between align-items-center pt-3 border-top border-secondary border-opacity-25">
                            <span class="fs-5 fw-bold">Total Amount</span>
                            <span class="fs-4 fw-bold font-mono text-primary">KES {{ number_format($order->total_amount) }}</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-lg-4">
        <!-- Payment Info -->
        <div class="card border-0 shadow-sm rounded-4 mb-4">
            <div class="card-body p-4">
                <h6 class="text-muted text-uppercase small fw-bold mb-3">Payment Details</h6>
                <div class="d-flex align-items-center gap-3 mb-3">
                    <div class="bg-light rounded-circle d-flex align-items-center justify-content-center" style="width: 40px; height: 40px;">
                        @if($order->payment_method == 'mpesa')
                            <i class="bi bi-phone text-success fs-5"></i>
                        @else
                            <i class="bi bi-cash-stack text-primary fs-5"></i>
                        @endif
                    </div>
                    <div>
                        <h6 class="mb-0 fw-bold text-capitalize">{{ $order->payment_method }}</h6>
                        <span class="badge bg-{{ $order->payment_status == 'paid' ? 'success' : ($order->payment_status == 'pending' ? 'warning' : 'danger') }} text-capitalize mt-1">
                            {{ $order->payment_status }}
                        </span>
                    </div>
                </div>
                
                @if($order->payment_method == 'mpesa' && $order->payment_status == 'pending')
                    <a href="{{ route('customer.checkout.success', $order) }}" class="btn btn-outline-success btn-sm w-100 rounded-pill mt-2">Complete Payment</a>
                @endif
            </div>
        </div>

        <!-- Delivery Info -->
        <div class="card border-0 shadow-sm rounded-4">
            <div class="card-body p-4">
                <h6 class="text-muted text-uppercase small fw-bold mb-3">Delivery Information</h6>
                
                <div class="mb-4">
                    <div class="d-flex gap-2">
                        <i class="bi bi-geo-alt text-primary mt-1"></i>
                        <div>
                            <p class="mb-1 fw-medium">{{ $order->delivery_address }}</p>
                            <p class="text-muted small mb-0">{{ $order->delivery_city }}</p>
                        </div>
                    </div>
                </div>
                
                @if($order->notes)
                <div class="mb-4">
                    <h6 class="text-muted text-uppercase small fw-bold mb-2">Notes</h6>
                    <p class="small bg-light p-3 rounded-3 mb-0 border">{{ $order->notes }}</p>
                </div>
                @endif
                
                <h6 class="text-muted text-uppercase small fw-bold mb-3">Driver Details</h6>
                @if($order->delivery && $order->delivery->driver)
                    <div class="d-flex align-items-center gap-3 bg-light p-3 rounded-3 border">
                        <div class="avatar bg-primary text-white rounded-circle">
                            {{ substr($order->delivery->driver->name, 0, 1) }}
                        </div>
                        <div>
                            <h6 class="mb-0 fw-bold">{{ $order->delivery->driver->name }}</h6>
                            <a href="tel:{{ $order->delivery->driver->phone }}" class="small text-decoration-none"><i class="bi bi-telephone-fill me-1"></i> Call Driver</a>
                        </div>
                    </div>
                @else
                    <div class="p-3 bg-light rounded-3 border text-center text-muted small">
                        <i class="bi bi-hourglass-split mb-2 fs-4 d-block"></i>
                        Driver will be assigned once order is confirmed.
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
