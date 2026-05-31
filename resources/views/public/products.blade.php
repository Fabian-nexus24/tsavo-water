@extends('layouts.public')

@section('title', 'Our Products')

@section('content')
<!-- Page Header -->
<section class="py-5 bg-dark text-white position-relative overflow-hidden" style="margin-top: 76px;">
    <!-- Abstract Background Elements -->
    <div class="position-absolute" style="top: -50px; right: -20px; opacity: 0.05; transform: rotate(15deg);">
        <i class="bi bi-droplet-half" style="font-size: 30rem;"></i>
    </div>
    <div class="container py-5 position-relative z-1">
        <div class="row">
            <div class="col-lg-8" data-aos="fade-right">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb mb-3">
                        <li class="breadcrumb-item"><a href="{{ route('home') }}" class="text-white-50 text-decoration-none">Home</a></li>
                        <li class="breadcrumb-item active text-white" aria-current="page">Products</li>
                    </ol>
                </nav>
                <h1 class="display-4 fw-bolder mb-3">Our <span class="text-secondary">Products</span></h1>
                <p class="lead text-white-50 mb-0">Browse our selection of premium bottled water, eco-friendly refills, and high-quality dispensers.</p>
            </div>
        </div>
    </div>
</section>

<!-- Products Grid -->
<section class="py-5 bg-light min-vh-100">
    <div class="container py-4">
        
        <div class="row g-4">
            @forelse($products as $index => $product)
            <div class="col-md-6 col-lg-4 col-xl-3" data-aos="fade-up" data-aos-delay="{{ ($index % 4) * 100 }}">
                <div class="card product-card h-100 p-1">
                    <div class="product-img-wrapper rounded-top-4">
                        @if($product->image)
                            <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}" class="img-fluid" style="max-height: 200px; object-fit: contain;">
                        @else
                            @if($product->category->slug == 'water-dispensers')
                                <i class="bi bi-hdd-network"></i>
                            @elseif($product->category->slug == 'accessories')
                                <i class="bi bi-nut"></i>
                            @else
                                <i class="bi bi-droplet-half"></i>
                            @endif
                        @endif
                        
                        @if($product->is_featured)
                            <span class="badge bg-warning text-dark position-absolute top-0 end-0 m-3 shadow-sm px-3 py-2 rounded-pill fw-bold">Featured</span>
                        @elseif($product->sale_price)
                            <span class="badge bg-danger text-white position-absolute top-0 end-0 m-3 shadow-sm px-3 py-2 rounded-pill fw-bold">Sale</span>
                        @endif
                    </div>
                    
                    <div class="card-body p-4 text-center bg-white rounded-bottom-4 d-flex flex-column">
                        <span class="badge bg-primary bg-opacity-10 text-primary mb-2 px-3 py-2 rounded-pill align-self-center">{{ $product->category->name }}</span>
                        <h5 class="card-title fw-bold mb-3 text-dark">{{ $product->name }}</h5>
                        
                        <div class="mb-4 mt-auto">
                            @if($product->sale_price)
                                <span class="text-muted text-decoration-line-through me-2 small">KES {{ number_format($product->price) }}</span>
                                <span class="fs-4 fw-bolder text-gradient font-mono">KES {{ number_format($product->sale_price) }}</span>
                            @else
                                <span class="fs-4 fw-bolder text-gradient font-mono">KES {{ number_format($product->price) }}</span>
                            @endif
                        </div>
                        
                        <form action="{{ route('customer.cart.store') }}" method="POST">
                            @csrf
                            <input type="hidden" name="product_id" value="{{ $product->id }}">
                            <input type="hidden" name="quantity" value="1">
                            <button type="submit" class="btn btn-primary w-100 rounded-pill fw-bold shadow-sm {{ !auth()->check() || auth()->user()->role !== 'customer' ? 'disabled' : '' }}">
                                <i class="bi bi-cart-plus me-2"></i> Add to Cart
                            </button>
                        </form>
                        
                        @if(!auth()->check() || auth()->user()->role !== 'customer')
                            <div class="mt-3 small text-muted"><i class="bi bi-lock me-1"></i> Login as customer to order</div>
                        @endif
                    </div>
                </div>
            </div>
            @empty
            <div class="col-12 text-center py-5" data-aos="fade-in">
                <i class="bi bi-box-seam text-muted" style="font-size: 5rem;"></i>
                <h3 class="fw-bold text-dark mt-4">No Products Found</h3>
                <p class="text-muted lead">We're currently restocking our inventory. Please check back later!</p>
                <a href="{{ route('home') }}" class="btn btn-primary rounded-pill px-4 mt-3">Return Home</a>
            </div>
            @endforelse
        </div>
        
        <!-- Pagination -->
        @if($products->hasPages())
        <div class="d-flex justify-content-center mt-5 pt-4" data-aos="fade-up">
            {{ $products->links() }}
        </div>
        @endif
        
    </div>
</section>
@endsection
