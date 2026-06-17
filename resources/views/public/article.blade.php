@extends('layouts.public')
@section('title', $article->title)

@section('content')
<div class="py-4 bg-light border-bottom">
    <div class="container">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-0 small">
                <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                <li class="breadcrumb-item"><a href="{{ route('archives') }}">Archives</a></li>
                <li class="breadcrumb-item active">Article</li>
            </ol>
        </nav>
    </div>
</div>

<section class="py-5">
    <div class="container">
        <div class="row g-4">
            <div class="col-md-8">
                <div class="card border-0 shadow-sm">
                    <div class="card-body p-4">

                        {{-- Subject area --}}
                        @if($article->subject_area)
                        <span class="badge bg-primary bg-opacity-10 text-primary mb-3">
                            {{ $article->subject_area }}
                        </span>
                        @endif

                        {{-- Title --}}
                        <h2 class="fw-bold mb-2" style="color:#1a3c5e;line-height:1.3">
                            {{ $article->title }}
                        </h2>
                        @if($article->subtitle)
                        <h5 class="text-muted fw-normal mb-3">{{ $article->subtitle }}</h5>
                        @endif

                        {{-- Authors --}}
                        <div class="mb-3">
                            @foreach($article->authors as $author)
                            <span class="me-3 small fw-semibold">
                                {{ $author->name }}
                                @if($author->pivot->is_corresponding)
                                <sup title="Corresponding Author">*</sup>
                                @endif
                                @if($author->institution)
                                <span class="fw-normal text-muted">({{ $author->institution }})</span>
                                @endif
                            </span>
                            @endforeach
                        </div>

                        <hr>

                        {{-- Meta --}}
                        <div class="row g-2 mb-4 small text-muted">
                            @if($article->doi)
                            <div class="col-auto">
                                <i class="bi bi-link-45deg me-1"></i>
                                <strong>DOI:</strong> {{ $article->doi }}
                            </div>
                            @endif
                            @if($article->pages)
                            <div class="col-auto">
                                <i class="bi bi-file-text me-1"></i>
                                <strong>Pages:</strong> {{ $article->pages }}
                            </div>
                            @endif
                            @if($article->published_at)
                            <div class="col-auto">
                                <i class="bi bi-calendar me-1"></i>
                                <strong>Published:</strong> {{ $article->published_at->format('d M Y') }}
                            </div>
                            @endif
                            <div class="col-auto">
                                <i class="bi bi-eye me-1"></i> {{ $article->views }} views
                            </div>
                            <div class="col-auto">
                                <i class="bi bi-download me-1"></i> {{ $article->downloads }} downloads
                            </div>
                        </div>

                        {{-- Abstract --}}
                        <h5 class="fw-bold mb-2" style="color:#1a3c5e">Abstract</h5>
                        <p class="text-muted">{{ $article->abstract }}</p>

                        {{-- Keywords --}}
                        <div class="mt-3">
                            <strong class="small">Keywords:</strong>
                            @foreach(explode(',', $article->keywords) as $kw)
                            <span class="badge bg-light text-dark border ms-1">{{ trim($kw) }}</span>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                {{-- Download --}}
                <div class="card border-0 shadow-sm mb-3">
                    <div class="card-body text-center">
                        <i class="bi bi-file-earmark-pdf text-danger fs-1 d-block mb-2"></i>
                        <h6 class="fw-bold">Download Article</h6>
                        <a href="{{ route('articles.download', $article) }}"
                            class="btn btn-primary w-100">
                            <i class="bi bi-download me-2"></i> Download PDF
                        </a>
                    </div>
                </div>

                {{-- Issue Info --}}
                @if($article->issue)
                <div class="card border-0 shadow-sm mb-3">
                    <div class="card-body">
                        <h6 class="fw-bold mb-3">Issue Information</h6>
                        <table class="table table-sm table-borderless mb-0">
                            <tr>
                                <td class="text-muted small">Journal</td>
                                <td class="small fw-semibold">AJMS</td>
                            </tr>
                            <tr>
                                <td class="text-muted small">Volume</td>
                                <td class="small">{{ $article->issue->volume->volume_no }}</td>
                            </tr>
                            <tr>
                                <td class="text-muted small">Issue</td>
                                <td class="small">{{ $article->issue->issue_no }}</td>
                            </tr>
                            <tr>
                                <td class="text-muted small">Year</td>
                                <td class="small">{{ $article->issue->volume->year }}</td>
                            </tr>
                        </table>
                    </div>
                </div>
                @endif

                {{-- Share --}}
                <div class="card border-0 shadow-sm">
                    <div class="card-body">
                        <h6 class="fw-bold mb-3">Share Article</h6>
                        <div class="d-flex gap-2 flex-wrap">
                            <a href="https://twitter.com/intent/tweet?text={{ urlencode($article->title) }}&url={{ urlencode(request()->url()) }}"
                                target="_blank" class="btn btn-sm btn-outline-secondary">
                                <i class="bi bi-twitter-x"></i>
                            </a>
                            <a href="https://www.linkedin.com/sharing/share-offsite/?url={{ urlencode(request()->url()) }}"
                                target="_blank" class="btn btn-sm btn-outline-secondary">
                                <i class="bi bi-linkedin"></i>
                            </a>
                            <button class="btn btn-sm btn-outline-secondary"
                                onclick="navigator.clipboard.writeText('{{ request()->url() }}'); this.innerHTML='<i class=\'bi bi-check\'></i> Copied'">
                                <i class="bi bi-link-45deg"></i> Copy Link
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection