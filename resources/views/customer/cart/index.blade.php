@extends('layouts.customer')

@section('title', 'Your Cart')

@section('content')
<div class="row mb-4">
    <div class="col-12">
        <h2 class="fw-bold mb-1">Shopping Cart</h2>
        <p class="text-muted">Review your items before checkout.</p>
    </div>
</div>

<div class="row g-4">
    <div class="col-lg-8">
        <div class="card border-0 shadow-sm rounded-4 mb-4">
            <div class="card-body p-4">
                @if($cartItems->count() > 0)
                    <div class="table-responsive">
                        <table class="table align-middle mb-0 border-white">
                            <thead class="text-muted small text-uppercase fw-bold border-bottom">
                                <tr>
                                    <th scope="col" class="pb-3 border-0">Product</th>
                                    <th scope="col" class="pb-3 border-0 text-center">Quantity</th>
                                    <th scope="col" class="pb-3 border-0 text-end">Price</th>
                                    <th scope="col" class="pb-3 border-0"></th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($cartItems as $item)
                                <tr>
                                    <td class="py-4 border-light">
                                        <div class="d-flex align-items-center gap-3">
                                            <div class="bg-light rounded-3 d-flex align-items-center justify-content-center p-2" style="width: 60px; height: 60px;">
                                                <i class="bi bi-droplet text-primary fs-3"></i>
                                            </div>
                                            <div>
                                                <h6 class="mb-1 fw-bold">{{ $item->product->name }}</h6>
                                                <span class="badge bg-light text-dark">{{ $item->product->category->name }}</span>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="py-4 border-light text-center" style="width: 150px;">
                                        <form action="{{ route('customer.cart.update', $item->id) }}" method="POST" class="d-flex align-items-center justify-content-center">
                                            @csrf
                                            @method('PATCH')
                                            <input type="number" name="quantity" value="{{ $item->quantity }}" min="1" max="{{ $item->product->stock }}" class="form-control form-control-sm text-center" style="width: 70px; border-radius: 20px;" onchange="this.form.submit()">
                                        </form>
                                    </td>
                                    <td class="py-4 border-light text-end fw-bold font-mono text-primary">
                                        KES {{ number_format($item->product->effective_price * $item->quantity) }}
                                    </td>
                                    <td class="py-4 border-light text-end">
                                        <form action="{{ route('customer.cart.destroy', $item->id) }}" method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-light text-danger rounded-circle p-2" title="Remove Item">
                                                <i class="bi bi-trash"></i>
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <div class="text-center py-5">
                        <div class="bg-light rounded-circle d-inline-flex align-items-center justify-content-center mb-3" style="width: 100px; height: 100px;">
                            <i class="bi bi-cart-x fs-1 text-muted"></i>
                        </div>
                        <h4 class="fw-bold">Your cart is empty</h4>
                        <p class="text-muted mb-4">Looks like you haven't added anything to your cart yet.</p>
                        <a href="{{ route('customer.products.index') }}" class="btn btn-primary rounded-pill px-4">Continue Shopping</a>
                    </div>
                @endif
            </div>
        </div>
        
        @if($cartItems->count() > 0)
            <a href="{{ route('customer.products.index') }}" class="btn btn-link text-decoration-none fw-medium p-0"><i class="bi bi-arrow-left me-1"></i> Continue Shopping</a>
        @endif
    </div>
    
    <div class="col-lg-4">
        <div class="card border-0 shadow-sm rounded-4 position-sticky" style="top: 100px;">
            <div class="card-body p-4 p-md-5 bg-primary text-white rounded-4">
                <h5 class="fw-bold mb-4">Order Summary</h5>
                
                <div class="d-flex justify-content-between mb-3">
                    <span class="text-white-50">Subtotal</span>
                    <span class="fw-medium font-mono">KES {{ number_format($subtotal ?? 0) }}</span>
                </div>
                
                <div class="d-flex justify-content-between mb-3 pb-3 border-bottom border-light border-opacity-25">
                    <span class="text-white-50">Delivery</span>
                    <span class="fw-medium text-end"><small class="text-white-50 d-block">Calculated at checkout</small></span>
                </div>
                
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <span class="fs-5 fw-bold">Total</span>
                    <span class="fs-4 fw-bold font-mono">KES {{ number_format($subtotal ?? 0) }}</span>
                </div>
                
                <a href="{{ route('customer.checkout.index') }}" class="btn btn-light text-primary w-100 rounded-pill py-3 fw-bold shadow-sm {{ $cartItems->count() == 0 ? 'disabled' : '' }}">
                    Proceed to Checkout <i class="bi bi-arrow-right ms-2"></i>
                </a>
                
                <div class="mt-4 text-center">
                    <i class="bi bi-shield-check text-white-50 me-1"></i> <small class="text-white-50">Secure Checkout Process</small>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
