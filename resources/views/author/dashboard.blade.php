@extends('layouts.app')
@section('title', 'Author Dashboard')
@section('page-title', 'My Dashboard')

@section('content')
<div class="row g-3 mb-4">
    @foreach($stats as $stat)
    <div class="col-6 col-md-3">
        <div class="stat-card">
            <div class="stat-value">{{ $stat['value'] }}</div>
            <div class="stat-label">{{ $stat['label'] }}</div>
        </div>
    </div>
    @endforeach
</div>

<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <span>My Recent Submissions</span>
        <a href="{{ route('author.submissions.create') }}" class="btn btn-sm btn-primary">
            <i class="bi bi-plus-lg me-1"></i> New Submission
        </a>
    </div>
    <div class="card-body p-0">
        <table class="table table-hover align-middle mb-0">
            <thead class="table-light">
                <tr>
                    <th>Title</th>
                    <th>Status</th>
                    <th>Submitted</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                @php
                    /** @var \App\Models\User $authUser */
                    $authUser = auth()->user();
                @endphp
                @forelse($authUser->articles()->latest()->take(5)->get() as $article)
                <tr>
                    <td class="small fw-semibold">{{ Str::limit($article->title, 60) }}</td>
                    <td>
                        <span class="badge badge-{{ $article->status }}">
                            {{ ucfirst(str_replace('_', ' ', $article->status)) }}
                        </span>
                    </td>
                    <td class="small text-muted">{{ $article->created_at->format('d M Y') }}</td>
                    <td>
                        <a href="{{ route('author.submissions.show', $article) }}"
                           class="btn btn-sm btn-outline-primary">View</a>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="4" class="text-center text-muted py-4">
                        No submissions yet.
                        <a href="{{ route('author.submissions.create') }}">Submit your first manuscript</a>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection