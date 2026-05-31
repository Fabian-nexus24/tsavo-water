@extends('layouts.driver')

@section('page-title', 'Delivery Details')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <a href="{{ url()->previous() }}" class="text-decoration-none text-muted small fw-bold"><i class="bi bi-arrow-left me-1"></i> Back</a>
</div>

<div class="row g-4">
    <!-- Action Panel -->
    <div class="col-lg-4 order-lg-2">
        <div class="card border-0 shadow-sm rounded-4 mb-4 bg-white">
            <div class="card-header bg-white p-4 border-bottom text-center">
                <span class="badge badge-{{ $delivery->status == 'failed' ? 'danger' : ($delivery->status == 'delivered' ? 'success' : 'primary') }} text-capitalize px-3 py-2 rounded-pill mb-2">
                    {{ str_replace('_', ' ', $delivery->status) }}
                </span>
                <h4 class="fw-bold mb-0">Delivery Status</h4>
            </div>
            <div class="card-body p-4">
                
                @if($delivery->status == 'assigned')
                    <p class="text-center text-muted small mb-4">You have been assigned this delivery. Mark it as picked up once you have loaded the items.</p>
                    <form action="{{ route('driver.deliveries.pickup', $delivery) }}" method="POST">
                        @csrf @method('PATCH')
                        <button type="submit" class="btn btn-warning w-100 py-3 rounded-pill fw-bold text-dark">
                            <i class="bi bi-box-arrow-up me-2"></i> Mark as Picked Up
                        </button>
                    </form>
                
                @elseif($delivery->status == 'picked_up')
                    <p class="text-center text-muted small mb-4">You are currently out for delivery. Mark as completed once handed over.</p>
                    
                    <form action="{{ route('driver.deliveries.deliver', $delivery) }}" method="POST" class="mb-3">
                        @csrf @method('PATCH')
                        <button type="submit" class="btn btn-success w-100 py-3 rounded-pill fw-bold">
                            <i class="bi bi-check-circle-fill me-2"></i> Mark as Delivered
                        </button>
                    </form>
                    
                    <button type="button" class="btn btn-outline-danger w-100 py-2 rounded-pill fw-bold mt-2" data-bs-toggle="modal" data-bs-target="#failModal">
                        Report Issue / Failed Delivery
                    </button>
                    
                    <!-- Fail Modal -->
                    <div class="modal fade" id="failModal" tabindex="-1" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered">
                            <div class="modal-content rounded-4 border-0 shadow">
                                <div class="modal-header border-0 pb-0">
                                    <h5 class="modal-title fw-bold text-danger">Report Delivery Failure</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <form action="{{ route('driver.deliveries.fail', $delivery) }}" method="POST">
                                    @csrf @method('PATCH')
                                    <div class="modal-body">
                                        <p class="small text-muted">Please provide a reason why this delivery failed (e.g., customer unreachable, wrong address).</p>
                                        <textarea name="notes" class="form-control" rows="3" required placeholder="Reason for failure..."></textarea>
                                    </div>
                                    <div class="modal-footer border-0 pt-0">
                                        <button type="button" class="btn btn-light rounded-pill px-4" data-bs-dismiss="modal">Cancel</button>
                                        <button type="submit" class="btn btn-danger rounded-pill px-4">Submit Report</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                
                @elseif($delivery->status == 'delivered')
                    <div class="text-center py-4 text-success">
                        <i class="bi bi-check-circle-fill" style="font-size: 4rem;"></i>
                        <h5 class="fw-bold mt-3">Successfully Delivered</h5>
                        <p class="text-muted small mb-0">Delivered on {{ $delivery->delivered_at->format('M d, Y h:i A') }}</p>
                    </div>
                @elseif($delivery->status == 'failed')
                    <div class="text-center py-4 text-danger">
                        <i class="bi bi-x-circle-fill" style="font-size: 4rem;"></i>
                        <h5 class="fw-bold mt-3">Delivery Failed</h5>
                        <div class="bg-light p-3 rounded-3 mt-3 text-start">
                            <small class="text-muted fw-bold d-block text-uppercase">Reason</small>
                            <span class="small text-dark">{{ $delivery->notes }}</span>
                        </div>
                    </div>
                @endif
                
            </div>
        </div>

        <div class="card border-0 shadow-sm rounded-4 bg-white">
            <div class="card-body p-4 text-center">
                <a href="tel:{{ $delivery->order->user->phone }}" class="btn btn-outline-primary rounded-pill w-100 py-2 fw-bold">
                    <i class="bi bi-telephone-fill me-2"></i> Call Customer
                </a>
                <a href="https://maps.google.com/?q={{ urlencode($delivery->order->delivery_address . ' ' . $delivery->order->delivery_city) }}" target="_blank" class="btn btn-primary rounded-pill w-100 py-2 fw-bold mt-3">
                    <i class="bi bi-geo-alt-fill me-2"></i> Open in Maps
                </a>
            </div>
        </div>
    </div>

    <!-- Order Details -->
    <div class="col-lg-8 order-lg-1">
        <!-- Customer Info -->
        <div class="card border-0 shadow-sm rounded-4 mb-4 bg-white">
            <div class="card-header bg-white p-4 border-bottom">
                <h5 class="fw-bold mb-0">Customer & Destination</h5>
            </div>
            <div class="card-body p-4">
                <div class="row">
                    <div class="col-md-6 mb-4 mb-md-0">
                        <small class="text-muted text-uppercase fw-bold d-block mb-2">Customer</small>
                        <h6 class="fw-bold mb-1">{{ $delivery->order->user->name ?? 'Unknown' }}</h6>
                        <div class="text-muted">{{ $delivery->order->user->phone ?? 'No Phone' }}</div>
                    </div>
                    <div class="col-md-6">
                        <small class="text-muted text-uppercase fw-bold d-block mb-2">Delivery Address</small>
                        <div class="fw-medium">{{ $delivery->order->delivery_address }}</div>
                        <div class="text-muted small">{{ $delivery->order->delivery_city }} (Zone: {{ $delivery->order->zone->name ?? 'Standard' }})</div>
                    </div>
                </div>
                
                @if($delivery->order->notes)
                <div class="mt-4 bg-light p-3 rounded-3 border">
                    <small class="text-muted text-uppercase fw-bold d-block mb-1">Delivery Notes</small>
                    <div class="small fw-medium">{{ $delivery->order->notes }}</div>
                </div>
                @endif
            </div>
        </div>

        <!-- Items to Deliver -->
        <div class="card border-0 shadow-sm rounded-4 mb-4 bg-white">
            <div class="card-header bg-white p-4 border-bottom">
                <h5 class="fw-bold mb-0">Items to Deliver (Order <span class="text-primary font-mono">#{{ $delivery->order->order_number }}</span>)</h5>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table align-middle mb-0">
                        <thead class="table-light">
                            <tr>
                                <th class="ps-4 py-3 text-muted text-uppercase small fw-bold border-0">Product</th>
                                <th class="py-3 text-muted text-uppercase small fw-bold border-0 text-center">Qty</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($delivery->order->items as $item)
                            <tr>
                                <td class="ps-4 py-3 border-light fw-bold">{{ $item->product_name }}</td>
                                <td class="py-3 border-light text-center fw-bold fs-5">{{ $item->quantity }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="card-footer bg-light p-4 border-0 rounded-bottom-4 d-flex justify-content-between align-items-center">
                <div>
                    <span class="text-muted small fw-bold text-uppercase d-block">Payment Method</span>
                    <span class="fw-bold text-dark text-capitalize">{{ $delivery->order->payment_method }}</span>
                </div>
                <div class="text-end">
                    <span class="text-muted small fw-bold text-uppercase d-block">Amount to Collect</span>
                    @if($delivery->order->payment_status == 'paid')
                        <span class="badge bg-success px-3 py-2 rounded-pill"><i class="bi bi-check-circle-fill me-1"></i> Already Paid</span>
                    @else
                        <span class="fs-4 fw-bold font-mono text-primary">KES {{ number_format($delivery->order->total_amount) }}</span>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
