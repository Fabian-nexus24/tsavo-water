@extends('layouts.customer')

@section('title', 'Checkout')

@section('content')
<div class="row mb-4">
    <div class="col-12 text-center text-md-start">
        <h2 class="fw-bold mb-1">Secure Checkout</h2>
        <p class="text-muted">Complete your delivery details and payment.</p>
    </div>
</div>

<form action="{{ route('customer.checkout.store') }}" method="POST" id="checkoutForm">
    @csrf
    <div class="row g-4">
        <!-- Delivery Details -->
        <div class="col-lg-7">
            <div class="card border-0 shadow-sm rounded-4 mb-4">
                <div class="card-body p-4 p-md-5">
                    <h5 class="fw-bold mb-4 d-flex align-items-center">
                        <span class="bg-primary text-white rounded-circle d-flex align-items-center justify-content-center me-3 fs-6" style="width: 30px; height: 30px;">1</span>
                        Delivery Information
                    </h5>
                    
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label fw-bold small text-muted text-uppercase">Full Name</label>
                            <input type="text" class="form-control" value="{{ auth()->user()->name }}" disabled>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-bold small text-muted text-uppercase">Phone Number</label>
                            <input type="text" class="form-control" value="{{ auth()->user()->phone }}" disabled>
                        </div>
                        
                        <div class="col-12 mt-4">
                            <label class="form-label fw-bold small text-muted text-uppercase">Delivery Zone <span class="text-danger">*</span></label>
                            <select name="zone_id" id="zone_id" class="form-select @error('zone_id') is-invalid @enderror" required>
                                <option value="" data-fee="0">Select your delivery zone</option>
                                @foreach($zones as $zone)
                                    <option value="{{ $zone->id }}" data-fee="{{ $zone->base_fee }}" {{ old('zone_id') == $zone->id ? 'selected' : '' }}>
                                        {{ $zone->name }} (Fee: KES {{ number_format($zone->base_fee) }})
                                    </option>
                                @endforeach
                            </select>
                            @error('zone_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        
                        <div class="col-12">
                            <label class="form-label fw-bold small text-muted text-uppercase">Street Address <span class="text-danger">*</span></label>
                            <textarea name="delivery_address" class="form-control @error('delivery_address') is-invalid @enderror" rows="2" placeholder="Building name, street, apartment number..." required>{{ old('delivery_address', auth()->user()->address) }}</textarea>
                            @error('delivery_address')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        
                        <div class="col-12">
                            <label class="form-label fw-bold small text-muted text-uppercase">City <span class="text-danger">*</span></label>
                            <input type="text" name="delivery_city" class="form-control @error('delivery_city') is-invalid @enderror" value="{{ old('delivery_city', auth()->user()->city ?? 'Nairobi') }}" required>
                            @error('delivery_city')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        
                        <div class="col-12 mt-4">
                            <label class="form-label fw-bold small text-muted text-uppercase">Delivery Notes (Optional)</label>
                            <textarea name="notes" class="form-control" rows="2" placeholder="e.g. Leave at the reception, call upon arrival..."></textarea>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card border-0 shadow-sm rounded-4 mb-4">
                <div class="card-body p-4 p-md-5">
                    <h5 class="fw-bold mb-4 d-flex align-items-center">
                        <span class="bg-primary text-white rounded-circle d-flex align-items-center justify-content-center me-3 fs-6" style="width: 30px; height: 30px;">2</span>
                        Payment Method
                    </h5>
                    
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="w-100">
                                <input type="radio" name="payment_method" value="mpesa" class="d-none peer" checked>
                                <div class="card border-2 peer-checked-border-success cursor-pointer h-100 transition" id="card-mpesa" style="border-color: #2D6A4F;">
                                    <div class="card-body text-center p-4">
                                        <div class="bg-success bg-opacity-10 text-success rounded-circle d-inline-flex align-items-center justify-content-center mb-3" style="width: 50px; height: 50px;">
                                            <i class="bi bi-phone fs-4"></i>
                                        </div>
                                        <h6 class="fw-bold text-success mb-1">M-Pesa</h6>
                                        <small class="text-muted">Pay securely via M-Pesa STK Push</small>
                                    </div>
                                </div>
                            </label>
                        </div>
                        
                        <div class="col-md-6">
                            <label class="w-100">
                                <input type="radio" name="payment_method" value="cash" class="d-none peer">
                                <div class="card border-2 cursor-pointer h-100 transition" id="card-cash" style="border-color: #dee2e6;">
                                    <div class="card-body text-center p-4">
                                        <div class="bg-light text-dark rounded-circle d-inline-flex align-items-center justify-content-center mb-3" style="width: 50px; height: 50px;">
                                            <i class="bi bi-cash-stack fs-4"></i>
                                        </div>
                                        <h6 class="fw-bold text-dark mb-1">Cash on Delivery</h6>
                                        <small class="text-muted">Pay in cash when order arrives</small>
                                    </div>
                                </div>
                            </label>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Order Summary -->
        <div class="col-lg-5">
            <div class="card border-0 shadow-sm rounded-4 position-sticky" style="top: 100px;">
                <div class="card-body p-4 p-md-5">
                    <h5 class="fw-bold mb-4">Your Order</h5>
                    
                    <ul class="list-group list-group-flush mb-4">
                        @foreach($cartItems as $item)
                        <li class="list-group-item px-0 py-3 d-flex justify-content-between align-items-center border-light">
                            <div class="d-flex align-items-center gap-2">
                                <span class="badge bg-light text-dark border">{{ $item->quantity }}x</span>
                                <span class="fw-medium">{{ Str::limit($item->product->name, 25) }}</span>
                            </div>
                            <span class="font-mono text-muted">KES {{ number_format($item->product->effective_price * $item->quantity) }}</span>
                        </li>
                        @endforeach
                    </ul>
                    
                    <div class="border-top border-light pt-4 mb-4">
                        <div class="d-flex justify-content-between mb-2">
                            <span class="text-muted">Subtotal</span>
                            <span class="fw-medium font-mono" id="summary-subtotal" data-value="{{ $subtotal }}">KES {{ number_format($subtotal) }}</span>
                        </div>
                        <div class="d-flex justify-content-between mb-3">
                            <span class="text-muted">Delivery Fee</span>
                            <span class="fw-medium font-mono text-primary" id="summary-delivery">KES 0</span>
                        </div>
                        
                        <div class="d-flex justify-content-between align-items-center pt-3 border-top">
                            <span class="fs-5 fw-bold">Total Amount</span>
                            <span class="fs-4 fw-bold font-mono text-primary" id="summary-total">KES {{ number_format($subtotal) }}</span>
                        </div>
                    </div>
                    
                    <button type="submit" class="btn btn-primary w-100 rounded-pill py-3 fw-bold shadow-sm" id="btn-submit">
                        <i class="bi bi-lock-fill me-2"></i> Place Order Securely
                    </button>
                    <p class="text-center text-muted small mt-3 mb-0">By placing this order, you agree to our Terms of Service.</p>
                </div>
            </div>
        </div>
    </div>
</form>
@endsection

@push('scripts')
<style>
    .cursor-pointer { cursor: pointer; }
    .transition { transition: all 0.3s ease; }
</style>
<script>
    $(document).ready(function() {
        const subtotal = parseFloat($('#summary-subtotal').data('value'));
        
        // Update summary when zone changes
        $('#zone_id').change(function() {
            const fee = parseFloat($(this).find(':selected').data('fee')) || 0;
            const total = subtotal + fee;
            
            $('#summary-delivery').text('KES ' + fee.toLocaleString());
            $('#summary-total').text('KES ' + total.toLocaleString());
        });
        
        // Toggle payment styling
        $('input[name="payment_method"]').change(function() {
            if($(this).val() === 'mpesa') {
                $('#card-mpesa').css('border-color', '#2D6A4F').find('.bg-light').removeClass('bg-light').addClass('bg-success bg-opacity-10 text-success');
                $('#card-cash').css('border-color', '#dee2e6');
                $('#btn-submit').html('<i class="bi bi-phone me-2"></i> Pay via M-Pesa');
            } else {
                $('#card-cash').css('border-color', '#0077B6');
                $('#card-mpesa').css('border-color', '#dee2e6').find('.bg-success').removeClass('bg-success bg-opacity-10 text-success').addClass('bg-light text-dark');
                $('#btn-submit').html('<i class="bi bi-check-circle me-2"></i> Confirm Order');
            }
        });
        
        // Initial trigger
        $('#zone_id').trigger('change');
    });
</script>
@endpush
