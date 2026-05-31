@extends('layouts.driver')

@section('page-title', 'Dashboard')

@section('content')
<div class="row g-4 mb-4">
    <!-- Driver Status Toggle -->
    <div class="col-12">
        <div class="card border-0 shadow-sm rounded-4 bg-white overflow-hidden">
            <div class="card-body p-4 d-flex justify-content-between align-items-center">
                <div class="d-flex align-items-center gap-3">
                    <div class="avatar bg-primary text-white rounded-circle d-flex align-items-center justify-content-center shadow-sm" style="width: 50px; height: 50px;">
                        <i class="bi bi-truck fs-4"></i>
                    </div>
                    <div>
                        <h5 class="fw-bold mb-1">Hello, {{ $driver->name }}</h5>
                        <p class="text-muted mb-0 small">
                            Vehicle: {{ $driver->driverProfile->vehicle_plate }} ({{ ucfirst($driver->driverProfile->vehicle_type) }})
                        </p>
                    </div>
                </div>
                <div>
                    <form action="{{ route('driver.availability') }}" method="POST">
                        @csrf
                        @method('PATCH')
                        <div class="form-check form-switch fs-4">
                            <input type="hidden" name="availability" value="offline">
                            <input class="form-check-input" type="checkbox" role="switch" id="availabilitySwitch" name="availability" value="available" {{ $driver->driverProfile->availability == 'available' ? 'checked' : '' }} onchange="this.form.submit()">
                            <label class="form-check-label fs-6 fw-bold ms-2 text-{{ $driver->driverProfile->availability == 'available' ? 'success' : 'danger' }}" for="availabilitySwitch">
                                {{ $driver->driverProfile->availability == 'available' ? 'ONLINE' : 'OFFLINE' }}
                            </label>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- KPIs -->
    <div class="col-sm-4">
        <div class="card border-0 shadow-sm rounded-4 h-100 bg-white">
            <div class="card-body p-4 text-center">
                <div class="bg-primary bg-opacity-10 text-primary rounded-circle d-inline-flex align-items-center justify-content-center mb-3" style="width: 60px; height: 60px;">
                    <i class="bi bi-box-seam fs-3"></i>
                </div>
                <h3 class="fw-bold mb-1 font-mono">{{ $stats['pending_deliveries'] }}</h3>
                <h6 class="text-muted text-uppercase small fw-bold mb-0">Active Deliveries</h6>
            </div>
        </div>
    </div>
    
    <div class="col-sm-4">
        <div class="card border-0 shadow-sm rounded-4 h-100 bg-white">
            <div class="card-body p-4 text-center">
                <div class="bg-success bg-opacity-10 text-success rounded-circle d-inline-flex align-items-center justify-content-center mb-3" style="width: 60px; height: 60px;">
                    <i class="bi bi-check2-circle fs-3"></i>
                </div>
                <h3 class="fw-bold mb-1 font-mono">{{ $stats['today_deliveries'] }}</h3>
                <h6 class="text-muted text-uppercase small fw-bold mb-0">Completed Today</h6>
            </div>
        </div>
    </div>
    
    <div class="col-sm-4">
        <div class="card border-0 shadow-sm rounded-4 h-100 bg-white">
            <div class="card-body p-4 text-center">
                <div class="bg-info bg-opacity-10 text-info rounded-circle d-inline-flex align-items-center justify-content-center mb-3" style="width: 60px; height: 60px;">
                    <i class="bi bi-award fs-3"></i>
                </div>
                <h3 class="fw-bold mb-1 font-mono">{{ $stats['total_deliveries'] }}</h3>
                <h6 class="text-muted text-uppercase small fw-bold mb-0">Total Lifetime</h6>
            </div>
        </div>
    </div>
</div>

<h5 class="fw-bold mb-3 mt-5">Active Assignments</h5>
<div class="row g-4">
    @forelse($activeDeliveries as $delivery)
    <div class="col-md-6 col-lg-4">
        <div class="card border-0 shadow-sm rounded-4 h-100 bg-white">
            <div class="card-header bg-white p-3 border-bottom d-flex justify-content-between align-items-center">
                <span class="badge bg-{{ $delivery->status == 'picked_up' ? 'warning' : 'primary' }} text-capitalize px-3 py-2 rounded-pill">
                    {{ str_replace('_', ' ', $delivery->status) }}
                </span>
                <span class="fw-bold text-muted font-mono small">#{{ $delivery->order->order_number }}</span>
            </div>
            <div class="card-body p-4">
                <h6 class="fw-bold mb-1">{{ $delivery->order->user->name }}</h6>
                <p class="text-muted small mb-3"><i class="bi bi-telephone-fill me-1"></i> {{ $delivery->order->user->phone ?? 'No Phone' }}</p>
                
                <div class="bg-light p-3 rounded-3 mb-4">
                    <small class="text-muted text-uppercase fw-bold d-block mb-1">Destination</small>
                    <div class="fw-medium">{{ $delivery->order->delivery_address }}</div>
                    <div class="text-muted small">{{ $delivery->order->delivery_city }}</div>
                </div>
                
                <a href="{{ route('driver.deliveries.show', $delivery) }}" class="btn btn-primary w-100 rounded-pill fw-bold">View Details</a>
            </div>
        </div>
    </div>
    @empty
    <div class="col-12">
        <div class="card border-0 shadow-sm rounded-4 bg-white text-center py-5">
            <div class="card-body">
                <i class="bi bi-cup-hot text-muted fs-1 mb-3 d-block opacity-50"></i>
                <h5 class="fw-bold text-muted">You have no active deliveries.</h5>
                <p class="text-black-50 mb-0">Stay online to receive new assignments.</p>
            </div>
        </div>
    </div>
    @endforelse
</div>
@endsection
