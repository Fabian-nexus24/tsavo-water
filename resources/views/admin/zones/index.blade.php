@extends('layouts.admin')

@section('page-title', 'Delivery Zones')

@section('content')
@if(session('success'))
    <div class="alert alert-success alert-dismissible fade show rounded-4 border-0 shadow-sm" role="alert">
        {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
@endif
@if(session('error'))
    <div class="alert alert-danger alert-dismissible fade show rounded-4 border-0 shadow-sm" role="alert">
        {{ session('error') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
@endif

<div class="row g-4">
    {{-- Add Zone Card --}}
    <div class="col-lg-4">
        <div class="card border-0 shadow-sm rounded-4 bg-white">
            <div class="card-header bg-white p-4 border-bottom">
                <h5 class="fw-bold mb-0"><i class="bi bi-geo-alt me-2 text-primary"></i>Add Zone</h5>
            </div>
            <div class="card-body p-4">
                <form action="{{ route('admin.zones.store') }}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label class="form-label fw-bold small text-muted">Zone Name</label>
                        <input type="text" name="name" class="form-control rounded-3 @error('name') is-invalid @enderror" value="{{ old('name') }}" placeholder="e.g. Westlands" required>
                        @error('name')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-bold small text-muted">Description</label>
                        <textarea name="description" class="form-control rounded-3" rows="2" placeholder="Areas covered...">{{ old('description') }}</textarea>
                    </div>
                    <div class="row g-3 mb-3">
                        <div class="col-6">
                            <label class="form-label fw-bold small text-muted">Base Fee (KES)</label>
                            <input type="number" name="base_fee" class="form-control rounded-3 @error('base_fee') is-invalid @enderror" value="{{ old('base_fee', 100) }}" min="0" step="0.01" required>
                            @error('base_fee')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        <div class="col-6">
                            <label class="form-label fw-bold small text-muted">Per KM Rate</label>
                            <input type="number" name="per_km_rate" class="form-control rounded-3" value="{{ old('per_km_rate', 0) }}" min="0" step="0.01">
                        </div>
                    </div>
                    <button type="submit" class="btn btn-primary w-100 rounded-pill fw-bold py-2">
                        <i class="bi bi-check-lg me-1"></i> Create Zone
                    </button>
                </form>
            </div>
        </div>
    </div>

    {{-- Zones Table --}}
    <div class="col-lg-8">
        <div class="card border-0 shadow-sm rounded-4 bg-white">
            <div class="card-header bg-white p-4 border-bottom">
                <h5 class="fw-bold mb-0">All Delivery Zones ({{ $zones->count() }})</h5>
            </div>
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-light">
                        <tr>
                            <th class="ps-4 py-3 border-0">Zone</th>
                            <th class="py-3 border-0 text-end">Base Fee</th>
                            <th class="py-3 border-0 text-end">Per KM</th>
                            <th class="py-3 border-0 text-center">Orders</th>
                            <th class="py-3 border-0">Status</th>
                            <th class="pe-4 py-3 border-0 text-end">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($zones as $zone)
                        <tr>
                            <td class="ps-4 py-3">
                                <div class="fw-bold">{{ $zone->name }}</div>
                                <div class="small text-muted">{{ Str::limit($zone->description, 35) }}</div>
                            </td>
                            <td class="py-3 text-end font-mono fw-bold text-primary">KES {{ number_format($zone->base_fee) }}</td>
                            <td class="py-3 text-end font-mono text-muted">KES {{ number_format($zone->per_km_rate) }}</td>
                            <td class="py-3 text-center">
                                <span class="badge bg-info bg-opacity-10 text-info px-3 py-2 rounded-pill fw-bold">{{ $zone->orders_count }}</span>
                            </td>
                            <td class="py-3">
                                <span class="badge bg-{{ $zone->is_active ? 'success' : 'secondary' }} rounded-pill px-2">
                                    {{ $zone->is_active ? 'Active' : 'Inactive' }}
                                </span>
                            </td>
                            <td class="pe-4 py-3 text-end">
                                <button class="btn btn-sm btn-light text-primary rounded-pill px-3" data-bs-toggle="modal" data-bs-target="#editZone{{ $zone->id }}">
                                    <i class="bi bi-pencil"></i> Edit
                                </button>
                                <form action="{{ route('admin.zones.destroy', $zone->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Delete this zone?')">
                                    @csrf @method('DELETE')
                                    <button class="btn btn-sm btn-light text-danger rounded-pill px-3"><i class="bi bi-trash"></i></button>
                                </form>
                            </td>
                        </tr>

                        {{-- Edit Modal --}}
                        <div class="modal fade" id="editZone{{ $zone->id }}" tabindex="-1">
                            <div class="modal-dialog modal-dialog-centered">
                                <div class="modal-content rounded-4 border-0 shadow">
                                    <form action="{{ route('admin.zones.update', $zone->id) }}" method="POST">
                                        @csrf @method('PUT')
                                        <div class="modal-header border-0 pb-0">
                                            <h5 class="modal-title fw-bold">Edit Zone</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                        </div>
                                        <div class="modal-body">
                                            <div class="mb-3">
                                                <label class="form-label fw-bold small text-muted">Zone Name</label>
                                                <input type="text" name="name" class="form-control rounded-3" value="{{ $zone->name }}" required>
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label fw-bold small text-muted">Description</label>
                                                <textarea name="description" class="form-control rounded-3" rows="2">{{ $zone->description }}</textarea>
                                            </div>
                                            <div class="row g-3 mb-3">
                                                <div class="col-6">
                                                    <label class="form-label fw-bold small text-muted">Base Fee (KES)</label>
                                                    <input type="number" name="base_fee" class="form-control rounded-3" value="{{ $zone->base_fee }}" min="0" step="0.01" required>
                                                </div>
                                                <div class="col-6">
                                                    <label class="form-label fw-bold small text-muted">Per KM Rate</label>
                                                    <input type="number" name="per_km_rate" class="form-control rounded-3" value="{{ $zone->per_km_rate }}" min="0" step="0.01">
                                                </div>
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label fw-bold small text-muted">Status</label>
                                                <select name="is_active" class="form-select rounded-3">
                                                    <option value="1" {{ $zone->is_active ? 'selected' : '' }}>Active</option>
                                                    <option value="0" {{ !$zone->is_active ? 'selected' : '' }}>Inactive</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="modal-footer border-0 pt-0">
                                            <button type="button" class="btn btn-light rounded-pill px-4" data-bs-dismiss="modal">Cancel</button>
                                            <button type="submit" class="btn btn-primary rounded-pill px-4">Save Changes</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                        @empty
                        <tr><td colspan="6" class="text-center py-5 text-muted">No delivery zones yet. Create your first one!</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
