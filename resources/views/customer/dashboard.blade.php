@extends('layouts.customer')

@section('title', 'Dashboard')

@section('content')
<div class="row mb-4 align-items-center">
    <div class="col-md-8">
        <h2 class="fw-bold mb-1">{{ $greeting }}, {{ explode(' ', $user->name)[0] }}!</h2>
        <p class="text-muted">Welcome back to your Tsavo Water portal.</p>
    </div>
    <div class="col-md-4 text-md-end">
        <a href="{{ route('customer.products.index') }}" class="btn btn-primary rounded-pill px-4 shadow-sm">
            <i class="bi bi-droplet-fill me-1"></i> Order Water
        </a>
    </div>
</div>

@if($activeOrder)
    <!-- Active Order Tracking -->
    <div class="card border-0 shadow-sm rounded-4 mb-5 overflow-hidden">
        <div class="card-header bg-primary text-white p-4 border-0">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h5 class="mb-0 fw-bold">Active Delivery</h5>
                    <small class="text-white-50">Order #{{ $activeOrder->order_number }}</small>
                </div>
                <span class="badge bg-white text-primary px-3 py-2 rounded-pill fs-6 text-capitalize">
                    {{ str_replace('_', ' ', $activeOrder->order_status) }}
                </span>
            </div>
        </div>
        <div class="card-body p-4 p-md-5">
            <!-- Timeline -->
            <div class="position-relative mb-5" style="max-width: 800px; margin: 0 auto;">
                <div class="progress" style="height: 4px; background-color: #e9ecef; margin-top: 24px;">
                    @php
                        $statuses = ['pending' => 0, 'confirmed' => 25, 'processing' => 50, 'out_for_delivery' => 75, 'delivered' => 100];
                        $progress = $statuses[$activeOrder->order_status] ?? 0;
                        if($activeOrder->order_status == 'assigned') $progress = 60;
                    @endphp
                    <div class="progress-bar bg-success" role="progressbar" style="width: {{ $progress }}%" aria-valuenow="{{ $progress }}" aria-valuemin="0" aria-valuemax="100"></div>
                </div>
                
                <div class="d-flex justify-content-between position-absolute top-0 w-100">
                    <!-- Step 1 -->
                    <div class="text-center" style="width: 80px; margin-left: -40px;">
                        <div class="rounded-circle d-flex align-items-center justify-content-center mx-auto mb-2 {{ $progress >= 0 ? 'bg-success text-white' : 'bg-light border text-muted' }}" style="width: 50px; height: 50px; border: 4px solid white; box-shadow: 0 0 0 2px #fff;">
                            <i class="bi bi-receipt fs-5"></i>
                        </div>
                        <small class="fw-bold {{ $progress >= 0 ? 'text-success' : 'text-muted' }}">Placed</small>
                    </div>
                    
                    <!-- Step 2 -->
                    <div class="text-center" style="width: 80px; margin-left: -40px;">
                        <div class="rounded-circle d-flex align-items-center justify-content-center mx-auto mb-2 {{ $progress >= 25 ? 'bg-success text-white' : 'bg-light border text-muted' }}" style="width: 50px; height: 50px; border: 4px solid white; box-shadow: 0 0 0 2px #fff;">
                            <i class="bi bi-check2-circle fs-5"></i>
                        </div>
                        <small class="fw-bold {{ $progress >= 25 ? 'text-success' : 'text-muted' }}">Confirmed</small>
                    </div>
                    
                    <!-- Step 3 -->
                    <div class="text-center" style="width: 80px; margin-left: -40px;">
                        <div class="rounded-circle d-flex align-items-center justify-content-center mx-auto mb-2 {{ $progress >= 75 ? 'bg-success text-white' : 'bg-light border text-muted' }}" style="width: 50px; height: 50px; border: 4px solid white; box-shadow: 0 0 0 2px #fff;">
                            <i class="bi bi-truck fs-5"></i>
                        </div>
                        <small class="fw-bold {{ $progress >= 75 ? 'text-success' : 'text-muted' }}">On the way</small>
                    </div>
                    
                    <!-- Step 4 -->
                    <div class="text-center" style="width: 80px; margin-right: -40px;">
                        <div class="rounded-circle d-flex align-items-center justify-content-center mx-auto mb-2 {{ $progress == 100 ? 'bg-success text-white' : 'bg-light border text-muted' }}" style="width: 50px; height: 50px; border: 4px solid white; box-shadow: 0 0 0 2px #fff;">
                            <i class="bi bi-house-door fs-5"></i>
                        </div>
                        <small class="fw-bold {{ $progress == 100 ? 'text-success' : 'text-muted' }}">Delivered</small>
                    </div>
                </div>
            </div>
            
            <hr class="my-4 border-light">
            
            <div class="row align-items-center">
                <div class="col-md-6 mb-3 mb-md-0">
                    <h6 class="text-muted text-uppercase small fw-bold mb-2">Delivery Details</h6>
                    <p class="mb-1 fw-medium"><i class="bi bi-geo-alt text-primary me-2"></i> {{ $activeOrder->delivery_address }}</p>
                    <p class="mb-0 text-muted small ms-4">{{ $activeOrder->delivery_city }}</p>
                </div>
                <div class="col-md-6 text-md-end">
                    @if($activeOrder->delivery && $activeOrder->delivery->driver)
                        <div class="d-inline-flex align-items-center p-3 bg-light rounded-3 text-start border">
                            <div class="avatar bg-primary text-white rounded-circle me-3">
                                {{ substr($activeOrder->delivery->driver->name, 0, 1) }}
                            </div>
                            <div>
                                <small class="text-muted d-block">Your Driver</small>
                                <span class="fw-bold">{{ $activeOrder->delivery->driver->name }}</span>
                                <a href="tel:{{ $activeOrder->delivery->driver->phone }}" class="d-block small text-decoration-none"><i class="bi bi-telephone-fill me-1"></i> Call Driver</a>
                            </div>
                        </div>
                    @else
                        <div class="p-3 bg-light rounded-3 text-center border text-muted">
                            <i class="bi bi-hourglass-split mb-1 fs-5 d-block"></i>
                            <small>Assigning nearest driver...</small>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endif

<div class="row g-4 mb-5">
    <!-- Stats -->
    <div class="col-md-4">
        <div class="card border-0 shadow-sm rounded-4 h-100 p-4 bg-primary text-white">
            <div class="d-flex justify-content-between align-items-start mb-3">
                <div>
                    <h6 class="text-white-50 text-uppercase fw-bold mb-1">Total Spent</h6>
                    <h2 class="fw-bold mb-0 font-mono">KES {{ number_format($stats['total_spent']) }}</h2>
                </div>
                <div class="bg-white bg-opacity-25 rounded-3 p-2">
                    <i class="bi bi-wallet2 fs-4"></i>
                </div>
            </div>
            <p class="mb-0 small text-white-50 mt-auto">Across {{ $stats['total_orders'] }} total orders</p>
        </div>
    </div>
    
    <div class="col-md-4">
        <div class="card border-0 shadow-sm rounded-4 h-100 p-4">
            <div class="d-flex justify-content-between align-items-start mb-3">
                <div>
                    <h6 class="text-muted text-uppercase fw-bold mb-1">Delivered Orders</h6>
                    <h2 class="fw-bold text-dark mb-0 font-mono">{{ $stats['delivered_orders'] }}</h2>
                </div>
                <div class="bg-success bg-opacity-10 text-success rounded-3 p-2">
                    <i class="bi bi-check-circle fs-4"></i>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Reorder Quick Action -->
    <div class="col-md-4">
        <div class="card border-0 shadow-sm rounded-4 h-100 p-4 bg-light text-center d-flex flex-column justify-content-center">
            @if($lastOrder)
                <h6 class="text-muted text-uppercase fw-bold mb-3">Quick Reorder</h6>
                <p class="small text-muted mb-3">Reorder your last purchase of <strong>KES {{ number_format($lastOrder->total_amount) }}</strong></p>
                <form action="{{ route('customer.cart.store') }}" method="POST">
                    @csrf
                    <!-- Just adding the first item for simplicity in quick reorder demo -->
                    @if($lastOrder->items->count() > 0)
                        <input type="hidden" name="product_id" value="{{ $lastOrder->items->first()->product_id }}">
                        <input type="hidden" name="quantity" value="{{ $lastOrder->items->first()->quantity }}">
                        <button type="submit" class="btn btn-outline-primary rounded-pill w-100">Reorder Now</button>
                    @endif
                </form>
            @else
                <div class="text-muted">
                    <i class="bi bi-bag-x fs-1 mb-2 d-block"></i>
                    <p class="mb-0 fw-medium">No previous orders</p>
                </div>
            @endif
        </div>
    </div>
</div>

<!-- Recent Orders Table -->
<div class="card border-0 shadow-sm rounded-4">
    <div class="card-header bg-white p-4 border-0 d-flex justify-content-between align-items-center">
        <h5 class="mb-0 fw-bold">Recent Orders</h5>
        <a href="#" class="btn btn-sm btn-light">View All</a>
    </div>
    <div class="table-responsive">
        <table class="table table-hover align-middle mb-0">
            <thead class="table-light">
                <tr>
                    <th class="ps-4 text-muted font-heading fw-bold">Order #</th>
                    <th class="text-muted font-heading fw-bold">Date</th>
                    <th class="text-muted font-heading fw-bold">Items</th>
                    <th class="text-muted font-heading fw-bold">Total</th>
                    <th class="text-muted font-heading fw-bold">Status</th>
                    <th class="pe-4"></th>
                </tr>
            </thead>
            <tbody>
                @forelse($recentOrders as $order)
                <tr>
                    <td class="ps-4"><span class="fw-bold text-primary font-mono">{{ $order->order_number }}</span></td>
                    <td>{{ $order->created_at->format('M d, Y') }}</td>
                    <td>{{ $order->items->sum('quantity') }} items</td>
                    <td class="fw-medium font-mono">KES {{ number_format($order->total_amount) }}</td>
                    <td>
                        <span class="badge badge-{{ $order->order_status }} text-capitalize">
                            {{ str_replace('_', ' ', $order->order_status) }}
                        </span>
                    </td>
                    <td class="pe-4 text-end">
                        <a href="#" class="btn btn-sm btn-outline-secondary rounded-pill">Details</a>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="text-center py-5 text-muted">
                        <i class="bi bi-inbox fs-2 mb-3 d-block text-black-50"></i>
                        No orders found. <a href="{{ route('customer.products.index') }}">Start shopping!</a>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

@endsection
