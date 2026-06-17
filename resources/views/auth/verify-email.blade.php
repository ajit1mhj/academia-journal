@extends('layouts.guest')
@section('title', 'Verify Email')

@section('content')
<div class="text-center">
    <i class="bi bi-envelope-check text-primary" style="font-size:3rem"></i>
    <h5 class="fw-bold mt-3">Check Your Email</h5>
    <p class="text-muted small">
        We sent a verification link to <strong>{{ auth()->user()->email }}</strong>.
        Click the link to activate your account.
    </p>
</div>

<form method="POST" action="{{ route('verification.resend') }}">
    @csrf
    <button type="submit" class="btn btn-outline-primary w-100">
        <i class="bi bi-arrow-repeat me-2"></i> Resend Verification Email
    </button>
</form>

<form method="POST" action="{{ route('logout') }}" class="mt-3">
    @csrf
    <button type="submit" class="btn btn-link w-100 text-muted small">
        Sign out and use a different account
    </button>
</form>
@endsection