@extends('layouts.app')
@section('title', 'User Report')
@section('page-title', 'User Report')

@section('content')

{{-- Role Counts --}}
<div class="d-flex gap-2 flex-wrap mb-3">
    @foreach($roleCounts as $role => $count)
    <span class="badge bg-secondary px-3 py-2">
        {{ ucfirst($role) }}: {{ $count }}
    </span>
    @endforeach
</div>

{{-- Filters --}}
<div class="card mb-3">
    <div class="card-body py-2">
        <form method="GET" action="{{ route('admin.reports.users') }}"
              class="row g-2 align-items-end">
            <div class="col-md-3">
                <label class="form-label small">Role</label>
                <select name="role" class="form-select form-select-sm">
                    <option value="">All Roles</option>
                    @foreach(['admin','editor','reviewer','author'] as $r)
                    <option value="{{ $r }}" {{ request('role') === $r ? 'selected' : '' }}>
                        {{ ucfirst($r) }}
                    </option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-2">
                <label class="form-label small">Status</label>
                <select name="status" class="form-select form-select-sm">
                    <option value="">All</option>
                    <option value="active"   {{ request('status') === 'active'   ? 'selected' : '' }}>Active</option>
                    <option value="inactive" {{ request('status') === 'inactive' ? 'selected' : '' }}>Inactive</option>
                </select>
            </div>
            <div class="col-md-2">
                <label class="form-label small">Joined From</label>
                <input type="date" name="from" class="form-control form-control-sm"
                       value="{{ request('from') }}">
            </div>
            <div class="col-md-3 d-flex gap-1 align-items-end">
                <button type="submit" class="btn btn-sm btn-primary">Filter</button>
                <a href="{{ route('admin.reports.users') }}"
                   class="btn btn-sm btn-outline-secondary">Clear</a>
            </div>
        </form>
    </div>
</div>

{{-- Table --}}
<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <span>{{ $users->total() }} users found</span>
        <a href="{{ route('admin.reports.export', ['type' => 'users']) }}"
           class="btn btn-sm btn-outline-secondary">
            <i class="bi bi-download me-1"></i> Export CSV
        </a>
    </div>
    <div class="card-body p-0">
        <table class="table table-hover align-middle mb-0">
            <thead class="table-light">
                <tr>
                    <th>#</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Role</th>
                    <th>Institution</th>
                    <th>Country</th>
                    <th>Status</th>
                    <th>Joined</th>
                </tr>
            </thead>
            <tbody>
                @forelse($users as $user)
                <tr>
                    <td class="text-muted small">{{ $user->id }}</td>
                    <td class="small fw-semibold">{{ $user->name }}</td>
                    <td class="small text-muted">{{ $user->email }}</td>
                    <td><span class="badge bg-secondary">{{ $user->role?->name }}</span></td>
                    <td class="small text-muted">{{ $user->institution ?? '—' }}</td>
                    <td class="small text-muted">{{ $user->country ?? '—' }}</td>
                    <td>
                        <span class="badge {{ $user->status === 'active' ? 'bg-success' : 'bg-danger' }}">
                            {{ ucfirst($user->status) }}
                        </span>
                    </td>
                    <td class="small text-muted">{{ $user->created_at->format('d M Y') }}</td>
                </tr>
                @empty
                <tr>
                    <td colspan="8" class="text-center text-muted py-4">No users found.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    @if($users->hasPages())
    <div class="card-footer">{{ $users->links() }}</div>
    @endif
</div>
@endsection