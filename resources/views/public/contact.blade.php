@extends('layouts.public')

@section('title', 'Contact Us')

@section('content')
<!-- Page Header -->
<section class="py-5 bg-dark text-white position-relative overflow-hidden" style="margin-top: 76px;">
    <div class="position-absolute" style="top: -50px; right: -20px; opacity: 0.05; transform: rotate(15deg);">
        <i class="bi bi-envelope-fill" style="font-size: 30rem;"></i>
    </div>
    <div class="container py-5 position-relative z-1">
        <div class="row">
            <div class="col-lg-8" data-aos="fade-right">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb mb-3">
                        <li class="breadcrumb-item"><a href="{{ route('home') }}" class="text-white-50 text-decoration-none">Home</a></li>
                        <li class="breadcrumb-item active text-white" aria-current="page">Contact Us</li>
                    </ol>
                </nav>
                <h1 class="display-4 fw-bolder mb-3">Get in <span class="text-secondary">Touch</span></h1>
                <p class="lead text-white-50 mb-0">Have a question about your order or our delivery zones? We'd love to hear from you.</p>
            </div>
        </div>
    </div>
</section>

<!-- Contact Form & Info -->
<section class="py-5 my-5">
    <div class="container">
        <div class="row g-5">
            <div class="col-lg-5" data-aos="fade-up">
                <h3 class="fw-bolder mb-4">Contact Information</h3>
                <div class="d-flex align-items-center gap-4 mb-4">
                    <div class="bg-primary bg-opacity-10 text-primary rounded-circle d-flex align-items-center justify-content-center" style="width: 60px; height: 60px;">
                        <i class="bi bi-geo-alt fs-3"></i>
                    </div>
                    <div>
                        <h5 class="fw-bold mb-1">Our Location</h5>
                        <p class="text-muted mb-0">Nairobi, Kenya</p>
                    </div>
                </div>
                
                <div class="d-flex align-items-center gap-4 mb-4">
                    <div class="bg-primary bg-opacity-10 text-primary rounded-circle d-flex align-items-center justify-content-center" style="width: 60px; height: 60px;">
                        <i class="bi bi-telephone fs-3"></i>
                    </div>
                    <div>
                        <h5 class="fw-bold mb-1">Phone Number</h5>
                        <p class="text-muted mb-0">+254 700 000 000</p>
                    </div>
                </div>
                
                <div class="d-flex align-items-center gap-4">
                    <div class="bg-primary bg-opacity-10 text-primary rounded-circle d-flex align-items-center justify-content-center" style="width: 60px; height: 60px;">
                        <i class="bi bi-envelope fs-3"></i>
                    </div>
                    <div>
                        <h5 class="fw-bold mb-1">Email Address</h5>
                        <p class="text-muted mb-0">hello@tsavowater.com</p>
                    </div>
                </div>
            </div>
            
            <div class="col-lg-7" data-aos="fade-left">
                <div class="card border-0 shadow-lg rounded-5 overflow-hidden">
                    <div class="card-body p-5">
                        <h3 class="fw-bolder mb-4">Send Us a Message</h3>
                        <form>
                            <div class="row g-3 mb-3">
                                <div class="col-md-6">
                                    <label class="form-label fw-bold small text-muted">Full Name</label>
                                    <input type="text" class="form-control rounded-3" placeholder="John Doe">
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label fw-bold small text-muted">Email Address</label>
                                    <input type="email" class="form-control rounded-3" placeholder="john@example.com">
                                </div>
                            </div>
                            <div class="mb-4">
                                <label class="form-label fw-bold small text-muted">Message</label>
                                <textarea class="form-control rounded-3" rows="5" placeholder="How can we help you?"></textarea>
                            </div>
                            <button type="button" class="btn btn-primary rounded-pill px-5 fw-bold shadow-sm">Send Message <i class="bi bi-send ms-2"></i></button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
