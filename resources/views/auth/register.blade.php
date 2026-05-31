<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register - Tsavo Water</title>
    <link href="https://fonts.googleapis.com/css2?family=Sora:wght@400;600;700&family=DM+Sans:wght@400;500;700&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    @vite(['resources/css/app.css'])
    <style>
        .split-layout { min-height: 100vh; display: flex; }
        .split-left { flex: 0 0 55%; background: linear-gradient(135deg, var(--secondary) 0%, var(--primary-light) 100%); color: white; display: flex; flex-direction: column; justify-content: center; padding: 4rem; position: relative; overflow: hidden; }
        .split-right { flex: 1; display: flex; align-items: center; justify-content: center; padding: 3rem; background: var(--bg-color); }
        .auth-form-wrapper { width: 100%; max-width: 450px; }
        @media (max-width: 992px) { .split-left { display: none; } }
    </style>
</head>
<body>

<div class="split-layout">
    <div class="split-left">
        <div class="position-absolute" style="top: -10%; left: -10%; opacity: 0.1;">
            <i class="bi bi-water" style="font-size: 40rem;"></i>
        </div>
        <div class="position-relative z-1">
            <a href="{{ route('home') }}" class="d-flex align-items-center text-white text-decoration-none mb-5">
                <i class="bi bi-droplet-fill fs-1 text-dark me-2"></i>
                <span class="fw-bold fs-2 font-heading text-dark">Tsavo Water</span>
            </a>
            <h1 class="display-4 fw-bold mb-4 font-heading text-dark">Join Our Community</h1>
            <p class="lead text-dark" style="opacity: 0.8;">Sign up today to get fresh, pure water delivered directly to your doorstep. Experience the best hydration service in Nairobi.</p>
            
            <div class="mt-5 d-flex gap-4">
                <div class="d-flex align-items-center gap-2 text-dark">
                    <i class="bi bi-check-circle-fill fs-4"></i>
                    <span class="fw-bold">Fast Delivery</span>
                </div>
                <div class="d-flex align-items-center gap-2 text-dark">
                    <i class="bi bi-check-circle-fill fs-4"></i>
                    <span class="fw-bold">Pure Quality</span>
                </div>
                <div class="d-flex align-items-center gap-2 text-dark">
                    <i class="bi bi-check-circle-fill fs-4"></i>
                    <span class="fw-bold">Easy Payments</span>
                </div>
            </div>
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
            
            <h3 class="fw-bold mb-1 font-heading text-dark">Create an Account</h3>
            <p class="text-muted mb-4">Fill in the details below to get started.</p>

            <form method="POST" action="{{ route('register') }}">
                @csrf
                
                <div class="form-floating mb-3">
                    <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" value="{{ old('name') }}" placeholder="John Doe" required autofocus>
                    <label for="name">Full Name</label>
                    @error('name')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>

                <div class="form-floating mb-3">
                    <input type="email" class="form-control @error('email') is-invalid @enderror" id="email" name="email" value="{{ old('email') }}" placeholder="name@example.com" required>
                    <label for="email">Email Address</label>
                    @error('email')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                
                <div class="form-floating mb-3">
                    <input type="text" class="form-control @error('phone') is-invalid @enderror" id="phone" name="phone" value="{{ old('phone') }}" placeholder="0700000000" required>
                    <label for="phone">Phone Number</label>
                    @error('phone')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <div class="form-floating">
                            <input type="password" class="form-control @error('password') is-invalid @enderror" id="password" name="password" placeholder="Password" required>
                            <label for="password">Password</label>
                            @error('password')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                    </div>
                    <div class="col-md-6 mb-4">
                        <div class="form-floating">
                            <input type="password" class="form-control" id="password_confirmation" name="password_confirmation" placeholder="Confirm Password" required>
                            <label for="password_confirmation">Confirm Password</label>
                        </div>
                    </div>
                </div>
                
                <button type="submit" class="btn btn-primary w-100 py-3 rounded-pill fw-bold mb-4">Register</button>
                
                <p class="text-center text-muted">
                    Already have an account? <a href="{{ route('login') }}" class="text-decoration-none fw-bold">Sign In here</a>
                </p>
            </form>
        </div>
    </div>
</div>

</body>
</html>
