@extends('layouts.public')

@section('page-title', 'Unauthorized Access')

@section('content')
<div class="container text-center py-5 my-5">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <h1 class="display-1 fw-bold text-warning mb-0" style="font-size: 8rem; opacity: 0.2;">403</h1>
            <h2 class="fw-bold mb-3">Access Denied</h2>
            <p class="text-muted mb-5 lead">You do not have the required permissions to view this page. If you believe this is an error, please contact support.</p>
            <a href="{{ url('/') }}" class="btn btn-primary btn-lg rounded-pill px-5 fw-bold shadow">
                <i class="bi bi-shield-lock me-2"></i> Return Home
            </a>
        </div>
    </div>
</div>
@endsection
