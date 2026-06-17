@extends('layouts.app')
@section('title', 'Edit Member')
@section('page-title', 'Edit Editorial Board Member')

@section('content')
<div class="card" style="max-width:700px">
    <div class="card-header">Edit — {{ $editorialBoard->name }}</div>
    <div class="card-body">
        <form method="POST"
              action="{{ route('admin.editorial-board.update', $editorialBoard) }}"
              enctype="multipart/form-data">
            @csrf @method('PUT')

            <div class="mb-3">
                <label class="form-label">Journal <span class="text-danger">*</span></label>
                <select name="journal_id" class="form-select" required>
                    @foreach($journals as $journal)
                    <option value="{{ $journal->id }}"
                        {{ old('journal_id', $editorialBoard->journal_id) == $journal->id ? 'selected' : '' }}>
                        {{ $journal->title }}
                    </option>
                    @endforeach
                </select>
            </div>

            <div class="row">
                <div class="col-md-6 mb-3">
                    <label class="form-label">Full Name <span class="text-danger">*</span></label>
                    <input type="text" name="name" class="form-control"
                           value="{{ old('name', $editorialBoard->name) }}" required>
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label">Designation</label>
                    <input type="text" name="designation" class="form-control"
                           value="{{ old('designation', $editorialBoard->designation) }}">
                </div>
            </div>

            <div class="row">
                <div class="col-md-6 mb-3">
                    <label class="form-label">Institution</label>
                    <input type="text" name="institution" class="form-control"
                           value="{{ old('institution', $editorialBoard->institution) }}">
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label">Country</label>
                    <input type="text" name="country" class="form-control"
                           value="{{ old('country', $editorialBoard->country) }}">
                </div>
            </div>

            <div class="row">
                <div class="col-md-6 mb-3">
                    <label class="form-label">Category <span class="text-danger">*</span></label>
                    <select name="category" class="form-select" required>
                        @foreach($categories as $key => $label)
                        <option value="{{ $key }}"
                            {{ old('category', $editorialBoard->category) === $key ? 'selected' : '' }}>
                            {{ $label }}
                        </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label">Display Order</label>
                    <input type="number" name="order" class="form-control"
                           value="{{ old('order', $editorialBoard->order) }}" min="0">
                </div>
            </div>

            <div class="mb-3">
                <label class="form-label">Biography</label>
                <textarea name="biography" class="form-control" rows="3">{{ old('biography', $editorialBoard->biography) }}</textarea>
            </div>

            <div class="mb-3">
                <label class="form-label">Photo</label>
                @if($editorialBoard->photo)
                <div class="mb-2">
                    <img src="{{ Storage::url($editorialBoard->photo) }}"
                         class="rounded-circle"
                         width="60" height="60"
                         style="object-fit:cover">
                </div>
                @endif
                <input type="file" name="photo" class="form-control"
                       accept=".jpg,.jpeg,.png,.webp">
                <div class="form-text">Leave empty to keep existing photo.</div>
            </div>

            <div class="d-flex gap-2">
                <button type="submit" class="btn btn-primary">
                    <i class="bi bi-check-lg me-1"></i> Update Member
                </button>
                <a href="{{ route('admin.editorial-board.index') }}"
                   class="btn btn-outline-secondary">Cancel</a>
            </div>
        </form>
    </div>
</div>
@endsection