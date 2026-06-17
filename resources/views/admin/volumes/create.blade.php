@extends('layouts.app')
@section('title', 'Add Volume')
@section('page-title', 'Add New Volume')

@section('content')
<div class="card" style="max-width:600px">
    <div class="card-header">Volume Details</div>
    <div class="card-body">
        <form method="POST" action="{{ route('admin.volumes.store') }}">
            @csrf

            <div class="mb-3">
                <label class="form-label">Journal <span class="text-danger">*</span></label>
                <select name="journal_id"
                        class="form-select @error('journal_id') is-invalid @enderror" required>
                    <option value="">Select journal</option>
                    @foreach($journals as $journal)
                    <option value="{{ $journal->id }}"
                        {{ old('journal_id') == $journal->id ? 'selected' : '' }}>
                        {{ $journal->title }}
                    </option>
                    @endforeach
                </select>
                @error('journal_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>

            <div class="row">
                <div class="col-md-6 mb-3">
                    <label class="form-label">Volume Number <span class="text-danger">*</span></label>
                    <input type="number" name="volume_no"
                           class="form-control @error('volume_no') is-invalid @enderror"
                           value="{{ old('volume_no') }}" min="1" required>
                    @error('volume_no') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label">Year <span class="text-danger">*</span></label>
                    <input type="number" name="year"
                           class="form-control @error('year') is-invalid @enderror"
                           value="{{ old('year', date('Y')) }}"
                           min="2000" max="{{ date('Y') + 1 }}" required>
                    @error('year') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>
            </div>

            <div class="mb-3">
                <label class="form-label">Description</label>
                <textarea name="description" class="form-control" rows="3">{{ old('description') }}</textarea>
            </div>

            <div class="mb-3">
                <label class="form-label">Status</label>
                <select name="status" class="form-select">
                    <option value="active">Active</option>
                    <option value="inactive">Inactive</option>
                </select>
            </div>

            <div class="d-flex gap-2">
                <button type="submit" class="btn btn-primary">
                    <i class="bi bi-check-lg me-1"></i> Create Volume
                </button>
                <a href="{{ route('admin.volumes.index') }}" class="btn btn-outline-secondary">Cancel</a>
            </div>
        </form>
    </div>
</div>
@endsection