@extends('layouts.app')
@section('title', 'Register | Marketplace')

@section('content')
<div class="row justify-content-center my-4">
    <div class="col-md-5 col-lg-4">
        <div class="card border-0 shadow-lg rounded-4 overflow-hidden" style="background:#fff;">
            <div class="card-header bg-navy text-white text-center p-4" style="background: var(--mp-navy);">
                <i class="fa-solid fa-user-plus text-warning fs-1 mb-2"></i>
                <h4 class="fw-bold mb-0 text-white">Create Account</h4>
                <small class="text-white-50">Join thousands of buyers & sellers on Marketplace</small>
            </div>
            <div class="card-body p-4">
                <form method="POST" action="{{ route('register') }}">
                    @csrf
                    <div class="mb-3">
                        <label class="form-label fw-bold small text-muted">Full Name</label>
                        <div class="input-group">
                            <span class="input-group-text bg-light"><i class="fa-solid fa-user text-muted"></i></span>
                            <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name') }}" required autofocus placeholder="Rahul Sharma">
                        </div>
                        @error('name')
                            <div class="text-danger small mt-1"><i class="fa-solid fa-circle-exclamation me-1"></i>{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-bold small text-muted">Email Address</label>
                        <div class="input-group">
                            <span class="input-group-text bg-light"><i class="fa-solid fa-envelope text-muted"></i></span>
                            <input type="email" name="email" class="form-control @error('email') is-invalid @enderror" value="{{ old('email') }}" required placeholder="name@example.com">
                        </div>
                        @error('email')
                            <div class="text-danger small mt-1"><i class="fa-solid fa-circle-exclamation me-1"></i>{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-bold small text-muted">Phone / Contact Number *</label>
                        <div class="input-group">
                            <span class="input-group-text bg-light"><i class="fa-solid fa-phone text-muted"></i></span>
                            <input type="tel" name="phone" class="form-control @error('phone') is-invalid @enderror" value="{{ old('phone') }}" required placeholder="e.g. +91 98765 43210 or 9876543210">
                        </div>
                        @error('phone')
                            <div class="text-danger small mt-1"><i class="fa-solid fa-circle-exclamation me-1"></i>{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-bold small text-muted">Password</label>
                        <div class="input-group">
                            <span class="input-group-text bg-light"><i class="fa-solid fa-lock text-muted"></i></span>
                            <input type="password" name="password" class="form-control @error('password') is-invalid @enderror" required placeholder="Min. 6 characters">
                        </div>
                        @error('password')
                            <div class="text-danger small mt-1"><i class="fa-solid fa-circle-exclamation me-1"></i>{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="mb-4">
                        <label class="form-label fw-bold small text-muted">Confirm Password</label>
                        <div class="input-group">
                            <span class="input-group-text bg-light"><i class="fa-solid fa-lock text-muted"></i></span>
                            <input type="password" name="password_confirmation" class="form-control" required placeholder="Repeat password">
                        </div>
                    </div>
                    <button class="btn btn-warning w-100 fw-bold py-2 text-dark shadow-sm rounded-3">
                        <i class="fa-solid fa-check-circle me-1"></i> CREATE ACCOUNT
                    </button>
                </form>
                <div class="mt-4 text-center border-top pt-3">
                    <p class="small text-muted mb-0">Already have an account? <a href="{{ route('login') }}" class="fw-bold text-teal" style="color: var(--mp-teal);">Log In</a></p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
