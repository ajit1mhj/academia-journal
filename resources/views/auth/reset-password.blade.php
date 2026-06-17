@extends('layouts.guest')
@section('title', 'Reset Password')

@section('content')
    <h5 class="fw-bold mb-1 text-center">Set New Password</h5>
    <p class="text-muted text-center small mb-4">Choose a strong password.</p>

    <form method="POST" action="{{ route('password.update') }}">
        @csrf
        <input type="hidden" name="token" value="{{ $token }}">

        <div class="mb-3">
            <label class="form-label">Email Address</label>
            <input type="email" name="email"
                   class="form-control @error('email') is-invalid @enderror"
                   value="{{ old('email', $email) }}" required>
            @error('email') <div class="invalid-feedback">{{ $message }}</div> @enderror
        </div>

        <div class="mb-3">
            <label class="form-label">New Password</label>
            <input type="password" name="password"
                   class="form-control @error('password') is-invalid @enderror"
                   placeholder="Min. 8 characters" required>
            @error('password') <div class="invalid-feedback">{{ $message }}</div> @enderror
        </div>

        <div class="mb-3">
            <label class="form-label">Confirm New Password</label>
            <input type="password" name="password_confirmation"
                   class="form-control" placeholder="Repeat password" required>
        </div>

        <button type="submit" class="btn btn-primary w-100">
            <i class="bi bi-lock me-2"></i> Reset Password
        </button>
    </form>
@endsection