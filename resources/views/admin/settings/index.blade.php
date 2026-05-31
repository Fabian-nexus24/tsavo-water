@extends('layouts.admin')

@section('page-title', 'System Settings')

@section('content')
@if(session('success'))
    <div class="alert alert-success alert-dismissible fade show rounded-4 border-0 shadow-sm" role="alert">
        {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
@endif

<form action="{{ route('admin.settings.update') }}" method="POST">
    @csrf
    @method('PUT')

    <div class="row g-4">
        {{-- Company Information --}}
        <div class="col-lg-6">
            <div class="card border-0 shadow-sm rounded-4 bg-white mb-4">
                <div class="card-header bg-white p-4 border-bottom">
                    <h5 class="fw-bold mb-0"><i class="bi bi-building me-2 text-primary"></i>Company Information</h5>
                </div>
                <div class="card-body p-4">
                    <div class="mb-3">
                        <label class="form-label fw-bold small text-muted">Company Name</label>
                        <input type="text" name="company_name" class="form-control rounded-3" value="{{ $settings['company_name'] }}" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-bold small text-muted">Email Address</label>
                        <input type="email" name="company_email" class="form-control rounded-3" value="{{ $settings['company_email'] }}" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-bold small text-muted">Phone Number</label>
                        <input type="text" name="company_phone" class="form-control rounded-3" value="{{ $settings['company_phone'] }}" required>
                    </div>
                    <div class="mb-0">
                        <label class="form-label fw-bold small text-muted">Address</label>
                        <textarea name="company_address" class="form-control rounded-3" rows="2" required>{{ $settings['company_address'] }}</textarea>
                    </div>
                </div>
            </div>
        </div>

        {{-- Business Settings --}}
        <div class="col-lg-6">
            <div class="card border-0 shadow-sm rounded-4 bg-white mb-4">
                <div class="card-header bg-white p-4 border-bottom">
                    <h5 class="fw-bold mb-0"><i class="bi bi-sliders me-2 text-primary"></i>Business Settings</h5>
                </div>
                <div class="card-body p-4">
                    <div class="mb-3">
                        <label class="form-label fw-bold small text-muted">Currency Code</label>
                        <input type="text" name="currency" class="form-control rounded-3" value="{{ $settings['currency'] }}" required>
                    </div>
                    <div class="mb-4">
                        <label class="form-label fw-bold small text-muted">Minimum Order Amount</label>
                        <div class="input-group">
                            <span class="input-group-text rounded-start-3">{{ $settings['currency'] }}</span>
                            <input type="number" name="min_order" class="form-control rounded-end-3" value="{{ $settings['min_order'] }}" min="0" required>
                        </div>
                    </div>

                    <hr class="my-3">
                    <p class="fw-bold small text-muted mb-3">INTEGRATIONS</p>

                    <div class="form-check form-switch mb-3">
                        <input class="form-check-input" type="checkbox" id="enableMpesa" name="enable_mpesa" value="1" {{ ($settings['enable_mpesa'] ?? false) ? 'checked' : '' }}>
                        <label class="form-check-label fw-bold" for="enableMpesa">M-Pesa Payments</label>
                        <div class="small text-muted">Enable Safaricom M-Pesa STK Push at checkout</div>
                    </div>
                    <div class="form-check form-switch mb-3">
                        <input class="form-check-input" type="checkbox" id="enableSms" name="enable_sms" value="1" {{ ($settings['enable_sms'] ?? false) ? 'checked' : '' }}>
                        <label class="form-check-label fw-bold" for="enableSms">SMS Notifications</label>
                        <div class="small text-muted">Send order updates via Africa's Talking SMS</div>
                    </div>
                    <div class="form-check form-switch mb-0">
                        <input class="form-check-input" type="checkbox" id="enableEmail" name="enable_email" value="1" {{ ($settings['enable_email'] ?? false) ? 'checked' : '' }}>
                        <label class="form-check-label fw-bold" for="enableEmail">Email Notifications</label>
                        <div class="small text-muted">Send order confirmations and updates via email</div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Save Button --}}
        <div class="col-12">
            <button type="submit" class="btn btn-primary rounded-pill px-5 py-3 fw-bold shadow-sm">
                <i class="bi bi-check-lg me-2"></i> Save Settings
            </button>
        </div>
    </div>
</form>
@endsection
