@extends('layouts.app')
@section('title', 'Submission Report')
@section('page-title', 'Submission Report')

@section('content')

{{-- Status Count Badges --}}
<div class="d-flex gap-2 flex-wrap mb-3">
    @foreach($statusCounts as $status => $count)
    <span class="badge badge-{{ $status }} px-3 py-2">
        {{ ucfirst(str_replace('_', ' ', $status)) }}: {{ $count }}
    </span>
    @endforeach
</div>

{{-- Filters --}}
<div class="card mb-3">
    <div class="card-body py-2">
        <form method="GET" action="{{ route('admin.reports.submissions') }}"
              class="row g-2 align-items-end">
            <div class="col-md-3">
                <label class="form-label small">Status</label>
                <select name="status" class="form-select form-select-sm">
                    <option value="">All Statuses</option>
                    @foreach(['submitted','under_review','revision_requested','accepted','rejected','published'] as $s)
                    <option value="{{ $s }}" {{ request('status') === $s ? 'selected' : '' }}>
                        {{ ucfirst(str_replace('_', ' ', $s)) }}
                    </option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-2">
                <label class="form-label small">From</label>
                <input type="date" name="from" class="form-control form-control-sm"
                       value="{{ request('from') }}">
            </div>
            <div class="col-md-2">
                <label class="form-label small">To</label>
                <input type="date" name="to" class="form-control form-control-sm"
                       value="{{ request('to') }}">
            </div>
            <div class="col-md-3">
                <label class="form-label small">Subject Area</label>
                <input type="text" name="subject_area" class="form-control form-control-sm"
                       value="{{ request('subject_area') }}" placeholder="Filter by subject">
            </div>
            <div class="col-md-2 d-flex gap-1">
                <button type="submit" class="btn btn-sm btn-primary flex-grow-1">Filter</button>
                <a href="{{ route('admin.reports.submissions') }}"
                   class="btn btn-sm btn-outline-secondary">Clear</a>
            </div>
        </form>
    </div>
</div>

{{-- Table --}}
<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <span>{{ $articles->total() }} submissions found</span>
        <a href="{{ route('admin.reports.export', array_merge(request()->query(), ['type' => 'submissions'])) }}"
           class="btn btn-sm btn-outline-secondary">
            <i class="bi bi-download me-1"></i> Export CSV
        </a>
    </div>
    <div class="card-body p-0">
        <table class="table table-hover align-middle mb-0">
            <thead class="table-light">
                <tr>
                    <th>#</th>
                    <th>Title</th>
                    <th>Authors</th>
                    <th>Subject</th>
                    <th>Status</th>
                    <th>Submitted</th>
                </tr>
            </thead>
            <tbody>
                @forelse($articles as $article)
                <tr>
                    <td class="text-muted small">{{ $article->id }}</td>
                    <td>
                        <a href="{{ route('editor.articles.show', $article) }}"
                           class="small fw-semibold text-decoration-none text-dark">
                            {{ Str::limit($article->title, 55) }}
                        </a>
                    </td>
                    <td class="small text-muted">
                        {{ $article->authors->pluck('name')->implode(', ') }}
                    </td>
                    <td class="small text-muted">{{ $article->subject_area ?? '—' }}</td>
                    <td>
                        <span class="badge badge-{{ $article->status }}">
                            {{ ucfirst(str_replace('_', ' ', $article->status)) }}
                        </span>
                    </td>
                    <td class="small text-muted">{{ $article->created_at->format('d M Y') }}</td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="text-center text-muted py-4">No submissions found.</td>
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