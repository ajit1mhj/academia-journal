@extends('layouts.app')
@section('title', 'Assign Reviewers')
@section('page-title', 'Reviewer Assignment')

@section('content')
<div class="row g-3">
    <div class="col-md-7">

        {{-- Article Summary --}}
        <div class="card mb-3">
            <div class="card-header">Manuscript</div>
            <div class="card-body">
                <h6 class="fw-bold">{{ $article->title }}</h6>
                <div class="text-muted small mb-2">{{ $article->keywords }}</div>
                <div class="d-flex gap-3 small text-muted">
                    <span><i class="bi bi-people me-1"></i>
                        {{ $article->authors->pluck('name')->implode(', ') }}
                    </span>
                    <span class="badge badge-{{ $article->status }}">
                        {{ ucfirst(str_replace('_', ' ', $article->status)) }}
                    </span>
                </div>
            </div>
        </div>

        {{-- Assigned Reviewers --}}
        <div class="card">
            <div class="card-header">
                Assigned Reviewers
                <span class="badge bg-secondary ms-2">{{ $assignedReviews->count() }} / 5</span>
            </div>
            <div class="card-body p-0">
                @forelse($assignedReviews as $review)
                <div class="p-3 border-bottom d-flex justify-content-between align-items-center">
                    <div>
                        <div class="fw-semibold small">{{ $review->reviewer->name }}</div>
                        <div class="text-muted" style="font-size:0.75rem">
                            {{ $review->reviewer->institution }}
                        </div>
                        <div class="mt-1">
                            <span class="badge {{ $review->status === 'submitted' ? 'bg-success' : 'bg-warning text-dark' }}">
                                {{ ucfirst($review->status) }}
                            </span>
                            @if($review->deadline)
                            <span class="text-muted small ms-2">
                                Deadline: {{ $review->deadline->format('d M Y') }}
                            </span>
                            @endif
                        </div>
                    </div>
                    @if($review->status === 'pending')
                    <form method="POST"
                          action="{{ route('editor.assignments.remove', [$article, $review]) }}"
                          onsubmit="return confirm('Remove this reviewer?')">
                        @csrf @method('DELETE')
                        <button class="btn btn-sm btn-outline-danger">
                            <i class="bi bi-x-lg"></i>
                        </button>
                    </form>
                    @endif
                </div>
                @empty
                <div class="p-3 text-center text-muted small">No reviewers assigned yet.</div>
                @endforelse
            </div>
        </div>
    </div>

    <div class="col-md-5">

        {{-- Assign New Reviewer --}}
        @if($assignedReviews->count() < 5)
        <div class="card mb-3">
            <div class="card-header">Assign Reviewer</div>
            <div class="card-body">
                <form method="POST"
                      action="{{ route('editor.assignments.assign', $article) }}">
                    @csrf

                    <div class="mb-3">
                        <label class="form-label">Select Reviewer <span class="text-danger">*</span></label>
                        <select name="reviewer_id"
                                class="form-select @error('reviewer_id') is-invalid @enderror"
                                required>
                            <option value="">Choose reviewer</option>
                            @foreach($reviewers as $reviewer)
                                @php
                                    $alreadyAssigned = $assignedReviews
                                        ->pluck('reviewer_id')
                                        ->contains($reviewer->id);
                                @endphp
                                @if(!$alreadyAssigned)
                                <option value="{{ $reviewer->id }}">
                                    {{ $reviewer->name }}
                                    @if($reviewer->institution)
                                        — {{ $reviewer->institution }}
                                    @endif
                                </option>
                                @endif
                            @endforeach
                        </select>
                        @error('reviewer_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Review Deadline <span class="text-danger">*</span></label>
                        <input type="date" name="deadline"
                               class="form-control @error('deadline') is-invalid @enderror"
                               value="{{ old('deadline', now()->addDays(21)->format('Y-m-d')) }}"
                               min="{{ now()->addDay()->format('Y-m-d') }}"
                               required>
                        @error('deadline')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <button type="submit" class="btn btn-primary w-100">
                        <i class="bi bi-person-plus me-2"></i> Assign Reviewer
                    </button>
                </form>
            </div>
        </div>
        @else
        <div class="alert alert-info">
            <i class="bi bi-info-circle me-2"></i>
            Maximum of 5 reviewers have been assigned.
        </div>
        @endif

        {{-- Back Button --}}
        <a href="{{ route('editor.articles.show', $article) }}"
           class="btn btn-outline-secondary w-100">
            <i class="bi bi-arrow-left me-2"></i> Back to Manuscript
        </a>
    </div>
</div>
@endsection