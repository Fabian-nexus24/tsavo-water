@extends('layouts.customer')

@section('title', 'My Profile')

@section('content')
<div class="row mb-4">
    <div class="col-12">
        <h2 class="fw-bold mb-1">My Profile</h2>
        <p class="text-muted">Manage your personal information and security.</p>
    </div>
</div>

<div class="row g-4">
    <div class="col-lg-6">
        <div class="card border-0 shadow-sm rounded-4 mb-4">
            <div class="card-body p-4 p-md-5">
                <h5 class="fw-bold mb-4">Personal Information</h5>
                
                <form action="{{ route('customer.profile.update') }}" method="POST">
                    @csrf
                    @method('PATCH')
                    
                    <div class="form-floating mb-3">
                        <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" value="{{ old('name', $user->name) }}" required>
                        <label for="name">Full Name</label>
                        @error('name')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    
                    <div class="form-floating mb-3">
                        <input type="email" class="form-control @error('email') is-invalid @enderror" id="email" name="email" value="{{ old('email', $user->email) }}" required>
                        <label for="email">Email Address</label>
                        @error('email')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    
                    <div class="form-floating mb-4">
                        <input type="text" class="form-control @error('phone') is-invalid @enderror" id="phone" name="phone" value="{{ old('phone', $user->phone) }}" required>
                        <label for="phone">Phone Number</label>
                        @error('phone')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    
                    <h6 class="fw-bold mb-3">Default Delivery Address</h6>
                    
                    <div class="form-floating mb-3">
                        <input type="text" class="form-control @error('address') is-invalid @enderror" id="address" name="address" value="{{ old('address', $user->address) }}">
                        <label for="address">Street Address</label>
                        @error('address')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    
                    <div class="form-floating mb-4">
                        <input type="text" class="form-control @error('city') is-invalid @enderror" id="city" name="city" value="{{ old('city', $user->city) }}">
                        <label for="city">City</label>
                        @error('city')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    
                    <button type="submit" class="btn btn-primary rounded-pill px-4">Save Changes</button>
                </form>
            </div>
        </div>
    </div>
    
    <div class="col-lg-6">
        <div class="card border-0 shadow-sm rounded-4">
            <div class="card-body p-4 p-md-5">
                <h5 class="fw-bold mb-4">Update Password</h5>
                
                <form action="{{ route('customer.profile.password') }}" method="POST">
                    @csrf
                    @method('PATCH')
                    
                    <div class="form-floating mb-3">
                        <input type="password" class="form-control @error('current_password', 'updatePassword') is-invalid @enderror" id="current_password" name="current_password" required>
                        <label for="current_password">Current Password</label>
                        @error('current_password', 'updatePassword')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    
                    <div class="form-floating mb-3">
                        <input type="password" class="form-control @error('password', 'updatePassword') is-invalid @enderror" id="password" name="password" required>
                        <label for="password">New Password</label>
                        @error('password', 'updatePassword')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    
                    <div class="form-floating mb-4">
                        <input type="password" class="form-control" id="password_confirmation" name="password_confirmation" required>
                        <label for="password_confirmation">Confirm New Password</label>
                    </div>
                    
                    <button type="submit" class="btn btn-outline-primary rounded-pill px-4">Update Password</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
