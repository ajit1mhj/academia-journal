@extends('layouts.app')
@section('title', 'Edit Volume')
@section('page-title', 'Edit Volume')

@section('content')
<div class="card" style="max-width:600px">
    <div class="card-header">Edit — Volume {{ $volume->volume_no }} ({{ $volume->year }})</div>
    <div class="card-body">
        <form method="POST" action="{{ route('admin.volumes.update', $volume) }}">
            @csrf @method('PUT')

            <div class="mb-3">
                <label class="form-label">Journal <span class="text-danger">*</span></label>
                <select name="journal_id" class="form-select" required>
                    @foreach($journals as $journal)
                    <option value="{{ $journal->id }}"
                        {{ old('journal_id', $volume->journal_id) == $journal->id ? 'selected' : '' }}>
                        {{ $journal->title }}
                    </option>
                    @endforeach
                </select>
            </div>

            <div class="row">
                <div class="col-md-6 mb-3">
                    <label class="form-label">Volume Number <span class="text-danger">*</span></label>
                    <input type="number" name="volume_no" class="form-control"
                           value="{{ old('volume_no', $volume->volume_no) }}" required>
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label">Year <span class="text-danger">*</span></label>
                    <input type="number" name="year" class="form-control"
                           value="{{ old('year', $volume->year) }}" required>
                </div>
            </div>

            <div class="mb-3">
                <label class="form-label">Description</label>
                <textarea name="description" class="form-control" rows="3">{{ old('description', $volume->description) }}</textarea>
            </div>

            <div class="mb-3">
                <label class="form-label">Status</label>
                <select name="status" class="form-select">
                    <option value="active"   {{ $volume->status === 'active'   ? 'selected' : '' }}>Active</option>
                    <option value="inactive" {{ $volume->status === 'inactive' ? 'selected' : '' }}>Inactive</option>
                </select>
            </div>

            <div class="d-flex gap-2">
                <button type="submit" class="btn btn-primary">
                    <i class="bi bi-check-lg me-1"></i> Update Volume
                </button>
                <a href="{{ route('admin.volumes.index') }}" class="btn btn-outline-secondary">Cancel</a>
            </div>
        </form>
    </div>
</div>
@endsection