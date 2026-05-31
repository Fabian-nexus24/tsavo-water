<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Tsavo Water</title>
    <link href="https://fonts.googleapis.com/css2?family=Sora:wght@400;600;700&family=DM+Sans:wght@400;500;700&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    @vite(['resources/css/app.css'])
    <style>
        .split-layout { min-height: 100vh; display: flex; }
        .split-left { flex: 0 0 55%; background: linear-gradient(135deg, var(--dark) 0%, var(--primary) 100%); color: white; display: flex; flex-direction: column; justify-content: center; padding: 4rem; position: relative; overflow: hidden; }
        .split-right { flex: 1; display: flex; align-items: center; justify-content: center; padding: 3rem; background: var(--bg-color); }
        .auth-form-wrapper { width: 100%; max-width: 400px; }
        @media (max-width: 992px) { .split-left { display: none; } }
    </style>
</head>
<body>

<div class="split-layout">
    <div class="split-left">
        <div class="position-absolute" style="top: -10%; right: -10%; opacity: 0.1;">
            <i class="bi bi-droplet-fill" style="font-size: 40rem;"></i>
        </div>
        <div class="position-relative z-1">
            <a href="{{ route('home') }}" class="d-flex align-items-center text-white text-decoration-none mb-5">
                <i class="bi bi-droplet-fill fs-1 text-accent me-2"></i>
                <span class="fw-bold fs-2 font-heading">Tsavo <span class="text-accent">Water</span></span>
            </a>
            <h1 class="display-4 fw-bold mb-4 font-heading">Welcome Back</h1>
            <p class="lead text-white-50">Log in to manage your orders, track deliveries in real-time, and experience hassle-free hydration.</p>
        </div>
    </div>
    
    <div class="split-right">
        <div class="auth-form-wrapper">
            <div class="text-center d-lg-none mb-4">
                <a href="{{ route('home') }}" class="d-inline-flex align-items-center text-dark text-decoration-none">
                    <i class="bi bi-droplet-fill fs-2 text-primary me-2"></i>
                    <span class="fw-bold fs-3 font-heading">Tsavo <span class="text-primary">Water</span></span>
                </a>
            </div>
            
            <h3 class="fw-bold mb-1 font-heading text-dark">Sign In</h3>
            <p class="text-muted mb-4">Please enter your credentials to continue.</p>
            
            @if(session('error'))
                <div class="alert alert-danger">{{ session('error') }}</div>
            @endif

            <form method="POST" action="{{ route('login') }}">
                @csrf
                
                <div class="form-floating mb-3">
                    <input type="email" class="form-control @error('email') is-invalid @enderror" id="email" name="email" value="{{ old('email') }}" placeholder="name@example.com" required autofocus>
                    <label for="email">Email Address</label>
                    @error('email')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                
                <div class="form-floating mb-4">
                    <input type="password" class="form-control @error('password') is-invalid @enderror" id="password" name="password" placeholder="Password" required>
                    <label for="password">Password</label>
                    @error('password')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
                        <label class="form-check-label text-muted small" for="remember">Remember me</label>
                    </div>
                    @if (Route::has('password.request'))
                        <a href="{{ route('password.request') }}" class="small text-decoration-none">Forgot password?</a>
                    @endif
                </div>
                
                <button type="submit" class="btn btn-primary w-100 py-3 rounded-pill fw-bold mb-4">Sign In</button>
                
                <p class="text-center text-muted">
                    Don't have an account? <a href="{{ route('register') }}" class="text-decoration-none fw-bold">Register here</a>
                </p>
                </div>
            </form>
        </div>
    </div>
</div>

</body>
</html>
