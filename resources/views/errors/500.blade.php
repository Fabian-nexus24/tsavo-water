@extends('layouts.public')

@section('page-title', 'Server Error')

@section('content')
<div class="container text-center py-5 my-5">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <h1 class="display-1 fw-bold text-danger mb-0" style="font-size: 8rem; opacity: 0.2;">500</h1>
            <h2 class="fw-bold mb-3">Something went wrong on our end.</h2>
            <p class="text-muted mb-5 lead">We are experiencing some technical difficulties right now. Our technical team has been notified. Please try again later.</p>
            <a href="{{ url('/') }}" class="btn btn-primary btn-lg rounded-pill px-5 fw-bold shadow">
                <i class="bi bi-arrow-clockwise me-2"></i> Try Again
            </a>
        </div>
    </div>
</div>
@endsection
