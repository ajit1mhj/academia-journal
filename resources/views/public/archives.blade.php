@extends('layouts.public')
@section('title', 'Archives')

@section('content')
<div class="py-4 bg-light border-bottom">
    <div class="container">
        <h1 class="h3 fw-bold text-primary mb-0">Archives</h1>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-0 small">
                <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                <li class="breadcrumb-item active">Archives</li>
            </ol>
        </nav>
    </div>
</div>

<section class="py-5">
    <div class="container">
        <div class="row g-4">

            {{-- Search --}}
            <div class="col-md-4">
                <div class="card shadow-sm border-0 mb-3">
                    <div class="card-body">
                        <h6 class="fw-bold mb-3">Search Articles</h6>
                        <form method="GET" action="{{ route('archives') }}">
                            <div class="mb-2">
                                <input type="text" name="keyword" class="form-control form-control-sm"
                                       placeholder="Keywords, title, abstract..."
                                       value="{{ request('keyword') }}">
                            </div>
                            <div class="mb-2">
                                <input type="text" name="author" class="form-control form-control-sm"
                                       placeholder="Author name"
                                       value="{{ request('author') }}">
                            </div>
                            <div class="mb-2">
                                <input type="text" name="doi" class="form-control form-control-sm"
                                       placeholder="DOI"
                                       value="{{ request('doi') }}">
                            </div>
                            <div class="mb-3">
                                <select name="volume" class="form-select form-select-sm">
                                    <option value="">All Volumes</option>
                                    @foreach($volumes as $volume)
                                    <option value="{{ $volume->id }}"
                                        {{ request('volume') == $volume->id ? 'selected' : '' }}>
                                        Vol.{{ $volume->volume_no }} ({{ $volume->year }})
                                    </option>
                                    @endforeach
                                </select>
                            </div>
                            <button type="submit" class="btn btn-primary btn-sm w-100">
                                <i class="bi bi-search me-1"></i> Search
                            </button>
                            @if(request()->hasAny(['keyword','author','doi','volume']))
                            <a href="{{ route('archives') }}" class="btn btn-outline-secondary btn-sm w-100 mt-2">
                                Clear Filters
                            </a>
                            @endif
                        </form>
                    </div>
                </div>

                {{-- Volume Browser --}}
                <div class="card shadow-sm border-0">
                    <div class="card-header bg-white fw-bold">Browse by Volume</div>
                    <div class="list-group list-group-flush">
                        @foreach($volumes as $volume)
                        <div class="list-group-item py-2">
                            <div class="fw-semibold small">
                                Volume {{ $volume->volume_no }} ({{ $volume->year }})
                            </div>
                            <div class="d-flex flex-wrap gap-1 mt-1">
                                @foreach($volume->issues as $issue)
                                <a href="{{ request()->fullUrlWithQuery(['volume' => $volume->id]) }}"
                                   class="badge bg-light text-dark border text-decoration-none">
                                    Issue {{ $issue->issue_no }}
                                </a>
                                @endforeach
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>

            {{-- Articles --}}
            <div class="col-md-8">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <span class="text-muted small">
                        {{ $articles->total() }} article(s) found
                    </span>
                </div>

                @forelse($articles as $article)
                <div class="card article-card mb-3">
                    <div class="card-body">
                        <div class="text-muted small mb-1">{{ $article->subject_area }}</div>
                        <h6 class="fw-bold">
                            <a href="{{ route('articles.show', $article) }}"
                               class="text-decoration-none text-dark">
                                {{ $article->title }}
                            </a>
                        </h6>
                        <div class="text-muted small mb-2">
                            <i class="bi bi-people me-1"></i>
                            {{ $article->authors->pluck('name')->implode(', ') }}
                        </div>
                        <p class="small text-muted mb-2">{{ Str::limit($article->abstract, 180) }}</p>
                        <div class="d-flex flex-wrap gap-3 align-items-center">
                            @if($article->issue)
                            <span class="small text-muted">
                                Vol.{{ $article->issue->volume->volume_no }}
                                No.{{ $article->issue->issue_no }}
                            </span>
                            @endif
                            @if($article->doi)
                            <span class="small text-muted">DOI: {{ $article->doi }}</span>
                            @endif
                            <span class="small text-muted">
                                <i class="bi bi-eye me-1"></i>{{ $article->views }}
                            </span>
                            <div class="ms-auto d-flex gap-1">
                                <a href="{{ route('articles.show', $article) }}"
                                   class="btn btn-sm btn-outline-primary">Read</a>
                                <a href="{{ route('articles.download', $article) }}"
                                   class="btn btn-sm btn-outline-secondary">
                                    <i class="bi bi-download"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
                @empty
                <div class="text-center text-muted py-5">
                    <i class="bi bi-search fs-1 d-block mb-3"></i>
                    No articles found matching your search.
                </div>
                @endforelse

                @if($articles->hasPages())
                <div class="mt-3">{{ $articles->links() }}</div>
                @endif
            </div>
        </div>
    </div>
</section>
@endsection