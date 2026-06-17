@extends('layouts.app')
@section('title', 'Admin Dashboard')
@section('page-title', 'Admin Dashboard')

@section('content')
<div class="row g-3 mb-4">
    <div class="col-md-3">
        <div class="stat-card">
            <div class="stat-value">{{ $stats['total_users'] }}</div>
            <div class="stat-label"><i class="bi bi-people me-1"></i> Total Users</div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="stat-card">
            <div class="stat-value">{{ $stats['total_submissions'] }}</div>
            <div class="stat-label"><i class="bi bi-file-earmark me-1"></i> Total Submissions</div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="stat-card">
            <div class="stat-value text-success">{{ $stats['published'] }}</div>
            <div class="stat-label"><i class="bi bi-check-circle me-1"></i> Published</div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="stat-card">
            <div class="stat-value text-warning">{{ $stats['under_review'] }}</div>
            <div class="stat-label"><i class="bi bi-hourglass-split me-1"></i> Under Review</div>
        </div>
    </div>
</div>

<div class="row g-3">
    <div class="col-md-6">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <span>Recent Submissions</span>
                <a href="{{ route('editor.articles.index') }}" class="btn btn-sm btn-outline-primary">View All</a>
            </div>
            <div class="card-body p-0">
                <table class="table table-hover mb-0">
                    <thead class="table-light">
                        <tr>
                            <th>Title</th>
                            <th>Status</th>
                            <th>Date</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach(\App\Models\Article::latest()->take(5)->get() as $article)
                        <tr>
                            <td class="small">{{ Str::limit($article->title, 40) }}</td>
                            <td>
                                <span class="badge badge-{{ $article->status }}">
                                    {{ ucfirst(str_replace('_', ' ', $article->status)) }}
                                </span>
                            </td>
                            <td class="small text-muted">{{ $article->created_at->format('d M Y') }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="col-md-6">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <span>Recent Users</span>
                <a href="{{ route('admin.users.index') }}" class="btn btn-sm btn-outline-primary">View All</a>
            </div>
            <div class="card-body p-0">
                <table class="table table-hover mb-0">
                    <thead class="table-light">
                        <tr>
                            <th>Name</th>
                            <th>Role</th>
                            <th>Joined</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach(\App\Models\User::with('role')->latest()->take(5)->get() as $user)
                        <tr>
                            <td class="small">{{ $user->name }}</td>
                            <td><span class="badge bg-secondary">{{ $user->role?->name }}</span></td>
                            <td class="small text-muted">{{ $user->created_at->format('d M Y') }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection