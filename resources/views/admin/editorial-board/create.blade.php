@extends('layouts.app')
@section('title', 'Add Member')
@section('page-title', 'Add Editorial Board Member')

@section('content')
<div class="card" style="max-width:700px">
    <div class="card-header">Member Details</div>
    <div class="card-body">
        <form method="POST" action="{{ route('admin.editorial-board.store') }}"
              enctype="multipart/form-data">
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
                    <label class="form-label">Full Name <span class="text-danger">*</span></label>
                    <input type="text" name="name"
                           class="form-control @error('name') is-invalid @enderror"
                           value="{{ old('name') }}" required>
                    @error('name') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label">Designation</label>
                    <input type="text" name="designation" class="form-control"
                           value="{{ old('designation') }}" placeholder="Professor, Dr., etc.">
                </div>
            </div>

            <div class="row">
                <div class="col-md-6 mb-3">
                    <label class="form-label">Institution</label>
                    <input type="text" name="institution" class="form-control"
                           value="{{ old('institution') }}">
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label">Country</label>
                    <input type="text" name="country" class="form-control"
                           value="{{ old('country') }}">
                </div>
            </div>

            <div class="row">
                <div class="col-md-6 mb-3">
                    <label class="form-label">Category <span class="text-danger">*</span></label>
                    <select name="category"
                            class="form-select @error('category') is-invalid @enderror" required>
                        <option value="">Select category</option>
                        @foreach($categories as $key => $label)
                        <option value="{{ $key }}" {{ old('category') === $key ? 'selected' : '' }}>
                            {{ $label }}
                        </option>
                        @endforeach
                    </select>
                    @error('category') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label">Display Order</label>
                    <input type="number" name="order" class="form-control"
                           value="{{ old('order', 0) }}" min="0">
                </div>
            </div>

            <div class="mb-3">
                <label class="form-label">Biography</label>
                <textarea name="biography" class="form-control" rows="3"
                          placeholder="Short biography...">{{ old('biography') }}</textarea>
            </div>

            <div class="mb-3">
                <label class="form-label">Photo</label>
                <input type="file" name="photo" class="form-control"
                       accept=".jpg,.jpeg,.png,.webp">
                <div class="form-text">Optional. Max 2MB.</div>
            </div>

            <div class="d-flex gap-2">
                <button type="submit" class="btn btn-primary">
                    <i class="bi bi-check-lg me-1"></i> Add Member
                </button>
                <a href="{{ route('admin.editorial-board.index') }}"
                   class="btn btn-outline-secondary">Cancel</a>
            </div>
        </form>
    </div>
</div>
@endsection