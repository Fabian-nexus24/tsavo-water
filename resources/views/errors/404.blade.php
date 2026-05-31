@extends('layouts.public')

@section('page-title', 'Page Not Found')

@section('content')
<div class="container text-center py-5 my-5">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <h1 class="display-1 fw-bold text-primary mb-0" style="font-size: 8rem; opacity: 0.2;">404</h1>
            <h2 class="fw-bold mb-3">Oops! We couldn't find that drop.</h2>
            <p class="text-muted mb-5 lead">The page you are looking for might have been removed, had its name changed, or is temporarily unavailable.</p>
            <a href="{{ url('/') }}" class="btn btn-primary btn-lg rounded-pill px-5 fw-bold shadow">
                <i class="bi bi-house-door me-2"></i> Return Home
            </a>
        </div>
    </div>
</div>
@endsection
