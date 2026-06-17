@extends('layouts.app')
@section('title', 'Add Issue')
@section('page-title', 'Add New Issue')

@section('content')
<div class="card" style="max-width:650px">
    <div class="card-header">Issue Details</div>
    <div class="card-body">
        <form method="POST" action="{{ route('admin.issues.store') }}" enctype="multipart/form-data">
            @csrf

            <div class="mb-3">
                <label class="form-label">Volume <span class="text-danger">*</span></label>
                <select name="volume_id"
                        class="form-select @error('volume_id') is-invalid @enderror" required>
                    <option value="">Select volume</option>
                    @foreach($volumes as $volume)
                    <option value="{{ $volume->id }}"
                        {{ old('volume_id') == $volume->id ? 'selected' : '' }}>
                        {{ $volume->journal->title }} — Vol.{{ $volume->volume_no }} ({{ $volume->year }})
                    </option>
                    @endforeach
                </select>
                @error('volume_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>

            <div class="row">
                <div class="col-md-6 mb-3">
                    <label class="form-label">Issue Number <span class="text-danger">*</span></label>
                    <input type="number" name="issue_no"
                           class="form-control @error('issue_no') is-invalid @enderror"
                           value="{{ old('issue_no') }}" min="1" required>
                    @error('issue_no') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label">Publication Date</label>
                    <input type="date" name="publication_date" class="form-control"
                           value="{{ old('publication_date') }}">
                </div>
            </div>

            <div class="mb-3">
                <label class="form-label">Cover Image</label>
                <input type="file" name="cover_image" class="form-control"
                       accept=".jpg,.jpeg,.png,.webp">
                <div class="form-text">Optional. JPG or PNG. Max 2MB.</div>
            </div>

            <div class="mb-3">
                <label class="form-label">Status</label>
                <select name="status" class="form-select">
                    <option value="draft"    {{ old('status') === 'draft'     ? 'selected' : '' }}>Draft</option>
                    <option value="upcoming" {{ old('status') === 'upcoming'  ? 'selected' : '' }}>Upcoming</option>
                    <option value="published"{{ old('status') === 'published' ? 'selected' : '' }}>Published</option>
                    <option value="archived" {{ old('status') === 'archived'  ? 'selected' : '' }}>Archived</option>
                </select>
            </div>

            <div class="d-flex gap-2">
                <button type="submit" class="btn btn-primary">
                    <i class="bi bi-check-lg me-1"></i> Create Issue
                </button>
                <a href="{{ route('admin.issues.index') }}" class="btn btn-outline-secondary">Cancel</a>
            </div>
        </form>
    </div>
</div>
@endsection