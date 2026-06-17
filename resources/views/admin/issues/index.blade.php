@extends('layouts.app')
@section('title', 'Issues')
@section('page-title', 'Issue Management')

@section('content')
<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <span>All Issues</span>
        <a href="{{ route('admin.issues.create') }}" class="btn btn-sm btn-primary">
            <i class="bi bi-plus-lg me-1"></i> Add Issue
        </a>
    </div>
    <div class="card-body p-0">
        <table class="table table-hover align-middle mb-0">
            <thead class="table-light">
                <tr>
                    <th>#</th>
                    <th>Volume</th>
                    <th>Issue</th>
                    <th>Publication Date</th>
                    <th>Articles</th>
                    <th>Status</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($issues as $issue)
                <tr>
                    <td class="text-muted small">{{ $issue->id }}</td>
                    <td class="small">
                        <div class="fw-semibold">Vol.{{ $issue->volume->volume_no }}</div>
                        <div class="text-muted" style="font-size:0.75rem">
                            {{ $issue->volume->journal->title }}
                        </div>
                    </td>
                    <td class="small">Issue {{ $issue->issue_no }}</td>
                    <td class="small text-muted">
                        {{ $issue->publication_date?->format('d M Y') ?? '—' }}
                    </td>
                    <td class="small">{{ $issue->articles->count() }}</td>
                    <td>
                        @php
                            $badgeClass = match($issue->status) {
                                'published' => 'bg-success',
                                'draft'     => 'bg-warning text-dark',
                                'upcoming'  => 'bg-info text-dark',
                                'archived'  => 'bg-secondary',
                                default     => 'bg-secondary',
                            };
                        @endphp
                        <span class="badge {{ $badgeClass }}">
                            {{ ucfirst($issue->status) }}
                        </span>
                    </td>
                    <td>
                        <div class="d-flex gap-1">
                            <a href="{{ route('admin.issues.edit', $issue) }}"
                               class="btn btn-sm btn-outline-primary">
                                <i class="bi bi-pencil"></i>
                            </a>
                            <form method="POST" action="{{ route('admin.issues.destroy', $issue) }}"
                                  onsubmit="return confirm('Delete this issue?')">
                                @csrf @method('DELETE')
                                <button class="btn btn-sm btn-outline-danger">
                                    <i class="bi bi-trash"></i>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" class="text-center text-muted py-4">No issues found.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    @if($issues->hasPages())
    <div class="card-footer">{{ $issues->links() }}</div>
    @endif
</div>
@endsection