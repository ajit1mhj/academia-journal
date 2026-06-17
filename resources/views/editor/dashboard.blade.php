@extends('layouts.app')
@section('title', 'Editor Dashboard')
@section('page-title', 'Editorial Dashboard')

@section('content')
<div class="row g-3 mb-4">
    <div class="col-6 col-md-3">
        <div class="stat-card">
            <div class="stat-value text-primary">{{ $stats['new_submissions'] }}</div>
            <div class="stat-label">New Submissions</div>
        </div>
    </div>
    <div class="col-6 col-md-3">
        <div class="stat-card">
            <div class="stat-value text-warning">{{ $stats['under_review'] }}</div>
            <div class="stat-label">Under Review</div>
        </div>
    </div>
    <div class="col-6 col-md-3">
        <div class="stat-card">
            <div class="stat-value text-success">{{ $stats['accepted'] }}</div>
            <div class="stat-label">Accepted</div>
        </div>
    </div>
    <div class="col-6 col-md-3">
        <div class="stat-card">
            <div class="stat-value text-danger">{{ $stats['rejected'] }}</div>
            <div class="stat-label">Rejected</div>
        </div>
    </div>
</div>

<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <span>Pending Manuscripts</span>
        <a href="{{ route('editor.articles.index') }}" class="btn btn-sm btn-outline-primary">View All</a>
    </div>
    <div class="card-body p-0">
        <table class="table table-hover align-middle mb-0">
            <thead class="table-light">
                <tr>
                    <th>Title</th>
                    <th>Authors</th>
                    <th>Status</th>
                    <th>Submitted</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                @foreach(\App\Models\Article::whereIn('status', ['submitted','under_review'])->latest()->take(8)->get() as $article) <tr>
                    <td class="small fw-semibold">{{ Str::limit($article->title, 50) }}</td>
                    <td class="small text-muted">{{ $article->authors }}</td>
                    <td>
                        <span class="badge badge-{{ $article->status }}">
                            {{ ucfirst(str_replace('_', ' ', $article->status)) }}
                        </span>
                    </td>
                    <td class="small text-muted">{{ $article->created_at->format('d M Y') }}</td>
                    <td>
                        <a href="{{ route('editor.articles.show', $article) }}"
                            class="btn btn-sm btn-outline-primary">Review</a>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection