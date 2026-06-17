@extends('layouts.app')
@section('title', 'Edit Profile')
@section('page-title', 'Edit Profile')

@section('content')
<div class="row g-3">
    {{-- Profile Info --}}
    <div class="col-md-7">
        <div class="card mb-3">
            <div class="card-header">Personal Information</div>
            <div class="card-body">
                <form method="POST" action="{{ route('profile.update') }}" enctype="multipart/form-data">
                    @csrf @method('PUT')

                    <div class="mb-3">
                        <label class="form-label">Full Name <span class="text-danger">*</span></label>
                        <input type="text" name="name"
                               class="form-control @error('name') is-invalid @enderror"
                               value="{{ old('name', $user->name) }}" required>
                        @error('name') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Institution</label>
                        <input type="text" name="institution" class="form-control"
                               value="{{ old('institution', $user->institution) }}">
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Country</label>
                            <input type="text" name="country" class="form-control"
                                   value="{{ old('country', $user->country) }}">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Phone</label>
                            <input type="text" name="phone" class="form-control"
                                   value="{{ old('phone', $user->phone) }}">
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">ORCID iD</label>
                        <input type="text" name="orcid"
                               class="form-control @error('orcid') is-invalid @enderror"
                               value="{{ old('orcid', $user->orcid) }}"
                               placeholder="0000-0000-0000-0000">
                        @error('orcid') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Profile Photo</label>
                        @if($user->photo)
                            <div class="mb-2">
                                <img src="{{ Storage::url($user->photo) }}"
                                     class="rounded-circle" width="60" height="60"
                                     style="object-fit:cover">
                            </div>
                        @endif
                        <input type="file" name="photo"
                               class="form-control @error('photo') is-invalid @enderror"
                               accept=".jpg,.jpeg,.png,.webp">
                        @error('photo') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                    <button type="submit" class="btn btn-primary">
                        <i class="bi bi-check-lg me-1"></i> Save Changes
                    </button>
                </form>
            </div>
        </div>
    </div>

    {{-- Change Password --}}
    <div class="col-md-5">
        <div class="card">
            <div class="card-header">Change Password</div>
            <div class="card-body">
                <form method="POST" action="{{ route('profile.password') }}">
                    @csrf @method('PUT')

                    <div class="mb-3">
                        <label class="form-label">Current Password <span class="text-danger">*</span></label>
                        <input type="password" name="current_password"
                               class="form-control @error('current_password') is-invalid @enderror" required>
                        @error('current_password')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label">New Password <span class="text-danger">*</span></label>
                        <input type="password" name="password"
                               class="form-control @error('password') is-invalid @enderror"
                               placeholder="Min. 8 characters" required>
                        @error('password') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Confirm New Password <span class="text-danger">*</span></label>
                        <input type="password" name="password_confirmation"
                               class="form-control" required>
                    </div>

                    <button type="submit" class="btn btn-warning w-100">
                        <i class="bi bi-lock me-1"></i> Update Password
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection