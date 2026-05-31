@extends('layouts.admin')

@section('page-title', 'Driver Details')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <a href="{{ route('admin.drivers.index') }}" class="text-decoration-none text-muted small fw-bold"><i class="bi bi-arrow-left me-1"></i> Back to Fleet</a>
</div>

<div class="row g-4">
    <div class="col-lg-4">
        <div class="card border-0 shadow-sm rounded-4 bg-white mb-4">
            <div class="card-body p-4 text-center">
                <div class="avatar bg-primary bg-opacity-10 text-primary rounded-circle d-inline-flex align-items-center justify-content-center mb-3" style="width: 80px; height: 80px;">
                    <i class="bi bi-truck fs-1"></i>
                </div>
                <h4 class="fw-bold mb-1">{{ $driver->name }}</h4>
                <p class="text-muted small mb-3">Driver since {{ $driver->created_at->format('M Y') }}</p>
                
                @if($driver->driverProfile->availability == 'available')
                    <span class="badge bg-success rounded-pill px-4 py-2 fs-6 mb-4"><i class="bi bi-circle-fill small me-1"></i> ONLINE</span>
                @else
                    <span class="badge bg-secondary rounded-pill px-4 py-2 fs-6 mb-4"><i class="bi bi-circle small me-1"></i> OFFLINE</span>
                @endif
                
                <form action="{{ route('admin.drivers.status', $driver) }}" method="POST">
                    @csrf @method('PATCH')
                    <input type="hidden" name="status" value="{{ $driver->status == 'active' ? 'suspended' : 'active' }}">
                    <button type="submit" class="btn btn-{{ $driver->status == 'active' ? 'outline-danger' : 'success' }} rounded-pill w-100 fw-bold">
                        {{ $driver->status == 'active' ? 'Suspend Driver' : 'Activate Driver' }}
                    </button>
                </form>
            </div>
            <div class="card-footer bg-white border-top p-4">
                <div class="mb-3">
                    <small class="text-muted text-uppercase fw-bold d-block mb-1">Phone Number</small>
                    <div class="fw-medium"><a href="tel:{{ $driver->phone }}" class="text-decoration-none">{{ $driver->phone }}</a></div>
                </div>
                <div class="mb-3">
                    <small class="text-muted text-uppercase fw-bold d-block mb-1">Vehicle Type</small>
                    <div class="fw-medium text-capitalize">{{ $driver->driverProfile->vehicle_type ?? 'N/A' }}</div>
                </div>
                <div>
                    <small class="text-muted text-uppercase fw-bold d-block mb-1">License Plate</small>
                    <div class="fw-bold font-mono px-3 py-2 bg-light border d-inline-block rounded">{{ $driver->driverProfile->vehicle_plate ?? 'N/A' }}</div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-lg-8">
        <div class="card border-0 shadow-sm rounded-4 bg-white mb-4">
            <div class="card-body p-4 d-flex justify-content-between align-items-center">
                <div>
                    <h6 class="text-muted text-uppercase small fw-bold mb-1">Total Deliveries Completed</h6>
                    <h2 class="fw-bold mb-0 text-primary font-mono">{{ $totalDelivered }}</h2>
                </div>
                <i class="bi bi-box-seam text-primary opacity-25" style="font-size: 3rem;"></i>
            </div>
        </div>

        <div class="card border-0 shadow-sm rounded-4 bg-white">
            <div class="card-header bg-white p-4 border-bottom">
                <h5 class="fw-bold mb-0">Recent Delivery History</h5>
            </div>
            <div class="table-responsive">
                <table class="table align-middle mb-0">
                    <thead class="table-light">
                        <tr>
                            <th class="ps-4 py-3 border-0">Order ID</th>
                            <th class="py-3 border-0">Customer</th>
                            <th class="py-3 border-0">Status</th>
                            <th class="pe-4 py-3 border-0 text-end">Date</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($recentDeliveries as $delivery)
                        <tr>
                            <td class="ps-4 py-3"><a href="{{ route('admin.orders.show', $delivery->order) }}" class="fw-bold text-decoration-none">#{{ $delivery->order->order_number }}</a></td>
                            <td class="py-3">{{ $delivery->order->user->name ?? 'Unknown' }}</td>
                            <td class="py-3">
                                <span class="badge bg-{{ $delivery->status == 'delivered' ? 'success' : ($delivery->status == 'failed' ? 'danger' : 'warning') }} text-capitalize px-2 py-1 rounded-pill">
                                    {{ str_replace('_', ' ', $delivery->status) }}
                                </span>
                            </td>
                            <td class="pe-4 py-3 text-end text-muted small">{{ $delivery->created_at->format('M d, Y') }}</td>
                        </tr>
                        @empty
                        <tr><td colspan="4" class="text-center py-4 text-muted">No delivery history yet.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
