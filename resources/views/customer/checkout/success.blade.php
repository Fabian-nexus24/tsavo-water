@extends('layouts.customer')

@section('title', 'Order Success')

@section('content')
<div class="row justify-content-center py-5">
    <div class="col-md-8 col-lg-6 text-center">
        
        <div class="mb-4">
            <div class="bg-success text-white rounded-circle d-inline-flex align-items-center justify-content-center shadow-sm" style="width: 100px; height: 100px;">
                <i class="bi bi-check2 fs-1"></i>
            </div>
        </div>
        
        <h1 class="display-6 fw-bold mb-3">Order Placed Successfully!</h1>
        <p class="lead text-muted mb-5">Thank you for your order. We are preparing it for dispatch.</p>
        
        <div class="card border-0 shadow-sm rounded-4 text-start mb-5">
            <div class="card-body p-4 p-md-5">
                <div class="d-flex justify-content-between align-items-center mb-4 pb-3 border-bottom">
                    <div>
                        <span class="text-muted small text-uppercase fw-bold d-block">Order Number</span>
                        <span class="fs-5 fw-bold font-mono text-primary">{{ $order->order_number }}</span>
                    </div>
                    <div class="text-end">
                        <span class="text-muted small text-uppercase fw-bold d-block">Total Amount</span>
                        <span class="fs-5 fw-bold font-mono">KES {{ number_format($order->total_amount) }}</span>
                    </div>
                </div>
                
                <div class="row g-4 mb-4">
                    <div class="col-sm-6">
                        <h6 class="text-muted text-uppercase small fw-bold mb-2">Delivery Details</h6>
                        <p class="mb-0 fw-medium">{{ $order->delivery_address }}</p>
                        <p class="text-muted small">{{ $order->delivery_city }}</p>
                    </div>
                    <div class="col-sm-6">
                        <h6 class="text-muted text-uppercase small fw-bold mb-2">Payment Method</h6>
                        <p class="mb-0 fw-medium text-capitalize">
                            @if($order->payment_method == 'mpesa')
                                <i class="bi bi-phone text-success me-1"></i> M-Pesa
                            @else
                                <i class="bi bi-cash-stack text-muted me-1"></i> Cash on Delivery
                            @endif
                        </p>
                        <p class="text-muted small text-capitalize">Status: {{ $order->payment_status }}</p>
                    </div>
                </div>

                @if($order->payment_method == 'mpesa' && $order->payment_status == 'pending')
                <div class="bg-success bg-opacity-10 border border-success border-opacity-25 rounded-3 p-4 text-center mt-4">
                    <h6 class="fw-bold text-success mb-2">Complete Payment via M-Pesa</h6>
                    <p class="small text-muted mb-3">Click the button below to receive an M-Pesa prompt on your phone.</p>
                    
                    <form id="stkForm">
                        <div class="input-group mb-3" style="max-width: 300px; margin: 0 auto;">
                            <span class="input-group-text bg-white border-end-0">+254</span>
                            <input type="text" id="mpesa_phone" class="form-control border-start-0 ps-0" placeholder="712345678" value="{{ substr(auth()->user()->phone, 4) }}">
                        </div>
                        <button type="button" id="btn-stk" class="btn btn-success rounded-pill px-4 shadow-sm">
                            <i class="bi bi-phone-vibrate me-1"></i> Send M-Pesa Prompt
                        </button>
                    </form>
                    <div id="stk-message" class="mt-3 small fw-bold d-none"></div>
                </div>
                @endif
            </div>
        </div>
        
        <div class="d-flex justify-content-center gap-3 flex-wrap">
            <a href="{{ route('customer.dashboard') }}" class="btn btn-primary rounded-pill px-4 shadow-sm">Track Order</a>
            <a href="{{ route('customer.products.index') }}" class="btn btn-outline-secondary rounded-pill px-4">Continue Shopping</a>
        </div>
    </div>
</div>
@endsection

@push('scripts')
@if($order->payment_method == 'mpesa' && $order->payment_status == 'pending')
<script>
    $(document).ready(function() {
        $('#btn-stk').click(function() {
            const btn = $(this);
            const phone = '+254' + $('#mpesa_phone').val();
            const msgBox = $('#stk-message');
            
            btn.prop('disabled', true).html('<span class="spinner-border spinner-border-sm me-2"></span> Sending...');
            msgBox.addClass('d-none').removeClass('text-success text-danger');
            
            $.ajax({
                url: '{{ route("customer.checkout.mpesa") }}',
                type: 'POST',
                data: {
                    _token: '{{ csrf_token() }}',
                    order_id: '{{ $order->id }}',
                    phone: phone
                },
                success: function(response) {
                    msgBox.text(response.message).addClass('text-success d-block');
                    btn.html('<i class="bi bi-check-circle me-1"></i> Prompt Sent');
                },
                error: function(xhr) {
                    btn.prop('disabled', false).html('<i class="bi bi-phone-vibrate me-1"></i> Try Again');
                    msgBox.text(xhr.responseJSON?.message || 'Failed to send prompt').addClass('text-danger d-block');
                }
            });
        });
    });
</script>
@endif
@endpush
