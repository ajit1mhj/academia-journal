@extends('layouts.guest')
@section('title', 'Login')

@section('content')
<h5 class="fw-bold mb-1 text-center">Welcome Back</h5>
<p class="text-muted text-center small mb-4">Sign in to your account</p>

<form method="POST" action="{{ route('login.post') }}">
    @csrf

    <div class="mb-3">
        <label class="form-label">Email Address</label>
        <input type="email" name="email" class="form-control @error('email') is-invalid @enderror"
            value="{{ old('email') }}" placeholder="you@example.com" required autofocus>
        @error('email')
        <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <div class="mb-3">
        <label class="form-label d-flex justify-content-between">
            Password
            <a href="{{ route('password.request') }}" class="small text-decoration-none">Forgot password?</a>
        </label>
        <input type="password" name="password" class="form-control @error('password') is-invalid @enderror"
            placeholder="••••••••" required>
        @error('password')
        <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <div class="mb-3 form-check">
        <input type="checkbox" class="form-check-input" name="remember" id="remember">
        <label class="form-check-label small" for="remember">Remember me</label>
    </div>

    <button type="submit" class="btn btn-primary w-100">
        <i class="bi bi-box-arrow-in-right me-2"></i> Sign In
    </button>
</form>

<hr class="my-4">
<p class="text-center small text-muted">
    Don't have an account?
    <a href="{{ route('register') }}" class="text-decoration-none fw-semibold">Register here</a>
</p>
@endsection