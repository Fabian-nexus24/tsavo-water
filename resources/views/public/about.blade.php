@extends('layouts.public')

@section('title', 'About Us')

@section('content')
<!-- Page Header -->
<section class="py-5 bg-dark text-white position-relative overflow-hidden" style="margin-top: 76px;">
    <div class="position-absolute" style="top: -50px; right: -20px; opacity: 0.05; transform: rotate(15deg);">
        <i class="bi bi-info-circle-fill" style="font-size: 30rem;"></i>
    </div>
    <div class="container py-5 position-relative z-1">
        <div class="row">
            <div class="col-lg-8" data-aos="fade-right">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb mb-3">
                        <li class="breadcrumb-item"><a href="{{ route('home') }}" class="text-white-50 text-decoration-none">Home</a></li>
                        <li class="breadcrumb-item active text-white" aria-current="page">About Us</li>
                    </ol>
                </nav>
                <h1 class="display-4 fw-bolder mb-3">About <span class="text-secondary">Tsavo Water</span></h1>
                <p class="lead text-white-50 mb-0">Learn about our mission to provide pure, refreshing water to every home and office in Nairobi.</p>
            </div>
        </div>
    </div>
</section>

<!-- Our Story -->
<section class="py-5 my-5 bg-white">
    <div class="container">
        <div class="row align-items-center g-5">
            <div class="col-lg-6" data-aos="fade-up">
                <div class="position-relative">
                    <div class="bg-light rounded-5 p-5 shadow-sm text-center border">
                        <i class="bi bi-droplet text-primary" style="font-size: 10rem;"></i>
                    </div>
                    <div class="position-absolute glass-heavy p-4 rounded-4 shadow-lg" style="bottom: -30px; right: -20px;">
                        <h3 class="fw-bolder text-primary mb-0">10+ Years</h3>
                        <p class="text-muted fw-bold mb-0">of pure hydration</p>
                    </div>
                </div>
            </div>
            <div class="col-lg-6" data-aos="fade-left">
                <span class="text-secondary fw-bold text-uppercase tracking-wide" style="letter-spacing: 2px;">Our Story</span>
                <h2 class="display-5 fw-bolder text-dark mt-2 mb-4">Committed to Quality and Purity</h2>
                <p class="lead text-muted mb-4">Tsavo Water was founded with a simple goal: to make accessing clean, premium drinking water as effortless as possible. We source our water from the purest springs and use state-of-the-art filtration to ensure every drop is perfect.</p>
                <p class="text-muted mb-4">Today, we manage a fleet of dedicated drivers, utilizing modern tech to guarantee that your water arrives on time, every time.</p>
                <a href="{{ route('public.products') }}" class="btn btn-primary rounded-pill px-5 fw-bold shadow-sm">Shop Now</a>
            </div>
        </div>
    </div>
</section>
@endsection
