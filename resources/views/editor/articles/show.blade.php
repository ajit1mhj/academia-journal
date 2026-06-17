@extends('layouts.app')
@section('title', 'Review Manuscript')
@section('page-title', 'Manuscript Review')

@section('content')
<div class="row g-3">
    <div class="col-md-8">

        {{-- Article Info --}}
        <div class="card mb-3">
            <div class="card-header d-flex justify-content-between">
                <span class="fw-semibold">{{ Str::limit($article->title, 60) }}</span>
                <span class="badge badge-{{ $article->status }}">
                    {{ ucfirst(str_replace('_', ' ', $article->status)) }}
                </span>
            </div>
            <div class="card-body">
                <div class="row g-2 mb-3">
                    <div class="col-md-6">
                        <div class="text-muted small">Authors</div>
                        <div class="small">{{ $article->authors }}</div>
                    </div>
                    <div class="col-md-3">
                        <div class="text-muted small">Keywords</div>
                        <div class="small">{{ $article->keywords ?? '—' }}</div>
                    </div>
                    <div class="col-md-3">
                        <div class="text-muted small">Language</div>
                        <div class="small">{{ $article->language }}</div>
                    </div>
                </div>
                <div class="text-muted small mb-1">Abstract</div>
                <p class="small">{{ $article->abstract ?? 'No abstract provided.' }}</p>
            </div>
        </div>

        {{-- Files --}}
        <div class="card mb-3">
            <div class="card-header">Manuscript Files</div>
            <div class="card-body p-0">
                <table class="table table-sm mb-0">
                    <thead class="table-light">
                        <tr>
                            <th>Type</th>
                            <th>Filename</th>
                            <th>Version</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($article->files as $file)
                        <tr>
                            <td><span class="badge bg-secondary">{{ ucfirst($file->file_type) }}</span></td>
                            <td class="small">{{ $file->original_name }}</td>
                            <td class="small">v{{ $file->version }}</td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="3" class="text-center text-muted small py-3">No files.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        {{-- Reviews --}}
        <div class="card mb-3">
            <div class="card-header d-flex justify-content-between align-items-center">
                <span>Reviewer Reports</span>
                <a href="{{ route('editor.assignments.index', $article) }}"
                    class="btn btn-sm btn-outline-primary">
                    <i class="bi bi-person-plus me-1"></i> Assign Reviewer
                </a>
            </div>
            <div class="card-body p-0">
                @forelse($article->reviews as $review)
                <div class="p-3 border-bottom">
                    <div class="d-flex justify-content-between mb-2">
                        <span class="fw-semibold small">{{ $review->reviewer->name }}</span>
                        <span class="badge {{ $review->status === 'submitted' ? 'bg-success' : 'bg-warning text-dark' }}">
                            {{ ucfirst($review->status) }}
                        </span>
                    </div>
                    @if($review->status === 'submitted')
                    <div class="row g-2 small">
                        <div class="col-md-6">
                            <div class="text-muted">Recommendation</div>
                            <strong>{{ ucfirst(str_replace('_', ' ', $review->recommendation)) }}</strong>
                        </div>
                        <div class="col-md-6">
                            <div class="text-muted">Submitted</div>
                            {{ $review->submitted_at?->format('d M Y') }}
                        </div>
                        <div class="col-12">
                            <div class="text-muted">Comments to Author</div>
                            <p class="mb-0">{{ $review->comments_author }}</p>
                        </div>
                    </div>
                    @else
                    <div class="small text-muted">
                        Deadline: {{ $review->deadline?->format('d M Y') }}
                    </div>
                    @endif
                </div>
                @empty
                <div class="p-3 text-center text-muted small">No reviewers assigned yet.</div>
                @endforelse
            </div>
        </div>
    </div>

    <div class="col-md-4">
        {{-- Screening Decision --}}
        @if($article->status === 'submitted')
        <div class="card mb-3">
            <div class="card-header">Initial Screening</div>
            <div class="card-body">
                <form method="POST" action="{{ route('editor.articles.screening', $article) }}">
                    @csrf
                    <div class="mb-3">
                        <label class="form-label">Decision <span class="text-danger">*</span></label>
                        <select name="decision" class="form-select" required>
                            <option value="">Select decision</option>
                            <option value="accept_for_review">Accept for Review</option>
                            <option value="request_correction">Request Correction</option>
                            <option value="reject">Reject</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Remarks</label>
                        <textarea name="remarks" class="form-control" rows="3"
                            placeholder="Optional remarks to author"></textarea>
                    </div>
                    <button type="submit" class="btn btn-primary w-100">Submit Decision</button>
                </form>
            </div>
        </div>
        @endif

        {{-- Publish --}}
        @if($article->status === 'accepted' || $article->status === 'submitted' || $article->status === 'under_review')
        <div class="card mb-3 border-success">
            <div class="card-header bg-success bg-opacity-10">
                <i class="bi bi-globe me-2"></i>Publish Article
            </div>
            <div class="card-body">
                <form method="POST" action="{{ route('editor.articles.publish', $article) }}">
                    @csrf

                    <div class="mb-3">
                        <label class="form-label">Assign to Issue <span class="text-danger">*</span></label>
                        <select name="issue_id" class="form-select" required>
                            <option value="">Select issue</option>
                            @foreach(\App\Models\Issue::with('volume')->orderByDesc('id')->get() as $issue)
                            <option value="{{ $issue->id }}">
                                Vol.{{ $issue->volume->volume_no }}
                                No.{{ $issue->issue_no }}
                                ({{ $issue->volume->year }})
                                — {{ ucfirst($issue->status) }}
                            </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">DOI</label>
                        <input type="text" name="doi" class="form-control"
                            value="{{ $article->doi }}"
                            placeholder="10.xxxx/xxxxx">
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Pages</label>
                        <input type="text" name="pages" class="form-control"
                            value="{{ $article->pages }}"
                            placeholder="1-12">
                    </div>

                    <button type="submit" class="btn btn-success w-100">
                        <i class="bi bi-globe me-2"></i> Publish
                    </button>
                </form>
            </div>
        </div>
        @endif
    </div>
</div>
@endsection