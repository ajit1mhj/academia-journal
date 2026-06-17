@extends('layouts.guest')
@section('title', 'Register')

@section('content')
<h5 class="fw-bold mb-1 text-center">Create Account</h5>
<p class="text-muted text-center small mb-4">Register as an author</p>

<form method="POST" action="{{ route('register.post') }}">
    @csrf

    <div class="mb-3">
        <label class="form-label">Full Name <span class="text-danger">*</span></label>
        <input type="text" name="name" class="form-control @error('name') is-invalid @enderror"
            value="{{ old('name') }}" placeholder="John Doe" required>
        @error('name') <div class="invalid-feedback">{{ $message }}</div> @enderror
    </div>

    <div class="mb-3">
        <label class="form-label">Email Address <span class="text-danger">*</span></label>
        <input type="email" name="email" class="form-control @error('email') is-invalid @enderror"
            value="{{ old('email') }}" placeholder="you@university.edu.np" required>
        @error('email') <div class="invalid-feedback">{{ $message }}</div> @enderror
    </div>

    <div class="row">
        <div class="col-md-6 mb-3">
            <label class="form-label">Password <span class="text-danger">*</span></label>
            <input type="password" name="password"
                class="form-control @error('password') is-invalid @enderror"
                placeholder="Min. 8 characters" required>
            @error('password') <div class="invalid-feedback">{{ $message }}</div> @enderror
        </div>
        <div class="col-md-6 mb-3">
            <label class="form-label">Confirm Password <span class="text-danger">*</span></label>
            <input type="password" name="password_confirmation"
                class="form-control" placeholder="Repeat password" required>
        </div>
    </div>

    <div class="mb-3">
        <label class="form-label">Institution / University</label>
        <input type="text" name="institution"
            class="form-control @error('institution') is-invalid @enderror"
            value="{{ old('institution') }}" placeholder="Tribhuvan University ">
        @error('institution') <div class="invalid-feedback">{{ $message }}</div> @enderror
    </div>

    <div class="row">
        <div class="col-md-6 mb-3">
            <label class="form-label">Country</label>
            <input type="text" name="country"
                class="form-control @error('country') is-invalid @enderror"
                value="{{ old('country') }}" placeholder="Nepal">
            @error('country') <div class="invalid-feedback">{{ $message }}</div> @enderror
        </div>
        <div class="col-md-6 mb-3">
            <label class="form-label">ORCID iD</label>
            <input type="text" name="orcid"
                class="form-control @error('orcid') is-invalid @enderror"
                value="{{ old('orcid') }}" placeholder="0000-0000-0000-0000">
            @error('orcid') <div class="invalid-feedback">{{ $message }}</div> @enderror
        </div>
    </div>

    <button type="submit" class="btn btn-primary w-100 mt-2">
        <i class="bi bi-person-plus me-2"></i> Create Account
    </button>
</form>

<hr class="my-4">
<p class="text-center small text-muted">
    Already have an account?
    <a href="{{ route('login') }}" class="text-decoration-none fw-semibold">Sign in</a>
</p>
@endsection