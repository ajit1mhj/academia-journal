@extends('layouts.app')
@section('title', 'Submit Review')
@section('page-title', 'Submit Review')

@section('content')
<div class="row g-3">
    <div class="col-md-7">
        <div class="card mb-3">
            <div class="card-header">Manuscript Details</div>
            <div class="card-body">
                <h6 class="fw-bold">{{ $review->article->title }}</h6>
                <div class="text-muted small mb-2">{{ $review->article->keywords }}</div>
                <p class="small">{{ $review->article->abstract }}</p>
                <div class="mt-3">
                    <div class="text-muted small mb-1">Files</div>
                    @foreach($review->article->files as $file)
                    <div class="small">
                        <i class="bi bi-file-earmark me-1"></i>
                        {{ $file->original_name }}
                        <span class="text-muted">(v{{ $file->version }})</span>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-5">
        @if($review->status === 'submitted')
        <div class="card border-success">
            <div class="card-header bg-success bg-opacity-10">Review Submitted</div>
            <div class="card-body small">
                <div class="mb-2">
                    <strong>Recommendation:</strong>
                    {{ ucfirst(str_replace('_', ' ', $review->recommendation)) }}
                </div>
                <div class="mb-2">
                    <strong>Strengths:</strong><br>{{ $review->strengths }}
                </div>
                <div class="mb-2">
                    <strong>Weaknesses:</strong><br>{{ $review->weaknesses }}
                </div>
                <div>
                    <strong>Comments to Author:</strong><br>{{ $review->comments_author }}
                </div>
            </div>
        </div>
        @else
        <div class="card">
            <div class="card-header">
                Submit Review
                <div class="text-muted small">
                    Deadline: {{ $review->deadline?->format('d M Y') }}
                </div>
            </div>
            <div class="card-body">
                <form method="POST"
                      action="{{ route('reviewer.reviews.submit', $review) }}"
                      enctype="multipart/form-data">
                    @csrf

                    <div class="mb-3">
                        <label class="form-label">Recommendation <span class="text-danger">*</span></label>
                        <select name="recommendation"
                                class="form-select @error('recommendation') is-invalid @enderror" required>
                            <option value="">Select</option>
                            <option value="accept">Accept</option>
                            <option value="minor_revision">Minor Revision</option>
                            <option value="major_revision">Major Revision</option>
                            <option value="reject">Reject</option>
                        </select>
                        @error('recommendation') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Strengths <span class="text-danger">*</span></label>
                        <textarea name="strengths" rows="3"
                                  class="form-control @error('strengths') is-invalid @enderror"
                                  required>{{ old('strengths') }}</textarea>
                        @error('strengths') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Weaknesses <span class="text-danger">*</span></label>
                        <textarea name="weaknesses" rows="3"
                                  class="form-control @error('weaknesses') is-invalid @enderror"
                                  required>{{ old('weaknesses') }}</textarea>
                        @error('weaknesses') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Comments to Author <span class="text-danger">*</span></label>
                        <textarea name="comments_author" rows="4"
                                  class="form-control @error('comments_author') is-invalid @enderror"
                                  required>{{ old('comments_author') }}</textarea>
                        @error('comments_author') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Confidential Comments to Editor</label>
                        <textarea name="comments_editor" rows="3"
                                  class="form-control">{{ old('comments_editor') }}</textarea>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Attach Review File</label>
                        <input type="file" name="review_file" class="form-control"
                               accept=".pdf,.doc,.docx">
                    </div>

                    <button type="submit" class="btn btn-primary w-100">
                        <i class="bi bi-send me-2"></i> Submit Review
                    </button>
                </form>
            </div>
        </div>
        @endif
    </div>
</div>
@endsection