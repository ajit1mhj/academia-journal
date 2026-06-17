@extends('layouts.app')
@section('title', 'My Submissions')
@section('page-title', 'My Submissions')

@section('content')
<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <span>All Submissions</span>
        <a href="{{ route('author.submissions.create') }}" class="btn btn-sm btn-primary">
            <i class="bi bi-plus-lg me-1"></i> New Submission
        </a>
    </div>
    <div class="card-body p-0">
        <table class="table table-hover align-middle mb-0">
            <thead class="table-light">
                <tr>
                    <th>Title</th>
                    <th>Issue</th>
                    <th>Status</th>
                    <th>Submitted</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($articles as $article)
                <tr>
                    <td>
                        <div class="fw-semibold small">{{ Str::limit($article->title, 60) }}</div>
                        <div class="text-muted" style="font-size:0.75rem">{{ $article->subject_area }}</div>
                    </td>
                    <td class="small text-muted">
                        {{ $article->issue ? 'Vol.'.$article->issue->volume->volume_no.' No.'.$article->issue->issue_no : '—' }}
                    </td>
                    <td>
                        <span class="badge badge-{{ $article->status }}">
                            {{ ucfirst(str_replace('_', ' ', $article->status)) }}
                        </span>
                    </td>
                    <td class="small text-muted">{{ $article->created_at->format('d M Y') }}</td>
                    <td>
                        <a href="{{ route('author.submissions.show', $article) }}"
                           class="btn btn-sm btn-outline-primary">
                            <i class="bi bi-eye"></i> View
                        </a>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="text-center text-muted py-4">No submissions found.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    @if($articles->hasPages())
    <div class="card-footer">{{ $articles->links() }}</div>
    @endif
</div>
@endsection