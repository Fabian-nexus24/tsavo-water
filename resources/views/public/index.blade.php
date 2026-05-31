@extends('layouts.public')

@section('title', 'Pure Water, Delivered Fresh')

@section('content')
<!-- Hero Section -->
<section class="hero-gradient d-flex align-items-center position-relative overflow-hidden" style="min-height: 95vh;">
    <!-- Animated SVG Wave Bottom -->
    <div class="wave-bg">
        <svg data-name="Layer 1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1200 120" preserveAspectRatio="none">
            <path d="M321.39,56.44c58-10.79,114.16-30.13,172-41.86,82.39-16.72,168.19-17.73,250.45-.39C823.78,31,906.67,72,985.66,92.83c70.05,18.48,146.53,26.09,214.34,3V120H0V95.8C79.81,118.91,158.74,124.87,243.6,104.53,269.64,98.24,295.6,89.5,321.39,56.44Z" class="shape-fill"></path>
        </svg>
    </div>

    <!-- Floating Droplets -->
    <i class="bi bi-droplet-fill floating-drop" style="font-size: 2rem; left: 10%; animation-delay: 0s; animation-duration: 12s;"></i>
    <i class="bi bi-droplet-half floating-drop" style="font-size: 4rem; left: 25%; animation-delay: 4s; animation-duration: 18s;"></i>
    <i class="bi bi-droplet-fill floating-drop" style="font-size: 1.5rem; left: 60%; animation-delay: 2s; animation-duration: 10s;"></i>
    <i class="bi bi-droplet-half floating-drop" style="font-size: 5rem; left: 80%; animation-delay: 7s; animation-duration: 22s;"></i>
    <i class="bi bi-droplet-fill floating-drop" style="font-size: 3rem; left: 90%; animation-delay: 1s; animation-duration: 15s;"></i>
    
    <div class="container position-relative z-1">
        <div class="row align-items-center">
            <div class="col-lg-6 mb-5 mb-lg-0" data-aos="fade-right">
                <span class="badge bg-white text-primary mb-3 px-4 py-2 shadow-sm rounded-pill border border-light"><i class="bi bi-star-fill text-warning me-1"></i> #1 Water Delivery in Nairobi</span>
                <h1 class="display-3 fw-bolder mb-4" style="line-height: 1.15;">
                    Pure Water,<br>
                    <span class="text-gradient">Delivered Fresh</span><br>
                    to Your Door.
                </h1>
                <p class="lead mb-5 text-muted" style="max-width: 500px; font-size: 1.25rem;">Experience the convenience of premium bottled water delivery. Clean, refreshing, and reliable service for your home and office needs.</p>
                <div class="d-flex flex-wrap gap-3">
                    <a href="{{ route('public.products') }}" class="btn btn-primary btn-lg rounded-pill px-5 shadow-lg">Order Now <i class="bi bi-arrow-right ms-2"></i></a>
                    <a href="{{ route('register') }}" class="btn btn-outline-primary btn-lg rounded-pill px-5 bg-white shadow-sm">Sign Up</a>
                </div>
            </div>
            
            <div class="col-lg-6 text-center" data-aos="zoom-in" data-aos-delay="200">
                <div class="position-relative d-inline-block p-5 bg-white rounded-circle shadow-lg" style="width: 450px; height: 450px; border: 15px solid rgba(13, 148, 136, 0.1);">
                    <i class="bi bi-droplet-half text-primary" style="font-size: 15rem; line-height: 1.2; background: -webkit-linear-gradient(#2DD4BF, #0F766E); -webkit-background-clip: text; -webkit-text-fill-color: transparent;"></i>
                    
                    <!-- Glassmorphism Floating Badge -->
                    <div class="position-absolute glass-heavy px-4 py-3" style="bottom: 40px; right: -40px; border-radius: 20px; animation: floatUp 6s ease-in-out infinite alternate;">
                        <div class="d-flex align-items-center gap-3">
                            <div class="bg-primary text-white rounded-circle d-flex align-items-center justify-content-center shadow-sm" style="width: 45px; height: 45px;"><i class="bi bi-shield-check fs-5"></i></div>
                            <div class="text-start">
                                <h6 class="mb-0 fw-bold text-dark">Quality Assured</h6>
                                <small class="text-muted fw-bold">100% Pure</small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Stats Bar -->
<section class="py-4" style="margin-top: -80px; position: relative; z-index: 2;" data-aos="fade-up" data-aos-offset="-100">
    <div class="container">
        <div class="glass-heavy p-4 p-md-5 rounded-4 border-0">
            <div class="row text-center g-4">
                <div class="col-md-4 border-end-md border-light border-opacity-50">
                    <h2 class="display-4 fw-bolder text-primary mb-1">10K+</h2>
                    <p class="text-muted fw-bold mb-0 text-uppercase tracking-wide" style="font-size: 0.85rem;">Deliveries Completed</p>
                </div>
                <div class="col-md-4 border-end-md border-light border-opacity-50">
                    <h2 class="display-4 fw-bolder text-primary mb-1">5K+</h2>
                    <p class="text-muted fw-bold mb-0 text-uppercase tracking-wide" style="font-size: 0.85rem;">Happy Customers</p>
                </div>
                <div class="col-md-4">
                    <h2 class="display-4 fw-bolder text-primary mb-1">99%</h2>
                    <p class="text-muted fw-bold mb-0 text-uppercase tracking-wide" style="font-size: 0.85rem;">On-Time Delivery</p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- How It Works -->
<section class="py-5 my-5 bg-white">
    <div class="container py-5">
        <div class="text-center mb-5 pb-4" data-aos="fade-up">
            <span class="text-secondary fw-bold text-uppercase tracking-wide" style="letter-spacing: 2px;">Simple Process</span>
            <h2 class="display-5 fw-bold mt-2 text-dark">How It Works</h2>
        </div>
        
        <div class="row g-4 position-relative">
            <!-- Connecting line for desktop -->
            <div class="d-none d-lg-block position-absolute border-top border-2 border-secondary opacity-25" style="top: 50px; left: 15%; right: 15%; z-index: 0; border-style: dashed !important;"></div>
            
            <div class="col-lg-4 text-center position-relative z-1" data-aos="fade-up" data-aos-delay="100">
                <div class="bg-white rounded-circle shadow-lg d-inline-flex align-items-center justify-content-center mb-4 border border-4 border-white transition-all hover-scale" style="width: 100px; height: 100px;">
                    <i class="bi bi-phone fs-1 text-primary"></i>
                </div>
                <h4 class="fw-bold text-dark">1. Browse & Order</h4>
                <p class="text-muted px-4 lead" style="font-size: 1.1rem;">Select your preferred water products and checkout easily via M-Pesa or Cash.</p>
            </div>
            
            <div class="col-lg-4 text-center position-relative z-1" data-aos="fade-up" data-aos-delay="300">
                <div class="bg-primary text-white rounded-circle shadow-lg d-inline-flex align-items-center justify-content-center mb-4 border border-4 border-white" style="width: 110px; height: 110px; transform: scale(1.1); box-shadow: 0 15px 30px rgba(0, 119, 182, 0.4) !important;">
                    <i class="bi bi-truck fs-1"></i>
                </div>
                <h4 class="fw-bold text-primary mt-2">2. We Dispatch</h4>
                <p class="text-muted px-4 lead" style="font-size: 1.1rem;">Our nearest driver is assigned your order and heads to your location immediately.</p>
            </div>
            
            <div class="col-lg-4 text-center position-relative z-1" data-aos="fade-up" data-aos-delay="500">
                <div class="bg-white rounded-circle shadow-lg d-inline-flex align-items-center justify-content-center mb-4 border border-4 border-white" style="width: 100px; height: 100px;">
                    <i class="bi bi-house-door fs-1 text-primary"></i>
                </div>
                <h4 class="fw-bold text-dark">3. Stay Hydrated</h4>
                <p class="text-muted px-4 lead" style="font-size: 1.1rem;">Receive your fresh, pure water right at your doorstep. Enjoy!</p>
            </div>
        </div>
    </div>
</section>

<!-- Featured Products -->
<section class="py-5 my-5 bg-light rounded-5 mx-2 mx-md-4 mx-lg-5 shadow-sm">
    <div class="container py-5">
        <div class="d-flex justify-content-between align-items-end mb-5" data-aos="fade-right">
            <div>
                <span class="text-secondary fw-bold text-uppercase tracking-wide" style="letter-spacing: 2px;">Shop Now</span>
                <h2 class="display-5 fw-bold mt-2 text-dark">Featured Products</h2>
            </div>
            <a href="{{ route('public.products') }}" class="btn btn-outline-primary rounded-pill d-none d-md-inline-block px-4 fw-bold">View All Products <i class="bi bi-arrow-right ms-1"></i></a>
        </div>
        
        <div class="row g-4">
            @forelse($featuredProducts as $index => $product)
            <div class="col-md-6 col-lg-3" data-aos="fade-up" data-aos-delay="{{ $index * 150 }}">
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
                            <span class="badge bg-warning text-dark position-absolute top-0 end-0 m-3 shadow-sm px-3 py-2 rounded-pill fw-bold">Best Seller</span>
                        @endif
                    </div>
                    <div class="card-body p-4 text-center bg-white rounded-bottom-4">
                        <span class="badge bg-primary bg-opacity-10 text-primary mb-2 px-3 py-2 rounded-pill">{{ $product->category->name }}</span>
                        <h5 class="card-title fw-bold mb-3 text-dark">{{ $product->name }}</h5>
                        <div class="mb-4">
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
                <i class="bi bi-box-seam text-muted" style="font-size: 4rem;"></i>
                <p class="text-muted mt-3 lead">Products are being added. Check back soon!</p>
            </div>
            @endforelse
        </div>
        
        <div class="text-center mt-5 d-md-none" data-aos="fade-up">
            <a href="{{ route('public.products') }}" class="btn btn-outline-primary rounded-pill px-5 py-3 fw-bold w-100">View All Products</a>
        </div>
    </div>
</section>

<!-- Delivery Zones -->
<section class="py-5 bg-dark text-white position-relative overflow-hidden">
    <div class="position-absolute" style="top: -100px; right: -100px; opacity: 0.05; transform: rotate(15deg);">
        <i class="bi bi-pin-map-fill" style="font-size: 40rem;"></i>
    </div>
    
    <div class="container py-5 position-relative z-1">
        <div class="row align-items-center">
            <div class="col-lg-5 mb-5 mb-lg-0" data-aos="fade-right">
                <span class="text-secondary fw-bold text-uppercase tracking-wide" style="letter-spacing: 2px;">Coverage Area</span>
                <h2 class="display-5 fw-bolder mb-4 mt-2">We Deliver to Your Area</h2>
                <p class="lead text-white-50 mb-5" style="font-size: 1.25rem;">Our growing fleet covers major zones across Nairobi, ensuring prompt delivery straight to your door.</p>
                <a href="{{ route('register') }}" class="btn btn-primary btn-lg rounded-pill px-5 shadow-lg fw-bold">Check My Address <i class="bi bi-arrow-right ms-2"></i></a>
            </div>
            <div class="col-lg-6 offset-lg-1">
                <div class="row g-4">
                    @forelse($zones as $index => $zone)
                    <div class="col-sm-6" data-aos="fade-up" data-aos-delay="{{ $index * 100 }}">
                        <div class="glass-card bg-white bg-opacity-10 border-light border-opacity-10 p-4 rounded-4 text-white hover-scale" style="transition: transform 0.3s ease;">
                            <div class="d-flex align-items-center gap-3">
                                <div class="bg-secondary rounded-circle d-flex align-items-center justify-content-center text-dark shadow" style="width: 50px; height: 50px;">
                                    <i class="bi bi-geo-alt-fill fs-5"></i>
                                </div>
                                <div>
                                    <h5 class="mb-1 fw-bold">{{ $zone->name }}</h5>
                                    <span class="badge bg-dark bg-opacity-50 text-light px-3 py-2 rounded-pill font-mono">Fee: KES {{ number_format($zone->base_fee) }}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    @empty
                    <div class="col-12" data-aos="fade-in">
                        <p class="text-white-50">Currently setting up delivery zones.</p>
                    </div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</section>

<!-- CTA -->
<section class="py-5 my-5 text-center px-2">
    <div class="container">
        <div class="p-5 p-md-5 rounded-5 shadow-lg position-relative overflow-hidden" style="background: linear-gradient(135deg, var(--primary-dark) 0%, var(--secondary) 100%);" data-aos="zoom-in">
            <div class="position-relative z-1 py-4">
                <h2 class="display-4 fw-bolder text-white mb-4">Ready to Stay Hydrated?</h2>
                <p class="lead text-white-50 mb-5 mx-auto" style="max-width: 600px; font-size: 1.25rem;">Join thousands of satisfied customers enjoying our premium water delivery service. Hydration is just a click away.</p>
                <a href="{{ route('register') }}" class="btn btn-light btn-lg rounded-pill px-5 fw-bold text-primary shadow-lg" style="padding: 15px 40px;">Get Started Today <i class="bi bi-lightning-fill text-warning ms-2"></i></a>
            </div>
            
            <!-- Background effects -->
            <div class="position-absolute top-50 start-0 translate-middle-y" style="opacity: 0.1; transform: scale(3);">
                <i class="bi bi-droplet-fill text-white"></i>
            </div>
            <div class="position-absolute top-50 end-0 translate-middle-y" style="opacity: 0.1; transform: scale(2);">
                <i class="bi bi-droplet-half text-white"></i>
            </div>
        </div>
    </div>
</section>
@endsection
