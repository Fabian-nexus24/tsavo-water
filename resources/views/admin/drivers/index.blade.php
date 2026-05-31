@extends('layouts.admin')

@section('page-title', 'Manage Drivers')

@section('content')
<div class="card border-0 shadow-sm rounded-4 bg-white mb-4">
    <div class="card-header bg-white p-4 border-bottom d-flex justify-content-between align-items-center">
        <h5 class="fw-bold mb-0">Driver Fleet</h5>
        <a href="{{ route('admin.drivers.create') }}" class="btn btn-primary rounded-pill fw-bold"><i class="bi bi-plus-lg me-1"></i> Add Driver</a>
    </div>
    <div class="table-responsive">
        <table class="table table-hover align-middle mb-0">
            <thead class="table-light">
                <tr>
                    <th class="ps-4 py-3 border-0">Driver Name</th>
                    <th class="py-3 border-0">Vehicle Info</th>
                    <th class="py-3 border-0 text-center">Deliveries</th>
                    <th class="py-3 border-0">Availability</th>
                    <th class="pe-4 py-3 border-0 text-end">Action</th>
                </tr>
            </thead>
            <tbody>
                @forelse($drivers as $driver)
                <tr>
                    <td class="ps-4 py-3">
                        <div class="fw-bold">{{ $driver->name }}</div>
                        <div class="small text-muted"><i class="bi bi-telephone-fill me-1"></i>{{ $driver->phone }}</div>
                    </td>
                    <td class="py-3">
                        <div class="fw-bold text-uppercase">{{ $driver->driverProfile->vehicle_plate ?? 'N/A' }}</div>
                        <div class="small text-muted">{{ ucfirst($driver->driverProfile->vehicle_type ?? 'N/A') }}</div>
                    </td>
                    <td class="py-3 text-center fw-bold">{{ $driver->deliveries_as_driver_count }}</td>
                    <td class="py-3">
                        @if($driver->driverProfile && $driver->driverProfile->availability == 'available')
                            <span class="badge bg-success rounded-pill px-3 py-2"><i class="bi bi-circle-fill small me-1"></i> Online</span>
                        @else
                            <span class="badge bg-secondary rounded-pill px-3 py-2"><i class="bi bi-circle small me-1"></i> Offline</span>
                        @endif
                    </td>
                    <td class="pe-4 py-3 text-end">
                        <a href="{{ route('admin.drivers.show', $driver) }}" class="btn btn-sm btn-light text-primary rounded-pill px-3">View</a>
                    </td>
                </tr>
                @empty
                <tr><td colspan="5" class="text-center py-5 text-muted">No drivers found.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
    @if($drivers->hasPages())
    <div class="card-footer bg-white p-4 border-top">
        {{ $drivers->links() }}
    </div>
    @endif
</div>
@endsection
