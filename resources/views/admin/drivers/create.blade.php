@extends('layouts.admin')

@section('page-title', 'Register New Driver')

@section('content')
<div class="row justify-content-center">
    <div class="col-lg-8">
        <div class="card border-0 shadow-sm rounded-4 bg-white">
            <div class="card-header bg-white p-4 border-bottom d-flex justify-content-between align-items-center">
                <h5 class="fw-bold mb-0">Driver Information</h5>
                <a href="{{ route('admin.drivers.index') }}" class="btn btn-sm btn-light rounded-pill px-3">Back to Fleet</a>
            </div>
            <div class="card-body p-5">
                <form action="{{ route('admin.drivers.store') }}" method="POST">
                    @csrf
                    
                    <h6 class="fw-bold text-muted mb-3"><i class="bi bi-person me-2"></i>Personal Details</h6>
                    <div class="row g-3 mb-4">
                        <div class="col-md-6">
                            <label class="form-label fw-bold small">Full Name</label>
                            <input type="text" name="name" class="form-control rounded-3 @error('name') is-invalid @enderror" value="{{ old('name') }}" required>
                            @error('name')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-bold small">Email Address</label>
                            <input type="email" name="email" class="form-control rounded-3 @error('email') is-invalid @enderror" value="{{ old('email') }}" required>
                            @error('email')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-bold small">Phone Number</label>
                            <input type="text" name="phone" class="form-control rounded-3 @error('phone') is-invalid @enderror" value="{{ old('phone') }}" placeholder="e.g. 0712345678" required>
                            @error('phone')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-bold small">National ID Number</label>
                            <input type="text" name="national_id" class="form-control rounded-3 @error('national_id') is-invalid @enderror" value="{{ old('national_id') }}" required>
                            @error('national_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                    </div>

                    <hr class="text-light mb-4">

                    <h6 class="fw-bold text-muted mb-3"><i class="bi bi-truck me-2"></i>Vehicle Details</h6>
                    <div class="row g-3 mb-4">
                        <div class="col-md-6">
                            <label class="form-label fw-bold small">Vehicle Type</label>
                            <select name="vehicle_type" class="form-select rounded-3 @error('vehicle_type') is-invalid @enderror" required>
                                <option value="" disabled selected>Select vehicle...</option>
                                <option value="Motorcycle" {{ old('vehicle_type') == 'Motorcycle' ? 'selected' : '' }}>Motorcycle</option>
                                <option value="TukTuk" {{ old('vehicle_type') == 'TukTuk' ? 'selected' : '' }}>TukTuk</option>
                                <option value="Pickup/Van" {{ old('vehicle_type') == 'Pickup/Van' ? 'selected' : '' }}>Pickup/Van</option>
                                <option value="Truck" {{ old('vehicle_type') == 'Truck' ? 'selected' : '' }}>Truck</option>
                            </select>
                            @error('vehicle_type')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-bold small">License Plate Number</label>
                            <input type="text" name="vehicle_plate" class="form-control rounded-3 text-uppercase @error('vehicle_plate') is-invalid @enderror" value="{{ old('vehicle_plate') }}" placeholder="e.g. KCA 123A" required>
                            @error('vehicle_plate')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                    </div>

                    <hr class="text-light mb-4">

                    <h6 class="fw-bold text-muted mb-3"><i class="bi bi-shield-lock me-2"></i>Account Security</h6>
                    <div class="row g-3 mb-4">
                        <div class="col-md-6">
                            <label class="form-label fw-bold small">Temporary Password</label>
                            <input type="password" name="password" class="form-control rounded-3 @error('password') is-invalid @enderror" required>
                            @error('password')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-bold small">Confirm Password</label>
                            <input type="password" name="password_confirmation" class="form-control rounded-3" required>
                        </div>
                    </div>

                    <div class="text-end pt-3">
                        <button type="submit" class="btn btn-primary rounded-pill px-5 fw-bold shadow">
                            Register Driver <i class="bi bi-arrow-right ms-2"></i>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
