@extends('layouts.customer')

@section('title', 'Products')

@section('content')
<div class="row mb-5 align-items-center">
    <div class="col-md-6 mb-3 mb-md-0">
        <h2 class="fw-bold mb-1">Our Products</h2>
        <p class="text-muted mb-0">Pure, refreshing water delivered directly to you.</p>
    </div>
    <div class="col-md-6 text-md-end">
        <!-- Search and Filter Form -->
        <form action="{{ route('customer.products.index') }}" method="GET" class="d-flex gap-2 justify-content-md-end">
            <div class="input-group" style="max-width: 300px;">
                <span class="input-group-text bg-white border-end-0"><i class="bi bi-search text-muted"></i></span>
                <input type="text" name="search" class="form-control border-start-0 ps-0" placeholder="Search..." value="{{ request('search') }}">
            </div>
            <select name="category" class="form-select" style="max-width: 150px;" onchange="this.form.submit()">
                <option value="">All Categories</option>
                @foreach($categories as $category)
                    <option value="{{ $category->slug }}" {{ request('category') == $category->slug ? 'selected' : '' }}>
                        {{ $category->name }}
                    </option>
                @endforeach
            </select>
        </form>
    </div>
</div>

<div class="row g-4">
    @forelse($products as $product)
    <div class="col-md-4 col-lg-3">
        <div class="card product-card h-100 border-0 shadow-sm">
            <div class="product-img-wrapper" style="height: 200px;">
                @if($product->image)
                    <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}" class="img-fluid" style="max-height: 180px; object-fit: contain;">
                @else
                    @if($product->category->slug == 'water-dispensers')
                        <i class="bi bi-hdd-network fs-1"></i>
                    @elseif($product->category->slug == 'accessories')
                        <i class="bi bi-nut fs-1"></i>
                    @else
                        <i class="bi bi-droplet-half fs-1"></i>
                    @endif
                @endif
                
                @if($product->sale_price)
                    <span class="position-absolute top-0 end-0 m-3 badge bg-danger rounded-pill">SALE</span>
                @endif
            </div>
            <div class="card-body p-4 d-flex flex-column">
                <span class="badge bg-primary-light bg-opacity-10 text-primary mb-2 align-self-start">{{ $product->category->name }}</span>
                <h5 class="card-title fw-bold mb-2">{{ $product->name }}</h5>
                <p class="text-muted small mb-3 flex-grow-1">{{ Str::limit($product->description, 60) }}</p>
                
                <div class="mb-3 d-flex align-items-end justify-content-between">
                    <div>
                        @if($product->sale_price)
                            <div class="text-muted text-decoration-line-through small">KES {{ number_format($product->price) }}</div>
                            <div class="fs-5 fw-bold text-primary font-mono">KES {{ number_format($product->sale_price) }}</div>
                        @else
                            <div class="fs-5 fw-bold text-primary font-mono">KES {{ number_format($product->price) }}</div>
                        @endif
                    </div>
                    @if($product->stock > 0)
                        <span class="text-success small fw-medium"><i class="bi bi-check-circle-fill me-1"></i> In Stock</span>
                    @else
                        <span class="text-danger small fw-medium"><i class="bi bi-x-circle-fill me-1"></i> Out of Stock</span>
                    @endif
                </div>
                
                <form action="{{ route('customer.cart.store') }}" method="POST">
                    @csrf
                    <input type="hidden" name="product_id" value="{{ $product->id }}">
                    <input type="hidden" name="quantity" value="1">
                    <button type="submit" class="btn btn-primary w-100 rounded-pill" {{ $product->stock <= 0 ? 'disabled' : '' }}>
                        <i class="bi bi-cart-plus me-2"></i> Add to Cart
                    </button>
                </form>
            </div>
        </div>
    </div>
    @empty
    <div class="col-12 text-center py-5 bg-white rounded-4 shadow-sm">
        <i class="bi bi-search fs-1 text-muted mb-3 d-block"></i>
        <h4 class="fw-bold">No Products Found</h4>
        <p class="text-muted">Try adjusting your search or filter criteria.</p>
        <a href="{{ route('customer.products.index') }}" class="btn btn-outline-primary mt-2">Clear Filters</a>
    </div>
    @endforelse
</div>

<div class="d-flex justify-content-center mt-5">
    {{ $products->links() }}
</div>
@endsection
