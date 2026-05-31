<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Pure Water Delivery') - Tsavo Water</title>
    
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    
    <!-- Bootstrap CSS & Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    
    <!-- Animate.css -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"/>
    
    <!-- Toastr CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
    
    <!-- AOS Animation CSS -->
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
    
    <!-- Custom CSS -->
    @vite(['resources/css/app.css'])
    @stack('styles')
</head>
<body>

    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-custom fixed-top {{ request()->routeIs('home') ? 'transparent' : '' }}" id="mainNav">
        <div class="container">
            <a class="navbar-brand d-flex align-items-center" href="{{ route('home') }}">
                <i class="bi bi-droplet-fill text-primary fs-3 me-2"></i>
                <span class="fw-bold fs-4">Tsavo <span class="text-primary">Water</span></span>
            </a>
            <button class="navbar-toggler border-0" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <i class="bi bi-list fs-1 text-primary"></i>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav mx-auto">
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('home') ? 'active' : '' }}" href="{{ route('home') }}">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('public.products') ? 'active' : '' }}" href="{{ route('public.products') }}">Products</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('public.about') ? 'active' : '' }}" href="{{ route('public.about') }}">About</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('public.contact') ? 'active' : '' }}" href="{{ route('public.contact') }}">Contact</a>
                    </li>
                </ul>
                <div class="d-flex align-items-center gap-3">
                    @auth
                        @if(auth()->user()->role === 'customer')
                            <a href="{{ route('customer.dashboard') }}" class="btn btn-outline-primary rounded-pill px-4">Dashboard</a>
                        @elseif(auth()->user()->role === 'driver')
                            <a href="{{ route('driver.dashboard') }}" class="btn btn-outline-primary rounded-pill px-4">Driver Portal</a>
                        @else
                            <a href="{{ route('admin.dashboard') }}" class="btn btn-outline-primary rounded-pill px-4">Admin Portal</a>
                        @endif
                    @else
                        <a href="{{ route('login') }}" class="text-dark fw-bold text-decoration-none">Login</a>
                        <a href="{{ route('register') }}" class="btn btn-primary rounded-pill px-4">Sign Up</a>
                    @endauth
                </div>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <main style="{{ request()->routeIs('home') ? '' : 'padding-top: 80px;' }}">
        @yield('content')
    </main>

    <!-- Footer -->
    <footer class="bg-dark text-white pt-5 pb-3 mt-5">
        <div class="container">
            <div class="row g-4 mb-4">
                <div class="col-lg-4">
                    <a class="navbar-brand d-flex align-items-center text-white mb-3" href="{{ route('home') }}">
                        <i class="bi bi-droplet-fill text-accent fs-3 me-2"></i>
                        <span class="fw-bold fs-4">Tsavo <span class="text-accent">Water</span></span>
                    </a>
                    <p class="text-white-50">Providing pure, refreshing water delivery across Nairobi and beyond. Quality you can taste, service you can trust.</p>
                    <div class="d-flex gap-3 mt-4">
                        <a href="#" class="text-white bg-primary bg-opacity-25 rounded-circle p-2 d-inline-flex"><i class="bi bi-facebook"></i></a>
                        <a href="#" class="text-white bg-primary bg-opacity-25 rounded-circle p-2 d-inline-flex"><i class="bi bi-twitter-x"></i></a>
                        <a href="#" class="text-white bg-primary bg-opacity-25 rounded-circle p-2 d-inline-flex"><i class="bi bi-instagram"></i></a>
                    </div>
                </div>
                <div class="col-lg-2 offset-lg-1">
                    <h5 class="fw-bold mb-3">Quick Links</h5>
                    <ul class="list-unstyled d-flex flex-column gap-2">
                        <li><a href="{{ route('home') }}" class="text-white-50 text-decoration-none">Home</a></li>
                        <li><a href="{{ route('public.products') }}" class="text-white-50 text-decoration-none">Shop Products</a></li>
                        <li><a href="{{ route('public.about') }}" class="text-white-50 text-decoration-none">About Us</a></li>
                        <li><a href="{{ route('public.contact') }}" class="text-white-50 text-decoration-none">Contact Support</a></li>
                    </ul>
                </div>
                <div class="col-lg-2">
                    <h5 class="fw-bold mb-3">Legal</h5>
                    <ul class="list-unstyled d-flex flex-column gap-2">
                        <li><a href="#" class="text-white-50 text-decoration-none">Terms of Service</a></li>
                        <li><a href="#" class="text-white-50 text-decoration-none">Privacy Policy</a></li>
                        <li><a href="#" class="text-white-50 text-decoration-none">Refund Policy</a></li>
                    </ul>
                </div>
                <div class="col-lg-3">
                    <h5 class="fw-bold mb-3">Contact Us</h5>
                    <ul class="list-unstyled text-white-50">
                        <li class="mb-2"><i class="bi bi-geo-alt-fill me-2 text-accent"></i> Nairobi, Kenya</li>
                        <li class="mb-2"><i class="bi bi-telephone-fill me-2 text-accent"></i> +254 700 000 000</li>
                        <li class="mb-3"><i class="bi bi-envelope-fill me-2 text-accent"></i> hello@tsavowater.com</li>
                    </ul>
                    <a href="https://wa.me/254700000000" class="btn btn-success rounded-pill w-100">
                        <i class="bi bi-whatsapp me-2"></i> Order via WhatsApp
                    </a>
                </div>
            </div>
            <hr class="border-secondary opacity-25">
            <div class="text-center text-white-50 small mt-3">
                &copy; {{ date('Y') }} Tsavo Water. All rights reserved.
            </div>
        </div>
    </footer>

    <!-- Scripts -->
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
    
    <script>
        // Navbar scroll effect
        window.addEventListener('scroll', function() {
            if (window.scrollY > 50) {
                document.getElementById('mainNav').classList.remove('transparent');
                document.getElementById('mainNav').classList.add('shadow-sm');
            } else {
                @if(request()->routeIs('home'))
                    document.getElementById('mainNav').classList.add('transparent');
                    document.getElementById('mainNav').classList.remove('shadow-sm');
                @endif
            }
        });

        // Toastr config
        toastr.options = {
            "closeButton": true,
            "progressBar": true,
            "positionClass": "toast-top-right",
        };

        @if(Session::has('success'))
            toastr.success("{{ Session::get('success') }}");
        @endif
        @if(Session::has('error'))
            toastr.error("{{ Session::get('error') }}");
        @endif
    </script>

    <!-- AOS Animation JS -->
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <script>
        AOS.init({
            duration: 800,
            easing: 'ease-out-cubic',
            once: true,
            offset: 50
        });
    </script>
    
    @stack('scripts')
</body>
</html>
