@extends('layouts.app')
@section('title', 'Submit Manuscript')
@section('page-title', 'Submit New Manuscript')

@section('content')
<div class="card">
    <div class="card-header">Manuscript Submission Form</div>
    <div class="card-body">
        <form method="POST" action="{{ route('author.submissions.store') }}" enctype="multipart/form-data">
            @csrf

            {{-- Step 1: Manuscript Details --}}
            <h6 class="fw-bold text-primary border-bottom pb-2 mb-3">
                <i class="bi bi-1-circle me-2"></i>Manuscript Details
            </h6>

            <div class="mb-3">
                <label class="form-label">Title <span class="text-danger">*</span></label>
                <input type="text" name="title" class="form-control @error('title') is-invalid @enderror"
                    value="{{ old('title') }}" placeholder="Full title of the manuscript" required>
                @error('title') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>

            <div class="mb-3">
                <label class="form-label">Authors <span class="text-danger">*</span></label>
                <input type="text" name="authors"
                    class="form-control @error('authors') is-invalid @enderror"
                    value="{{ old('authors') }}"
                    placeholder="e.g. Ram Sharma, Sita Gurung, Hari Thapa" required>
                <div class="form-text">Separate multiple authors with commas.</div>
                @error('authors') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>

            <div class="mb-3">
                <label class="form-label">Abstract</label>
                <textarea name="abstract" class="form-control @error('abstract') is-invalid @enderror"
                    rows="6" placeholder="Structured abstract (background, methods, results, conclusion)">{{ old('abstract') }}</textarea>
                @error('abstract') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>

            <div class="row">
                <div class="col-md-6 mb-3">
                    <label class="form-label">Keywords</label>
                    <input type="text" name="keywords"
                        class="form-control @error('keywords') is-invalid @enderror"
                        value="{{ old('keywords') }}" placeholder="Separate with commas">
                    @error('keywords') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>
                <div class="col-md-3 mb-3">
                    <label class="form-label">Subject Area</label>
                    <input type="text" name="subject_area" class="form-control"
                        value="{{ old('subject_area') }}" placeholder="e.g. Medicine">
                </div>
                <div class="col-md-3 mb-3">
                    <label class="form-label">Language <span class="text-danger">*</span></label>
                    <select name="language" class="form-select" required>
                        <option value="English" {{ old('language') === 'English' ? 'selected' : '' }}>English</option>
                        <option value="Nepali" {{ old('language') === 'Nepali' ? 'selected' : '' }}>Nepali</option>
                        <option value="Other" {{ old('language') === 'Other' ? 'selected' : '' }}>Other</option>
                    </select>
                </div>
            </div>

            {{-- Step 2: File Uploads --}}
            <h6 class="fw-bold text-primary border-bottom pb-2 mb-3 mt-4">
                <i class="bi bi-2-circle me-2"></i>File Uploads
            </h6>

            <div class="mb-3">
                <label class="form-label">Manuscript File <span class="text-danger">*</span></label>
                <input type="file" name="manuscript"
                    class="form-control @error('manuscript') is-invalid @enderror"
                    accept=".pdf,.doc,.docx,.zip" required>
                <div class="form-text">PDF, DOC, DOCX or ZIP. Max 20MB.</div>
                @error('manuscript') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>

            <div class="mb-3">
                <label class="form-label">Cover Letter</label>
                <input type="file" name="cover_letter" class="form-control"
                    accept=".pdf,.doc,.docx">
                <div class="form-text">Optional. PDF or DOC. Max 10MB.</div>
            </div>

            <div class="mb-3">
                <label class="form-label">Copyright Form</label>
                <input type="file" name="copyright_form" class="form-control"
                    accept=".pdf,.doc,.docx">
                <div class="form-text">Optional. PDF or DOC. Max 5MB.</div>
            </div>

            {{-- Step 3: Agreements --}}
            <h6 class="fw-bold text-primary border-bottom pb-2 mb-3 mt-4">
                <i class="bi bi-3-circle me-2"></i>Author Declarations
            </h6>

            <div class="mb-2">
                <div class="form-check">
                    <input type="checkbox" name="agree_original" id="agree_original"
                        class="form-check-input @error('agree_original') is-invalid @enderror" required>
                    <label class="form-check-label small" for="agree_original">
                        I confirm this manuscript is original and has not been published or submitted elsewhere.
                    </label>
                    @error('agree_original') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>
            </div>

            <div class="mb-2">
                <div class="form-check">
                    <input type="checkbox" name="agree_ethics" id="agree_ethics"
                        class="form-check-input @error('agree_ethics') is-invalid @enderror" required>
                    <label class="form-check-label small" for="agree_ethics">
                        I confirm this research complies with ethical standards and guidelines.
                    </label>
                    @error('agree_ethics') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>
            </div>

            <div class="mb-4">
                <div class="form-check">
                    <input type="checkbox" name="agree_copyright" id="agree_copyright"
                        class="form-check-input @error('agree_copyright') is-invalid @enderror" required>
                    <label class="form-check-label small" for="agree_copyright">
                        I agree to the journal's copyright and open access policies.
                    </label>
                    @error('agree_copyright') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>
            </div>

            <div class="d-flex gap-2">
                <button type="submit" class="btn btn-primary">
                    <i class="bi bi-upload me-2"></i> Submit Manuscript
                </button>
                <a href="{{ route('author.submissions.index') }}" class="btn btn-outline-secondary">Cancel</a>
            </div>
        </form>
    </div>
</div>
@endsection