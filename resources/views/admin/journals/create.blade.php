@extends('layouts.app')
@section('title', 'Add Journal')
@section('page-title', 'Add New Journal')

@section('content')
<div class="card" style="max-width:800px">
    <div class="card-header">Journal Details</div>
    <div class="card-body">
        <form method="POST" action="{{ route('admin.journals.store') }}"
              enctype="multipart/form-data">
            @csrf

            {{-- Basic Info --}}
            <h6 class="fw-bold text-primary border-bottom pb-2 mb-3">
                Basic Information
            </h6>

            <div class="mb-3">
                <label class="form-label">Journal Title <span class="text-danger">*</span></label>
                <input type="text" name="title"
                       class="form-control @error('title') is-invalid @enderror"
                       value="{{ old('title') }}" required>
                @error('title') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>

            <div class="row">
                <div class="col-md-4 mb-3">
                    <label class="form-label">ISSN (Print)</label>
                    <input type="text" name="issn" class="form-control"
                           value="{{ old('issn') }}" placeholder="XXXX-XXXX">
                </div>
                <div class="col-md-4 mb-3">
                    <label class="form-label">e-ISSN (Online)</label>
                    <input type="text" name="eissn" class="form-control"
                           value="{{ old('eissn') }}" placeholder="XXXX-XXXX">
                </div>
                <div class="col-md-4 mb-3">
                    <label class="form-label">DOI Prefix</label>
                    <input type="text" name="doi_prefix" class="form-control"
                           value="{{ old('doi_prefix') }}" placeholder="e.g. 10.3126">
                </div>
            </div>

            <div class="row">
                <div class="col-md-4 mb-3">
                    <label class="form-label">Publication Frequency</label>
                    <select name="publication_frequency" class="form-select">
                        <option value="">Select</option>
                        @foreach(['Monthly','Bi-Monthly','Quarterly','Bi-Annual','Annual'] as $freq)
                        <option value="{{ $freq }}"
                            {{ old('publication_frequency') === $freq ? 'selected' : '' }}>
                            {{ $freq }}
                        </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-4 mb-3">
                    <label class="form-label">Language</label>
                    <input type="text" name="language" class="form-control"
                           value="{{ old('language', 'English') }}">
                </div>
                <div class="col-md-4 mb-3">
                    <label class="form-label">Contact Email</label>
                    <input type="email" name="contact_email" class="form-control"
                           value="{{ old('contact_email') }}" placeholder="editor@journal.com">
                </div>
            </div>

            <div class="mb-3">
                <label class="form-label">Subject Areas</label>
                <input type="text" name="subject_areas" class="form-control"
                       value="{{ old('subject_areas') }}"
                       placeholder="e.g. Medicine, Engineering, Social Sciences">
            </div>

            <div class="mb-3">
                <label class="form-label">Description</label>
                <textarea name="description" class="form-control"
                          rows="3">{{ old('description') }}</textarea>
            </div>

            <div class="mb-3">
                <label class="form-label">Aim & Scope</label>
                <textarea name="aim_scope" class="form-control"
                          rows="4">{{ old('aim_scope') }}</textarea>
            </div>

            <div class="mb-3">
                <label class="form-label">Status</label>
                <select name="status" class="form-select">
                    <option value="active">Active</option>
                    <option value="inactive">Inactive</option>
                </select>
            </div>

            {{-- Files --}}
            <h6 class="fw-bold text-primary border-bottom pb-2 mb-3 mt-4">
                Files & Media
            </h6>

            <div class="row">
                <div class="col-md-6 mb-3">
                    <label class="form-label">Cover Image</label>
                    <input type="file" name="cover_image"
                           class="form-control @error('cover_image') is-invalid @enderror"
                           accept=".jpg,.jpeg,.png,.webp">
                    <div class="form-text">JPG or PNG. Max 2MB.</div>
                    @error('cover_image')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-6 mb-3">
                    <label class="form-label">Journal PDF</label>
                    <input type="file" name="pdf_file"
                           class="form-control @error('pdf_file') is-invalid @enderror"
                           accept=".pdf">
                    <div class="form-text">PDF only. Max 20MB.</div>
                    @error('pdf_file')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <div class="d-flex gap-2 mt-2">
                <button type="submit" class="btn btn-primary">
                    <i class="bi bi-check-lg me-1"></i> Create Journal
                </button>
                <a href="{{ route('admin.journals.index') }}"
                   class="btn btn-outline-secondary">Cancel</a>
            </div>
        </form>
    </div>
</div>
@endsection