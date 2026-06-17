@extends('layouts.app')
@section('title', 'Edit Page')
@section('page-title', 'Edit — {{ $label }}')

@section('content')
<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <span>Editing: <strong>{{ $label }}</strong></span>
        <a href="{{ route('admin.cms.index') }}" class="btn btn-sm btn-outline-secondary">
            <i class="bi bi-arrow-left me-1"></i> Back
        </a>
    </div>
    <div class="card-body">
        <form method="POST" action="{{ route('admin.cms.update', $page) }}"
              enctype="multipart/form-data">
            @csrf @method('PUT')

            {{-- Common fields for all pages --}}
            <div class="row mb-3">
                <div class="col-md-6">
                    <label class="form-label">Meta Title</label>
                    <input type="text" name="meta_title" class="form-control"
                           value="{{ old('meta_title', $content['meta_title'] ?? '') }}"
                           placeholder="SEO page title">
                </div>
                <div class="col-md-6">
                    <label class="form-label">Meta Description</label>
                    <input type="text" name="meta_description" class="form-control"
                           value="{{ old('meta_description', $content['meta_description'] ?? '') }}"
                           placeholder="SEO description">
                </div>
            </div>

            {{-- Home page fields --}}
            @if($page === 'home')
            <div class="mb-3">
                <label class="form-label">Hero Title <span class="text-danger">*</span></label>
                <input type="text" name="hero_title" class="form-control"
                       value="{{ old('hero_title', $content['hero_title'] ?? '') }}" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Hero Subtitle</label>
                <input type="text" name="hero_subtitle" class="form-control"
                       value="{{ old('hero_subtitle', $content['hero_subtitle'] ?? '') }}">
            </div>
            <div class="mb-3">
                <label class="form-label">Hero Button Text</label>
                <input type="text" name="hero_button" class="form-control"
                       value="{{ old('hero_button', $content['hero_button'] ?? '') }}">
            </div>
            <div class="mb-3">
                <label class="form-label">Banner Image</label>
                <input type="file" name="banner_image" class="form-control" accept="image/*">
            </div>
            <div class="mb-3">
                <label class="form-label">Section 1 Title</label>
                <input type="text" name="section1_title" class="form-control"
                       value="{{ old('section1_title', $content['section1_title'] ?? '') }}">
            </div>
            <div class="mb-3">
                <label class="form-label">Section 1 Body</label>
                <textarea name="section1_body" class="form-control" rows="5">{{ old('section1_body', $content['section1_body'] ?? '') }}</textarea>
            </div>
            @endif

            {{-- Contact page fields --}}
            @if($page === 'contact')
            <div class="mb-3">
                <label class="form-label">Address</label>
                <textarea name="address" class="form-control" rows="2">{{ old('address', $content['address'] ?? '') }}</textarea>
            </div>
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label class="form-label">Email</label>
                    <input type="email" name="email" class="form-control"
                           value="{{ old('email', $content['email'] ?? '') }}">
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label">Phone</label>
                    <input type="text" name="phone" class="form-control"
                           value="{{ old('phone', $content['phone'] ?? '') }}">
                </div>
            </div>
            <div class="mb-3">
                <label class="form-label">Office Hours</label>
                <input type="text" name="office_hours" class="form-control"
                       value="{{ old('office_hours', $content['office_hours'] ?? '') }}">
            </div>
            <div class="mb-3">
                <label class="form-label">Google Map Embed URL</label>
                <input type="text" name="map_embed" class="form-control"
                       value="{{ old('map_embed', $content['map_embed'] ?? '') }}"
                       placeholder="https://maps.google.com/...">
            </div>
            @endif

            {{-- Pages with title + body (about, aim-scope, ethics, policies) --}}
            @if(in_array($page, ['about','aim-scope','publication-ethics','editorial-policies']))
            <div class="mb-3">
                <label class="form-label">Page Title <span class="text-danger">*</span></label>
                <input type="text" name="title" class="form-control"
                       value="{{ old('title', $content['title'] ?? '') }}" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Content <span class="text-danger">*</span></label>
                <textarea name="body" class="form-control" rows="15" required>{{ old('body', $content['body'] ?? '') }}</textarea>
            </div>
            @if($page === 'aim-scope')
            <div class="mb-3">
                <label class="form-label">Topics (one per line)</label>
                <textarea name="topics" class="form-control" rows="8"
                          placeholder="Cardiology&#10;Oncology&#10;Neuroscience">{{ old('topics', $content['topics'] ?? '') }}</textarea>
            </div>
            @endif
            @if($page === 'about')
            <div class="row">
                <div class="col-md-4 mb-3">
                    <label class="form-label">Founded Year</label>
                    <input type="text" name="founded_year" class="form-control"
                           value="{{ old('founded_year', $content['founded_year'] ?? '') }}">
                </div>
                <div class="col-md-4 mb-3">
                    <label class="form-label">ISSN (Print)</label>
                    <input type="text" name="issn" class="form-control"
                           value="{{ old('issn', $content['issn'] ?? '') }}">
                </div>
                <div class="col-md-4 mb-3">
                    <label class="form-label">ISSN (Online)</label>
                    <input type="text" name="eissn" class="form-control"
                           value="{{ old('eissn', $content['eissn'] ?? '') }}">
                </div>
            </div>
            <div class="mb-3">
                <label class="form-label">Cover Image</label>
                <input type="file" name="cover_image" class="form-control" accept="image/*">
            </div>
            @endif
            @endif

            <div class="d-flex gap-2 mt-2">
                <button type="submit" class="btn btn-primary">
                    <i class="bi bi-check-lg me-1"></i> Save Changes
                </button>
                <a href="{{ route('admin.cms.index') }}" class="btn btn-outline-secondary">Cancel</a>
            </div>
        </form>
    </div>
</div>
@endsection