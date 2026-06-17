@extends('layouts.app')
@section('title', 'Edit Issue')
@section('page-title', 'Edit Issue')

@section('content')
<div class="card" style="max-width:650px">
    <div class="card-header">Edit — Vol.{{ $issue->volume->volume_no }} Issue {{ $issue->issue_no }}</div>
    <div class="card-body">
        <form method="POST" action="{{ route('admin.issues.update', $issue) }}" enctype="multipart/form-data">
            @csrf @method('PUT')

            <div class="mb-3">
                <label class="form-label">Volume <span class="text-danger">*</span></label>
                <select name="volume_id" class="form-select" required>
                    @foreach($volumes as $volume)
                    <option value="{{ $volume->id }}"
                        {{ old('volume_id', $issue->volume_id) == $volume->id ? 'selected' : '' }}>
                        {{ $volume->journal->title }} — Vol.{{ $volume->volume_no }} ({{ $volume->year }})
                    </option>
                    @endforeach
                </select>
            </div>

            <div class="row">
                <div class="col-md-6 mb-3">
                    <label class="form-label">Issue Number <span class="text-danger">*</span></label>
                    <input type="number" name="issue_no" class="form-control"
                           value="{{ old('issue_no', $issue->issue_no) }}" required>
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label">Publication Date</label>
                    <input type="date" name="publication_date" class="form-control"
                           value="{{ old('publication_date', $issue->publication_date?->format('Y-m-d')) }}">
                </div>
            </div>

            <div class="mb-3">
                <label class="form-label">Cover Image</label>
                @if($issue->cover_image)
                <div class="mb-2">
                    <img src="{{ Storage::url($issue->cover_image) }}"
                         alt="Cover" class="rounded"
                         style="width:80px;height:110px;object-fit:cover">
                </div>
                @endif
                <input type="file" name="cover_image" class="form-control"
                       accept=".jpg,.jpeg,.png,.webp">
                <div class="form-text">Leave empty to keep existing cover.</div>
            </div>

            <div class="mb-3">
                <label class="form-label">Status</label>
                <select name="status" class="form-select">
                    @foreach(['draft','upcoming','published','archived'] as $s)
                    <option value="{{ $s }}" {{ $issue->status === $s ? 'selected' : '' }}>
                        {{ ucfirst($s) }}
                    </option>
                    @endforeach
                </select>
            </div>

            <div class="d-flex gap-2">
                <button type="submit" class="btn btn-primary">
                    <i class="bi bi-check-lg me-1"></i> Update Issue
                </button>
                <a href="{{ route('admin.issues.index') }}" class="btn btn-outline-secondary">Cancel</a>
            </div>
        </form>
    </div>
</div>
@endsection