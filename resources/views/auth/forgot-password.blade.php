@extends('layouts.guest')
@section('title', 'Forgot Password')

@section('content')
    <h5 class="fw-bold mb-1 text-center">Reset Password</h5>
    <p class="text-muted text-center small mb-4">
        Enter your email and we'll send you a reset link.
    </p>

    <form method="POST" action="{{ route('password.email') }}">
        @csrf
        <div class="mb-3">
            <label class="form-label">Email Address</label>
            <input type="email" name="email"
                   class="form-control @error('email') is-invalid @enderror"
                   value="{{ old('email') }}" placeholder="you@example.com" required autofocus>
            @error('email') <div class="invalid-feedback">{{ $message }}</div> @enderror
        </div>

        <button type="submit" class="btn btn-primary w-100">
            <i class="bi bi-envelope me-2"></i> Send Reset Link
        </button>
    </form>

    <p class="text-center small text-muted mt-4">
        <a href="{{ route('login') }}" class="text-decoration-none">
            <i class="bi bi-arrow-left me-1"></i> Back to login
        </a>
    </p>
@endsection