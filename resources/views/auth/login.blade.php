@extends('layouts.app')
@section('title', 'Login | Marketplace')

@section('content')
<div class="row justify-content-center my-4">
    <div class="col-md-5 col-lg-4">
        <div class="card border-0 shadow-lg rounded-4 overflow-hidden" style="background:#fff;">
            <div class="card-header bg-navy text-white text-center p-4" style="background: var(--mp-navy);">
                <i class="fa-solid fa-store text-success fs-1 mb-2"></i>
                <h4 class="fw-bold mb-0 text-white">Welcome Back</h4>
                <small class="text-white-50">Log in to manage your ads and messages</small>
            </div>
            <div class="card-body p-4">
                <form method="POST" action="{{ route('login') }}">
                    @csrf
                    <div class="mb-3">
                        <label class="form-label fw-bold small text-muted">Email Address</label>
                        <div class="input-group">
                            <span class="input-group-text bg-light"><i class="fa-solid fa-envelope text-muted"></i></span>
                            <input type="email" name="email" class="form-control" value="{{ old('email') }}" required autofocus placeholder="name@example.com">
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-bold small text-muted">Password</label>
                        <div class="input-group">
                            <span class="input-group-text bg-light"><i class="fa-solid fa-lock text-muted"></i></span>
                            <input type="password" name="password" class="form-control" required placeholder="••••••••">
                        </div>
                    </div>
                    <div class="form-check mb-4">
                        <input type="checkbox" name="remember" class="form-check-input" id="remember">
                        <label class="form-check-label small" for="remember">Remember me on this device</label>
                    </div>
                    <button class="btn btn-warning w-100 fw-bold py-2 text-dark shadow-sm rounded-3">
                        <i class="fa-solid fa-right-to-bracket me-1"></i> LOG IN
                    </button>
                </form>
                <div class="mt-4 text-center border-top pt-3">
                    <p class="small text-muted mb-0">Don't have an account? <a href="{{ route('register') }}" class="fw-bold text-teal" style="color: var(--mp-teal);">Register Now</a></p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
