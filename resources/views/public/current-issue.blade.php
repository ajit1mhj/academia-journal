@extends('layouts.public')
@section('title', 'Current Issue')

@section('content')

{{-- Page Header --}}
<div class="py-3 bg-light border-bottom">
    <div class="container">
        <h1 class="h4 fw-bold mb-0" style="color:#1a3c5e">Current Issue</h1>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-0 small">
                <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                <li class="breadcrumb-item active">Current Issue</li>
            </ol>
        </nav>
    </div>
</div>

<section class="py-4">
    <div class="container">
        <div class="row g-4">

            {{-- LEFT SIDEBAR --}}
            <div class="col-md-3">

                {{-- Journal Cover + PDF --}}
                @php
                $journal = \App\Models\Journal::first();
                $latestIssue = \App\Models\Issue::where('status','published')
                ->with('volume')
                ->latest('publication_date')
                ->first();
                @endphp

                {{-- Cover Image --}}
                @if($journal?->cover_image)
                <div class="text-center mb-2">
                    <img src="{{ Storage::url($journal->cover_image) }}"
                        alt="Journal Cover"
                        class="img-fluid rounded shadow-sm"
                        style="max-width:140px">
                </div>
                @elseif($latestIssue?->cover_image)
                <div class="text-center mb-2">
                    <img src="{{ Storage::url($latestIssue->cover_image) }}"
                        alt="Issue Cover"
                        class="img-fluid rounded shadow-sm"
                        style="max-width:140px">
                </div>
                @else
                <div class="text-center mb-2">
                    <div class="rounded shadow-sm d-flex align-items-center justify-content-center mx-auto"
                        style="width:140px;height:190px;background:#1a3c5e">
                        <div class="text-white text-center px-2">
                            <i class="bi bi-journal-richtext fs-1 d-block mb-2"></i>
                            <div class="small fw-semibold">AJMS</div>
                        </div>
                    </div>
                </div>
                @endif


                {{-- ISSN Info --}}
                @if($journal)
                <div class="card border-0 shadow-sm mb-3">
                    <div class="card-body py-2 px-3 small">
                        @if($journal->issn)
                        <div class="mb-1">
                            <span class="text-muted">ISSN:</span>
                            <strong>{{ $journal->issn }}</strong>
                        </div>
                        @endif
                        @if($journal->eissn)
                        <div>
                            <span class="text-muted">e-ISSN:</span>
                            <strong>{{ $journal->eissn }}</strong>
                        </div>
                        @endif
                    </div>
                </div>
                @endif

                {{-- Archive Tree --}}
                <div class="card border-0 shadow-sm">
                    <div class="card-header py-2 fw-bold small"
                        style="background:#1a3c5e;color:#fff;border-radius:8px 8px 0 0">
                        <i class="bi bi-archive me-2"></i>JOURNAL ARCHIVE
                    </div>
                    <div class="card-body p-0">
                        @php
                        $volumes = \App\Models\Volume::with('issues')
                        ->orderByDesc('year')
                        ->orderByDesc('volume_no')
                        ->get();
                        @endphp

                        @forelse($volumes as $volume)
                        <div class="border-bottom">
                            <button class="btn btn-link w-100 text-start text-dark fw-semibold small px-3 py-2 d-flex justify-content-between align-items-center"
                                data-bs-toggle="collapse"
                                data-bs-target="#vol-{{ $volume->id }}"
                                style="text-decoration:none">
                                <span>
                                    <i class="bi bi-collection me-1 text-primary"></i>
                                    Volume {{ $volume->volume_no }} ({{ $volume->year }})
                                </span>
                                <i class="bi bi-chevron-down small text-muted"></i>
                            </button>
                            <div class="collapse show" id="vol-{{ $volume->id }}">
                                @foreach($volume->issues as $iss)
                                @php
                                $activeIssue = isset($issue) && $issue->id === $iss->id;
                                @endphp
                                <a href="{{ route('current-issue') }}?issue={{ $iss->id }}"
                                    class="d-flex justify-content-between align-items-center px-4 py-1
                                          text-decoration-none small border-top
                                          {{ $activeIssue
                                              ? 'fw-bold text-primary bg-primary bg-opacity-10'
                                              : 'text-muted bg-light' }}">
                                    <span>
                                        <i class="bi bi-file-text me-1"></i>
                                        Issue {{ $iss->issue_no }}
                                    </span>
                                    @if($iss->status === 'published')
                                    <span class="badge bg-success" style="font-size:0.6rem">Published</span>
                                    @elseif($iss->status === 'upcoming')
                                    <span class="badge bg-info text-dark" style="font-size:0.6rem">Upcoming</span>
                                    @else
                                    <span class="text-muted" style="font-size:0.65rem">In Progress</span>
                                    @endif
                                </a>
                                @endforeach
                            </div>
                        </div>
                        @empty
                        <div class="p-3 text-muted small text-center">No volumes yet.</div>
                        @endforelse
                    </div>
                </div>

            </div>

            {{-- RIGHT MAIN CONTENT --}}
            <div class="col-md-9">

                @if($issue)

                {{-- Issue Header --}}
                <div class="card border-0 shadow-sm mb-4">
                    <div class="card-header py-3 px-4"
                        style="background:#f0f4f8;border-bottom:3px solid #1a3c5e">
                        <div class="d-flex align-items-center gap-3">
                            @if($issue->cover_image)
                            <img src="{{ Storage::url($issue->cover_image) }}"
                                alt="Cover"
                                class="rounded shadow-sm"
                                style="width:70px;height:95px;object-fit:cover">
                            @endif
                            <div class="flex-grow-1">
                                <h4 class="fw-bold mb-1" style="color:#1a3c5e">
                                    Volume {{ $issue->volume->volume_no }},
                                    Issue {{ $issue->issue_no }}
                                    @if($issue->publication_date)
                                    ({{ $issue->publication_date->format('Y') }})
                                    @endif
                                </h4>
                                @if($issue->publication_date)
                                <div class="text-muted small">
                                    <i class="bi bi-calendar me-1"></i>
                                    Published: {{ $issue->publication_date->format('d F Y') }}
                                </div>
                                @endif
                                <div class="text-muted small">
                                    <i class="bi bi-file-earmark-text me-1"></i>
                                    {{ $issue->articles->count() }} article(s)
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Articles --}}
                <h5 class="fw-bold mb-3 pb-2 border-bottom"
                    style="color:#1a3c5e;border-color:#1a3c5e !important">
                    <i class="bi bi-journals me-2"></i>Articles in This Issue
                </h5>

                @forelse($issue->articles as $article)
                <div class="card border-0 shadow-sm mb-3 article-item">
                    <div class="card-body p-4">

                        {{-- Subject & Meta Badges --}}
                        <div class="d-flex gap-2 mb-2 flex-wrap">
                            @if($article->subject_area)
                            <span class="badge bg-primary bg-opacity-10 text-primary small">
                                {{ $article->subject_area }}
                            </span>
                            @endif
                            @if($article->pages)
                            <span class="badge bg-light text-muted border small">
                                pp. {{ $article->pages }}
                            </span>
                            @endif
                            <span class="badge bg-light text-muted border small">
                                <i class="bi bi-eye me-1"></i>{{ $article->views }} views
                            </span>
                            <span class="badge bg-light text-muted border small">
                                <i class="bi bi-download me-1"></i>{{ $article->downloads }} downloads
                            </span>
                        </div>

                        {{-- Title --}}
                        <h5 class="fw-bold mb-1" style="font-size:1.05rem">
                            <a href="{{ route('articles.show', $article) }}"
                                class="text-decoration-none"
                                style="color:#1a3c5e">
                                {{ $article->title }}
                            </a>
                        </h5>

                        {{-- Authors --}}
                        <div class="text-muted small mb-2">
                            <i class="bi bi-people me-1"></i>
                            {{ $article->authors }}
                        </div>

                        {{-- Abstract --}}
                        <p class="small text-muted mb-3">
                            {{ Str::limit($article->abstract, 250) }}
                        </p>

                        {{-- Footer --}}
                        <div class="d-flex align-items-center gap-3 flex-wrap">
                            @if($article->doi)
                            <span class="small text-muted">
                                <i class="bi bi-link-45deg me-1"></i>
                                DOI: {{ $article->doi }}
                            </span>
                            @endif

                            <div class="ms-auto d-flex gap-2">
                                <a href="{{ route('articles.show', $article) }}"
                                    class="btn btn-sm btn-outline-primary">
                                    <i class="bi bi-eye me-1"></i>Read
                                </a>

                                {{-- PDF --}}
                                @php
                                $manuscriptFile = $article->files
                                ->whereIn('file_type', ['manuscript', 'revised'])
                                ->sortByDesc('version')
                                ->first();
                                @endphp

                                @if($manuscriptFile)
                                <a href="{{ route('articles.download', $article) }}"
                                    class="btn btn-sm btn-danger">
                                    <i class="bi bi-file-earmark-pdf me-1"></i>PDF
                                </a>
                                @else
                                <button class="btn btn-sm btn-outline-secondary" disabled
                                    title="No PDF available">
                                    <i class="bi bi-file-earmark-pdf me-1"></i>PDF
                                </button>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
                @empty
                <div class="card border-0 shadow-sm">
                    <div class="card-body text-center text-muted py-5">
                        <i class="bi bi-journal-x fs-1 d-block mb-3"></i>
                        <h6>No articles in this issue yet.</h6>
                        <p class="small">Articles will appear here once published.</p>
                    </div>
                </div>
                @endforelse

                @else

                <div class="card border-0 shadow-sm">
                    <div class="card-body text-center text-muted py-5">
                        <i class="bi bi-journal-x fs-1 d-block mb-3"></i>
                        <h5>No current issue available.</h5>
                        <p class="small">Please check back later.</p>
                    </div>
                </div>

                @endif
            </div>
        </div>
    </div>
</section>

@endsection

@push('styles')
<style>
    .article-item {
        transition: box-shadow 0.2s;
    }

    .article-item:hover {
        box-shadow: 0 4px 16px rgba(0, 0, 0, 0.1) !important;
    }

    .section-title {
        font-size: 1rem;
        font-weight: 700;
        color: #1a3c5e;
        border-left: 3px solid #2d6a9f;
        padding-left: 10px;
    }
</style>
@endpush