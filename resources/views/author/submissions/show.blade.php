@extends('layouts.app')
@section('title', 'Submission Details')
@section('page-title', 'Submission Details')

@section('content')
<div class="row g-3">
    <div class="col-md-8">
        <div class="card mb-3">
            <div class="card-header d-flex justify-content-between align-items-center">
                <span>Manuscript Details</span>
                <span class="badge badge-{{ $article->status }}">
                    {{ ucfirst(str_replace('_', ' ', $article->status)) }}
                </span>
            </div>
            <div class="card-body">
                <h5 class="fw-bold">{{ $article->title }}</h5>
                @if($article->subtitle)
                    <p class="text-muted">{{ $article->subtitle }}</p>
                @endif

                <hr>

                <div class="row g-2 mb-3">
                    <div class="col-md-6">
                        <div class="text-muted small">Keywords</div>
                        <div class="small">{{ $article->keywords }}</div>
                    </div>
                    <div class="col-md-3">
                        <div class="text-muted small">Subject Area</div>
                        <div class="small">{{ $article->subject_area ?? '—' }}</div>
                    </div>
                    <div class="col-md-3">
                        <div class="text-muted small">Language</div>
                        <div class="small">{{ $article->language }}</div>
                    </div>
                </div>

                <div class="text-muted small mb-1">Abstract</div>
                <p class="small">{{ $article->abstract }}</p>
            </div>
        </div>

        {{-- Files --}}
        <div class="card mb-3">
            <div class="card-header">Uploaded Files</div>
            <div class="card-body p-0">
                <table class="table table-sm mb-0">
                    <thead class="table-light">
                        <tr>
                            <th>File Type</th>
                            <th>Filename</th>
                            <th>Version</th>
                            <th>Uploaded</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($article->files as $file)
                        <tr>
                            <td><span class="badge bg-secondary">{{ ucfirst(str_replace('_', ' ', $file->file_type)) }}</span></td>
                            <td class="small">{{ $file->original_name }}</td>
                            <td class="small">v{{ $file->version }}</td>
                            <td class="small text-muted">{{ $file->created_at->format('d M Y') }}</td>
                        </tr>
                        @empty
                        <tr><td colspan="4" class="text-muted small text-center py-3">No files.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        {{-- Revision Upload --}}
        @if($article->status === 'revision_requested')
        <div class="card border-warning">
            <div class="card-header bg-warning bg-opacity-10">
                <i class="bi bi-exclamation-triangle text-warning me-2"></i>
                Revision Required
            </div>
            <div class="card-body">
                <form method="POST"
                      action="{{ route('author.submissions.revision', $article) }}"
                      enctype="multipart/form-data">
                    @csrf
                    <div class="mb-3">
                        <label class="form-label">Revised Manuscript <span class="text-danger">*</span></label>
                        <input type="file" name="revised_manuscript"
                               class="form-control @error('revised_manuscript') is-invalid @enderror"
                               accept=".pdf,.doc,.docx" required>
                        @error('revised_manuscript') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Response to Reviewers <span class="text-danger">*</span></label>
                        <input type="file" name="response_to_reviewers"
                               class="form-control @error('response_to_reviewers') is-invalid @enderror"
                               accept=".pdf,.doc,.docx" required>
                        @error('response_to_reviewers') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                    <button type="submit" class="btn btn-warning">
                        <i class="bi bi-upload me-2"></i> Upload Revision
                    </button>
                </form>
            </div>
        </div>
        @endif
    </div>

    <div class="col-md-4">
        {{-- Review Summary --}}
        <div class="card mb-3">
            <div class="card-header">Review Status</div>
            <div class="card-body p-0">
                @forelse($article->reviews as $review)
                <div class="p-3 border-bottom">
                    <div class="d-flex justify-content-between align-items-center">
                        <span class="small fw-semibold">Reviewer {{ $loop->iteration }}</span>
                        <span class="badge {{ $review->status === 'submitted' ? 'bg-success' : 'bg-warning' }}">
                            {{ ucfirst($review->status) }}
                        </span>
                    </div>
                    @if($review->status === 'submitted')
                    <div class="mt-2 small">
                        <strong>Recommendation:</strong>
                        {{ ucfirst(str_replace('_', ' ', $review->recommendation)) }}
                    </div>
                    <div class="small text-muted">
                        {{ $review->comments_author }}
                    </div>
                    @endif
                </div>
                @empty
                <div class="p-3 text-muted small text-center">No reviews yet.</div>
                @endforelse
            </div>
        </div>

        {{-- Timeline --}}
        <div class="card">
            <div class="card-header">Timeline</div>
            <div class="card-body">
                <div class="d-flex gap-2 mb-2">
                    <i class="bi bi-circle-fill text-primary mt-1" style="font-size:0.5rem"></i>
                    <div>
                        <div class="small fw-semibold">Submitted</div>
                        <div class="text-muted" style="font-size:0.75rem">
                            {{ $article->created_at->format('d M Y H:i') }}
                        </div>
                    </div>
                </div>
                @if($article->published_at)
                <div class="d-flex gap-2">
                    <i class="bi bi-circle-fill text-success mt-1" style="font-size:0.5rem"></i>
                    <div>
                        <div class="small fw-semibold">Published</div>
                        <div class="text-muted" style="font-size:0.75rem">
                            {{ $article->published_at->format('d M Y') }}
                        </div>
                    </div>
                </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection