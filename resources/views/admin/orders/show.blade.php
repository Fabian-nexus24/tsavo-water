@extends('layouts.admin')

@section('page-title', 'Order Details')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <a href="{{ route('admin.orders.index') }}" class="text-decoration-none text-muted small fw-bold"><i class="bi bi-arrow-left me-1"></i> Back to Orders</a>
    <div class="d-flex gap-2">
        <a href="{{ route('admin.orders.invoice', $order) }}" class="btn btn-primary btn-sm rounded-pill px-3"><i class="bi bi-file-earmark-pdf me-1"></i> Download Invoice</a>
    </div>
</div>

<div class="row g-4">
    <div class="col-lg-8">
        <!-- Order Header -->
        <div class="card border-0 shadow-sm rounded-4 mb-4 bg-white">
            <div class="card-body p-4 p-md-5">
                <div class="row align-items-center">
                    <div class="col-md-6 mb-3 mb-md-0">
                        <h3 class="fw-bold mb-1">Order <span class="text-primary font-mono">#{{ $order->order_number }}</span></h3>
                        <p class="text-muted mb-0">Placed on {{ $order->created_at->format('M d, Y \a\t H:i') }}</p>
                    </div>
                    <div class="col-md-6 text-md-end">
                        <form action="{{ route('admin.orders.status', $order) }}" method="POST" class="d-inline-flex align-items-center gap-2">
                            @csrf
                            @method('PATCH')
                            <label class="small text-muted text-uppercase fw-bold">Status:</label>
                            <select name="status" class="form-select form-select-sm rounded-pill fw-bold" style="width: auto;" onchange="this.form.submit()">
                                @php $statuses = ['pending', 'confirmed', 'processing', 'assigned', 'out_for_delivery', 'delivered', 'cancelled']; @endphp
                                @foreach($statuses as $status)
                                    <option value="{{ $status }}" {{ $order->order_status == $status ? 'selected' : '' }}>
                                        {{ str_replace('_', ' ', strtoupper($status)) }}
                                    </option>
                                @endforeach
                            </select>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Items -->
        <div class="card border-0 shadow-sm rounded-4 mb-4 bg-white">
            <div class="card-header bg-white p-4 border-bottom">
                <h5 class="fw-bold mb-0">Order Items</h5>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table align-middle mb-0">
                        <thead class="table-light">
                            <tr>
                                <th class="ps-4 py-3 text-muted text-uppercase small fw-bold border-0">Product</th>
                                <th class="py-3 text-muted text-uppercase small fw-bold border-0 text-center">Qty</th>
                                <th class="py-3 text-muted text-uppercase small fw-bold border-0 text-end">Price</th>
                                <th class="pe-4 py-3 text-muted text-uppercase small fw-bold border-0 text-end">Total</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($order->items as $item)
                            <tr>
                                <td class="ps-4 py-3 border-light">
                                    <div class="fw-bold">{{ $item->product_name }}</div>
                                </td>
                                <td class="py-3 border-light text-center">{{ $item->quantity }}</td>
                                <td class="py-3 border-light text-end">KES {{ number_format($item->product_price) }}</td>
                                <td class="pe-4 py-3 border-light text-end fw-bold font-mono">KES {{ number_format($item->subtotal) }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="card-footer bg-light p-4 border-0 rounded-bottom-4">
                <div class="row">
                    <div class="col-md-5 offset-md-7">
                        <div class="d-flex justify-content-between mb-2">
                            <span class="text-muted">Subtotal</span>
                            <span class="fw-medium font-mono">KES {{ number_format($order->subtotal) }}</span>
                        </div>
                        <div class="d-flex justify-content-between mb-3">
                            <span class="text-muted">Delivery Fee</span>
                            <span class="fw-medium font-mono">KES {{ number_format($order->delivery_fee) }}</span>
                        </div>
                        <div class="d-flex justify-content-between align-items-center pt-3 border-top border-secondary border-opacity-25">
                            <span class="fs-6 fw-bold">Total Amount</span>
                            <span class="fs-5 fw-bold font-mono text-primary">KES {{ number_format($order->total_amount) }}</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-lg-4">
        <!-- Customer Info -->
        <div class="card border-0 shadow-sm rounded-4 mb-4 bg-white">
            <div class="card-body p-4">
                <h6 class="text-muted text-uppercase small fw-bold mb-4">Customer Details</h6>
                <div class="d-flex align-items-center gap-3 mb-4">
                    <div class="avatar bg-primary text-white rounded-circle d-flex align-items-center justify-content-center" style="width: 50px; height: 50px;">
                        {{ substr($order->user->name ?? 'U', 0, 1) }}
                    </div>
                    <div>
                        <h6 class="mb-0 fw-bold">{{ $order->user->name ?? 'Unknown User' }}</h6>
                        <span class="text-muted small">{{ $order->user->email ?? 'N/A' }}</span>
                    </div>
                </div>
                
                <div class="mb-3">
                    <small class="text-muted text-uppercase fw-bold d-block mb-1">Phone</small>
                    <div class="fw-medium">{{ $order->user->phone ?? 'N/A' }}</div>
                </div>
                
                <div class="mb-3">
                    <small class="text-muted text-uppercase fw-bold d-block mb-1">Delivery Address</small>
                    <div class="fw-medium">{{ $order->delivery_address }}</div>
                    <div class="text-muted small">{{ $order->delivery_city }} (Zone: {{ $order->zone->name ?? 'Standard' }})</div>
                </div>
                
                @if($order->notes)
                <div>
                    <small class="text-muted text-uppercase fw-bold d-block mb-1">Customer Notes</small>
                    <div class="small bg-light p-3 rounded-3 border">{{ $order->notes }}</div>
                </div>
                @endif
            </div>
        </div>

        <!-- Payment Info -->
        <div class="card border-0 shadow-sm rounded-4 mb-4 bg-white">
            <div class="card-body p-4">
                <h6 class="text-muted text-uppercase small fw-bold mb-3">Payment Info</h6>
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <div class="fw-bold text-capitalize">{{ $order->payment_method }}</div>
                        <div class="small text-muted">{{ $order->payment->transaction_code ?? '' }}</div>
                    </div>
                    <span class="badge bg-{{ $order->payment_status == 'paid' ? 'success' : 'warning' }} text-capitalize px-3 py-2 rounded-pill">
                        {{ $order->payment_status }}
                    </span>
                </div>
            </div>
        </div>

        <!-- Driver Info -->
        <div class="card border-0 shadow-sm rounded-4 bg-white">
            <div class="card-body p-4">
                <h6 class="text-muted text-uppercase small fw-bold mb-3">Driver Assignment</h6>
                
                @if($order->delivery && $order->delivery->driver)
                    <div class="d-flex align-items-center justify-content-between bg-light p-3 rounded-3 border mb-3">
                        <div class="d-flex align-items-center gap-2">
                            <div class="avatar bg-secondary text-white rounded-circle d-flex align-items-center justify-content-center" style="width: 30px; height: 30px; font-size: 12px;">
                                {{ substr($order->delivery->driver->name, 0, 1) }}
                            </div>
                            <div>
                                <h6 class="mb-0 fw-bold fs-6">{{ $order->delivery->driver->name }}</h6>
                                <span class="badge bg-{{ $order->delivery->status == 'delivered' ? 'success' : 'primary' }} small">
                                    {{ $order->delivery->status }}
                                </span>
                            </div>
                        </div>
                    </div>
                @endif
                
                <form action="{{ route('admin.orders.assign', $order) }}" method="POST">
                    @csrf
                    @method('PATCH')
                    <div class="input-group input-group-sm">
                        <select name="driver_id" class="form-select" required>
                            <option value="">Reassign Driver</option>
                            @foreach($drivers as $driver)
                                <option value="{{ $driver->id }}" {{ ($order->delivery->driver_id ?? '') == $driver->id ? 'selected' : '' }}>
                                    {{ $driver->name }}
                                </option>
                            @endforeach
                        </select>
                        <button type="submit" class="btn btn-primary">Assign</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
