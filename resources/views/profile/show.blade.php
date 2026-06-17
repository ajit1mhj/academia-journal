@extends('layouts.app')
@section('title', 'My Profile')
@section('page-title', 'My Profile')

@section('content')
<div class="row g-3">
    <div class="col-md-4">
        <div class="card text-center">
            <div class="card-body py-4">
                @if($user->photo)
                    <img src="{{ Storage::url($user->photo) }}"
                         class="rounded-circle mb-3"
                         width="100" height="100"
                         style="object-fit:cover">
                @else
                    <div class="rounded-circle bg-primary text-white d-flex align-items-center justify-content-center mx-auto mb-3"
                         style="width:100px;height:100px;font-size:2rem;font-weight:700">
                        {{ strtoupper(substr($user->name, 0, 1)) }}
                    </div>
                @endif
                <h5 class="fw-bold mb-0">{{ $user->name }}</h5>
                <div class="badge bg-secondary mb-2">{{ ucfirst($user->role?->name) }}</div>
                @if($user->institution)
                    <div class="text-muted small">{{ $user->institution }}</div>
                @endif
                @if($user->country)
                    <div class="text-muted small">{{ $user->country }}</div>
                @endif
                @if($user->orcid)
                    <div class="mt-2">
                        <a href="https://orcid.org/{{ $user->orcid }}"
                           class="small text-decoration-none" target="_blank">
                            <i class="bi bi-link-45deg"></i> ORCID: {{ $user->orcid }}
                        </a>
                    </div>
                @endif
                <div class="mt-3">
                    <a href="{{ route('profile.edit') }}" class="btn btn-sm btn-primary">
                        <i class="bi bi-pencil me-1"></i> Edit Profile
                    </a>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-8">
        @if(isset($stats) && count($stats))
        <div class="row g-2 mb-3">
            @foreach($stats as $stat)
            <div class="col-6 col-md-3">
                <div class="stat-card text-center">
                    <div class="stat-value">{{ $stat['value'] }}</div>
                    <div class="stat-label">{{ $stat['label'] }}</div>
                </div>
            </div>
            @endforeach
        </div>
        @endif

        <div class="card">
            <div class="card-header">Account Information</div>
            <div class="card-body">
                <table class="table table-sm mb-0">
                    <tr>
                        <td class="text-muted" style="width:140px">Email</td>
                        <td>{{ $user->email }}
                            @if($user->email_verified_at)
                                <span class="badge bg-success ms-1">Verified</span>
                            @else
                                <span class="badge bg-warning ms-1">Unverified</span>
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <td class="text-muted">Phone</td>
                        <td>{{ $user->phone ?? '—' }}</td>
                    </tr>
                    <tr>
                        <td class="text-muted">Status</td>
                        <td>
                            <span class="badge {{ $user->status === 'active' ? 'bg-success' : 'bg-danger' }}">
                                {{ ucfirst($user->status) }}
                            </span>
                        </td>
                    </tr>
                    <tr>
                        <td class="text-muted">Member Since</td>
                        <td>{{ $user->created_at->format('d M Y') }}</td>
                    </tr>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection