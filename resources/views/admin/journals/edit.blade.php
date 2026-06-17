@extends('layouts.app')
@section('title', 'Edit Journal')
@section('page-title', 'Edit Journal')

@section('content')
<div class="card" style="max-width:800px">
    <div class="card-header">Edit — {{ $journal->title }}</div>
    <div class="card-body">
        <form method="POST" action="{{ route('admin.journals.update', $journal) }}"
              enctype="multipart/form-data">
            @csrf @method('PUT')

            {{-- Basic Info --}}
            <h6 class="fw-bold text-primary border-bottom pb-2 mb-3">
                Basic Information
            </h6>

            <div class="mb-3">
                <label class="form-label">Journal Title <span class="text-danger">*</span></label>
                <input type="text" name="title"
                       class="form-control @error('title') is-invalid @enderror"
                       value="{{ old('title', $journal->title) }}" required>
                @error('title') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>

            <div class="row">
                <div class="col-md-4 mb-3">
                    <label class="form-label">ISSN (Print)</label>
                    <input type="text" name="issn" class="form-control"
                           value="{{ old('issn', $journal->issn) }}">
                </div>
                <div class="col-md-4 mb-3">
                    <label class="form-label">e-ISSN (Online)</label>
                    <input type="text" name="eissn" class="form-control"
                           value="{{ old('eissn', $journal->eissn) }}">
                </div>
                <div class="col-md-4 mb-3">
                    <label class="form-label">DOI Prefix</label>
                    <input type="text" name="doi_prefix" class="form-control"
                           value="{{ old('doi_prefix', $journal->doi_prefix) }}">
                </div>
            </div>

            <div class="row">
                <div class="col-md-4 mb-3">
                    <label class="form-label">Publication Frequency</label>
                    <select name="publication_frequency" class="form-select">
                        <option value="">Select</option>
                        @foreach(['Monthly','Bi-Monthly','Quarterly','Bi-Annual','Annual'] as $freq)
                        <option value="{{ $freq }}"
                            {{ old('publication_frequency', $journal->publication_frequency) === $freq ? 'selected' : '' }}>
                            {{ $freq }}
                        </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-4 mb-3">
                    <label class="form-label">Language</label>
                    <input type="text" name="language" class="form-control"
                           value="{{ old('language', $journal->language) }}">
                </div>
                <div class="col-md-4 mb-3">
                    <label class="form-label">Contact Email</label>
                    <input type="email" name="contact_email" class="form-control"
                           value="{{ old('contact_email', $journal->contact_email) }}">
                </div>
            </div>

            <div class="mb-3">
                <label class="form-label">Subject Areas</label>
                <input type="text" name="subject_areas" class="form-control"
                       value="{{ old('subject_areas', $journal->subject_areas) }}">
            </div>

            <div class="mb-3">
                <label class="form-label">Description</label>
                <textarea name="description" class="form-control"
                          rows="3">{{ old('description', $journal->description) }}</textarea>
            </div>

            <div class="mb-3">
                <label class="form-label">Aim & Scope</label>
                <textarea name="aim_scope" class="form-control"
                          rows="4">{{ old('aim_scope', $journal->aim_scope) }}</textarea>
            </div>

            <div class="mb-3">
                <label class="form-label">Status</label>
                <select name="status" class="form-select">
                    <option value="active"   {{ $journal->status === 'active'   ? 'selected' : '' }}>Active</option>
                    <option value="inactive" {{ $journal->status === 'inactive' ? 'selected' : '' }}>Inactive</option>
                </select>
            </div>

            {{-- Files --}}
            <h6 class="fw-bold text-primary border-bottom pb-2 mb-3 mt-4">
                Files & Media
            </h6>

            <div class="row">
                <div class="col-md-6 mb-3">
                    <label class="form-label">Cover Image</label>
                    @if($journal->cover_image)
                    <div class="mb-2">
                        <img src="{{ Storage::url($journal->cover_image) }}"
                             alt="Cover"
                             class="rounded shadow-sm"
                             style="width:60px;height:84px;object-fit:cover">
                        <div class="text-muted small mt-1">Current cover</div>
                    </div>
                    @endif
                    <input type="file" name="cover_image"
                           class="form-control @error('cover_image') is-invalid @enderror"
                           accept=".jpg,.jpeg,.png,.webp">
                    <div class="form-text">Leave empty to keep existing.</div>
                    @error('cover_image')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-6 mb-3">
                    <label class="form-label">Journal PDF</label>
                    @if($journal->pdf_file)
                    <div class="mb-2 d-flex align-items-center gap-2">
                        <i class="bi bi-file-earmark-pdf text-danger fs-4"></i>
                        <div>
                            <div class="small fw-semibold">PDF uploaded</div>
                            <a href="{{ Storage::url($journal->pdf_file) }}"
                               target="_blank"
                               class="small text-primary text-decoration-none">
                                View current PDF
                            </a>
                        </div>
                    </div>
                    @endif
                    <input type="file" name="pdf_file"
                           class="form-control @error('pdf_file') is-invalid @enderror"
                           accept=".pdf">
                    <div class="form-text">Leave empty to keep existing. Max 20MB.</div>
                    @error('pdf_file')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <div class="d-flex gap-2 mt-2">
                <button type="submit" class="btn btn-primary">
                    <i class="bi bi-check-lg me-1"></i> Update Journal
                </button>
                <a href="{{ route('admin.journals.index') }}"
                   class="btn btn-outline-secondary">Cancel</a>
            </div>
        </form>
    </div>
</div>
@endsection