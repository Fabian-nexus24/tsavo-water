<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Customer Portal') - Tsavo Water</title>
    
    <link href="https://fonts.googleapis.com/css2?family=Sora:wght@400;600;700&family=DM+Sans:wght@400;500;700&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
    
    @vite(['resources/css/app.css'])
    @stack('styles')
</head>
<body style="background: linear-gradient(135deg, #f5f7fa 0%, #e8ecf1 100%); min-height: 100vh;">

    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-light bg-white shadow-sm fixed-top">
        <div class="container">
            <a class="navbar-brand d-flex align-items-center" href="{{ route('customer.dashboard') }}">
                <i class="bi bi-droplet-fill text-primary fs-4 me-2"></i>
                <span class="fw-bold fs-5">Tsavo <span class="text-primary">Water</span></span>
            </a>
            
            <button class="navbar-toggler border-0" type="button" data-bs-toggle="collapse" data-bs-target="#customerNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            
            <div class="collapse navbar-collapse" id="customerNav">
                <ul class="navbar-nav ms-auto align-items-center gap-2">
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('customer.dashboard') ? 'active fw-bold text-primary' : '' }}" href="{{ route('customer.dashboard') }}">Dashboard</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('customer.products.*') ? 'active fw-bold text-primary' : '' }}" href="{{ route('customer.products.index') }}">Products</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('customer.orders.*') ? 'active fw-bold text-primary' : '' }}" href="{{ route('customer.orders.index') }}">My Orders</a>
                    </li>
                    <li class="nav-item position-relative mx-2">
                        <a class="nav-link" href="{{ route('customer.cart.index') }}">
                            <i class="bi bi-cart3 fs-5"></i>
                            @php $cartCount = \App\Models\Cart::where('user_id', auth()->id())->sum('quantity'); @endphp
                            @if($cartCount > 0)
                                <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger" style="font-size: 0.65rem;">
                                    {{ $cartCount }}
                                </span>
                            @endif
                        </a>
                    </li>
                    
                    <li class="nav-item dropdown ms-2 border-start ps-3">
                        <a class="nav-link dropdown-toggle d-flex align-items-center gap-2" href="#" id="userDropdown" role="button" data-bs-toggle="dropdown">
                            <div class="avatar bg-primary-light text-white rounded-circle d-flex align-items-center justify-content-center" style="width: 35px; height: 35px; font-weight: 600;">
                                {{ substr(auth()->user()->name, 0, 1) }}
                            </div>
                            <span class="fw-medium d-none d-lg-block">{{ explode(' ', auth()->user()->name)[0] }}</span>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end shadow border-0 mt-2">
                            <li><a class="dropdown-item py-2" href="{{ route('customer.profile.edit') }}"><i class="bi bi-person me-2"></i> Profile</a></li>
                            <li><hr class="dropdown-divider"></li>
                            <li>
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button type="submit" class="dropdown-item py-2 text-danger"><i class="bi bi-box-arrow-right me-2"></i> Logout</button>
                                </form>
                            </li>
                        </ul>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <main style="padding-top: 90px; min-height: 85vh;" class="pb-5">
        <div class="container">
            @yield('content')
        </div>
    </main>

    <!-- Footer -->
    <footer class="bg-white border-top py-4 mt-auto">
        <div class="container text-center text-muted small">
            &copy; {{ date('Y') }} Tsavo Water. Customer Portal.
        </div>
    </footer>

    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
    
    <script>
        toastr.options = { "closeButton": true, "progressBar": true, "positionClass": "toast-bottom-right" };
        @if(Session::has('success')) toastr.success("{{ Session::get('success') }}"); @endif
        @if(Session::has('error')) toastr.error("{{ Session::get('error') }}"); @endif
    </script>
    @stack('scripts')
</body>
</html>
