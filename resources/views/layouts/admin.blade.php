<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Admin Portal') - Tsavo Water Admin</title>
    
    <link href="https://fonts.googleapis.com/css2?family=Sora:wght@400;600;700&family=DM+Sans:wght@400;500;700&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    
    @vite(['resources/css/app.css'])
    @stack('styles')
</head>
<body>

    <div class="wrapper">
        <!-- Sidebar -->
        <nav id="sidebar" class="sidebar shadow-lg">
            <div class="sidebar-header d-flex align-items-center justify-content-between">
                <a href="{{ route('admin.dashboard') }}" class="d-flex align-items-center text-white text-decoration-none">
                    <i class="bi bi-droplet-fill text-secondary fs-3 me-2"></i>
                    <span class="fw-bold fs-5">Tsavo <span class="text-secondary">Admin</span></span>
                </a>
            </div>

            <ul class="list-unstyled components">
                <p>MAIN</p>
                <li class="{{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                    <a href="{{ route('admin.dashboard') }}"><i class="bi bi-grid-1x2"></i> Dashboard</a>
                </li>
                
                <p>CATALOG</p>
                <li class="{{ request()->routeIs('admin.products.*') ? 'active' : '' }}">
                    <a href="{{ route('admin.products.index') }}"><i class="bi bi-box-seam"></i> Products</a>
                </li>
                <li class="{{ request()->routeIs('admin.categories.*') ? 'active' : '' }}">
                    <a href="{{ route('admin.categories.index') }}"><i class="bi bi-tags"></i> Categories</a>
                </li>

                <p>ORDERS & LOGISTICS</p>
                <li class="{{ request()->routeIs('admin.orders.*') ? 'active' : '' }}">
                    <a href="{{ route('admin.orders.index') }}"><i class="bi bi-receipt"></i> Orders</a>
                </li>
                <li class="{{ request()->routeIs('admin.zones.*') ? 'active' : '' }}">
                    <a href="{{ route('admin.zones.index') }}"><i class="bi bi-geo-alt"></i> Delivery Zones</a>
                </li>

                <p>PEOPLE</p>
                <li class="{{ request()->routeIs('admin.customers.*') ? 'active' : '' }}">
                    <a href="{{ route('admin.customers.index') }}"><i class="bi bi-people"></i> Customers</a>
                </li>
                <li class="{{ request()->routeIs('admin.drivers.*') ? 'active' : '' }}">
                    <a href="{{ route('admin.drivers.index') }}"><i class="bi bi-truck"></i> Drivers</a>
                </li>

                <p>ANALYTICS</p>
                <li class="{{ request()->routeIs('admin.analytics') ? 'active' : '' }}">
                    <a href="{{ route('admin.analytics') }}"><i class="bi bi-cash-coin"></i> Finance</a>
                </li>
                <li class="{{ request()->routeIs('admin.reports.*') ? 'active' : '' }}">
                    <a href="{{ route('admin.reports.index') }}"><i class="bi bi-graph-up"></i> Reports</a>
                </li>

                <p>SYSTEM</p>
                <li class="{{ request()->routeIs('admin.settings.*') ? 'active' : '' }}">
                    <a href="{{ route('admin.settings.index') }}"><i class="bi bi-gear"></i> Settings</a>
                </li>
            </ul>
        </nav>

        <!-- Page Content -->
        <div id="content" class="main-content bg-light">
            <div class="topbar sticky-top">
                <button type="button" id="sidebarCollapse" class="btn btn-light border">
                    <i class="bi bi-list fs-5"></i>
                </button>

                <div class="d-flex align-items-center gap-3">
                    <div class="dropdown">
                        <button class="btn btn-light border-0 d-flex align-items-center gap-2" type="button" data-bs-toggle="dropdown">
                            <div class="avatar bg-dark text-white rounded-circle" style="width: 32px; height: 32px;">
                                A
                            </div>
                            <span class="d-none d-md-block">{{ auth()->user()->name }}</span>
                            <i class="bi bi-chevron-down ms-1 small"></i>
                        </button>
                        <ul class="dropdown-menu dropdown-menu-end shadow-sm border-0">
                            <li>
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button type="submit" class="dropdown-item text-danger"><i class="bi bi-box-arrow-right me-2"></i> Logout</button>
                                </form>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>

            <div class="container-fluid p-4">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h2 class="fw-bold mb-0">@yield('title')</h2>
                    @yield('actions')
                </div>
                
                @yield('content')
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
    
    <script>
        $(document).ready(function () {
            $('#sidebarCollapse').on('click', function () {
                $('#sidebar').toggleClass('active');
            });
        });

        toastr.options = { "closeButton": true, "progressBar": true, "positionClass": "toast-top-right" };
        @if(Session::has('success')) toastr.success("{{ Session::get('success') }}"); @endif
        @if(Session::has('error')) toastr.error("{{ Session::get('error') }}"); @endif
    </script>
    @stack('scripts')
</body>
</html>
