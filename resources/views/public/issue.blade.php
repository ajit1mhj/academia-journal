@extends('layouts.public')
@section('title', 'Volume '.$issue->volume->volume_no.', Issue '.$issue->issue_no)

@section('content')

{{-- Page Header --}}
<div class="py-3 bg-light border-bottom">
    <div class="container">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-0 small">
                <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                <li class="breadcrumb-item"><a href="{{ route('archives') }}">Archive</a></li>
                <li class="breadcrumb-item active">
                    Volume {{ $issue->volume->volume_no }},
                    Issue {{ $issue->issue_no }}
                    @if($issue->publication_date)
                    , {{ $issue->publication_date->format('Y') }}
                    @endif
                </li>
            </ol>
        </nav>
    </div>
</div>

<section class="py-4">
    <div class="container">
        <div class="row g-4">

            {{-- LEFT SIDEBAR --}}
            <div class="col-md-3">

                {{-- Journal Cover Image --}}
                @if($journal?->cover_image)
                <div class="text-center mb-2">
                    <img src="{{ asset('storage/' . $journal->cover_image) }}"
                        alt="Journal Cover"
                        class="img-fluid rounded shadow-sm"
                        style="max-width:140px">
                </div>
                @elseif($issue->cover_image)
                <div class="text-center mb-2">
                    <img src="{{ asset('storage/' . $issue->cover_image) }}"
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

                {{-- Journal PDF Button --}}
                @if($journal?->pdf_file)
                <div class="text-center mb-3">
                    <a href="{{ asset('storage/' . $journal->pdf_file) }}"
                        target="_blank"
                        class="btn btn-danger btn-sm w-100">
                        <i class="bi bi-file-earmark-pdf me-1"></i>
                        View Journal PDF
                    </a>
                </div>
                @endif

                {{-- Journal Info Card --}}
                @if($journal)
                <div class="card border-0 shadow-sm mb-3">
                    <div class="card-body py-2 px-3 small">
                        <div class="fw-semibold mb-2" style="color:#1a3c5e">
                            {{ $journal->title }}
                        </div>
                        @if($journal->issn)
                        <div class="mb-1 d-flex justify-content-between">
                            <span class="text-muted">ISSN:</span>
                            <strong>{{ $journal->issn }}</strong>
                        </div>
                        @endif
                        @if($journal->eissn)
                        <div class="mb-1 d-flex justify-content-between">
                            <span class="text-muted">e-ISSN:</span>
                            <strong>{{ $journal->eissn }}</strong>
                        </div>
                        @endif
                        @if($journal->publication_frequency)
                        <div class="mb-1 d-flex justify-content-between">
                            <span class="text-muted">Frequency:</span>
                            <strong>{{ $journal->publication_frequency }}</strong>
                        </div>
                        @endif
                        @if($journal->language)
                        <div class="d-flex justify-content-between">
                            <span class="text-muted">Language:</span>
                            <strong>{{ $journal->language }}</strong>
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
                        @foreach($volumes as $vol)
                        <div class="border-bottom">

                            {{-- Volume Header --}}
                            <button class="btn btn-link w-100 text-start text-dark fw-semibold small px-3 py-2 d-flex justify-content-between align-items-center"
                                data-bs-toggle="collapse"
                                data-bs-target="#vol-{{ $vol->id }}"
                                style="text-decoration:none">
                                <span>
                                    <i class="bi bi-collection me-1 text-primary"></i>
                                    Volume {{ $vol->volume_no }} ({{ $vol->year }})
                                </span>
                                <i class="bi bi-chevron-down small text-muted"></i>
                            </button>

                            {{-- Journal name under volume --}}
                            @if($vol->journal)
                            <div class="px-3 pb-1" style="font-size:0.68rem;color:#6c757d;margin-top:-6px">
                                {{ Str::limit($vol->journal->title, 35) }}
                            </div>
                            @endif

                            <div class="collapse {{ $issue->volume_id === $vol->id ? 'show' : '' }}"
                                id="vol-{{ $vol->id }}">
                                @foreach($vol->issues as $iss)
                                @php $active = $issue->id === $iss->id; @endphp
                                <a href="{{ route('issue.show', ['volumeNo' => $vol->volume_no, 'issueNo' => $iss->issue_no]) }}"
                                    class="d-flex justify-content-between align-items-center px-4 py-2
                          text-decoration-none small border-top
                          {{ $active ? 'fw-bold text-primary bg-primary bg-opacity-10' : 'text-muted bg-light' }}">
                                    <span>
                                        <i class="bi bi-file-text me-1"></i>
                                        Issue {{ $iss->issue_no }}
                                        @if($iss->publication_date)
                                        <span class="text-muted fw-normal">
                                            ({{ $iss->publication_date->format('Y') }})
                                        </span>
                                        @endif
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
                        @endforeach
                    </div>
                </div>
            </div>

            {{-- RIGHT MAIN CONTENT --}}
            <div class="col-md-9">

                {{-- Issue Header --}}
                <div class="mb-4 pb-3 border-bottom" style="border-color:#1a3c5e !important">
                    <h3 class="fw-bold mb-1" style="color:#1a3c5e">
                        Volume {{ $issue->volume->volume_no }},
                        Issue {{ $issue->issue_no }}
                        @if($issue->publication_date)
                        , {{ $issue->publication_date->format('Y') }}
                        @endif
                    </h3>
                    <div class="text-muted small d-flex flex-wrap gap-3">
                        @if($issue->publication_date)
                        <span>
                            <i class="bi bi-calendar me-1"></i>
                            Published: {{ $issue->publication_date->format('d F Y') }}
                        </span>
                        @endif
                        <span>
                            <i class="bi bi-file-earmark-text me-1"></i>
                            {{ $issue->articles->count() }} article(s)
                        </span>
                        @if($journal?->issn)
                        <span>
                            <i class="bi bi-upc me-1"></i>
                            ISSN: {{ $journal->issn }}
                        </span>
                        @endif
                    </div>
                </div>

                {{-- Articles List --}}
                @forelse($issue->articles as $article)
                <div style="padding:1.25rem 0; border-bottom:0.5px solid #dee2e6">
                    <div class="d-flex gap-2">

                        {{-- Number --}}
                        <span class="text-muted small pt-1" style="min-width:28px;font-weight:500">
                            {{ $loop->iteration }}.
                        </span>

                        <div class="flex-grow-1">

                            {{-- Article Type / Subject Area --}}
                            @if($article->subject_area)
                            <div class="text-uppercase fw-bold mb-1"
                                style="font-size:0.7rem;color:#2d6a9f;letter-spacing:0.6px">
                                Research Article &bull; {{ $article->subject_area }}
                            </div>
                            @endif

                            {{-- Title --}}
                            <h5 class="mb-1" style="line-height:1.35;font-size:1rem;font-weight:600">
                                <a href="{{ route('articles.show', $article) }}"
                                    class="text-decoration-none"
                                    style="color:#1a3c5e">
                                    {{ $article->title }}
                                </a>
                            </h5>

                            {{-- Authors --}}
                            <div class="text-muted small mb-1">
                                <i class="bi bi-people me-1"></i>
                                {{ $article->authors }}
                            </div>

                            {{-- Journal Ref + Pages --}}
                            <div class="d-flex align-items-center gap-2 flex-wrap mb-1">
                                <span class="text-muted small fst-italic">
                                    @if($journal) {{ $journal->title }}, @endif
                                    Vol. {{ $issue->volume->volume_no }},
                                    Issue {{ $issue->issue_no }}
                                    @if($issue->publication_date)
                                    ({{ $issue->publication_date->format('Y') }})
                                    @endif
                                </span>
                                @if($article->pages)
                                <span class="badge bg-light text-secondary border small">
                                    pp. {{ $article->pages }}
                                </span>
                                @endif
                            </div>

                            {{-- DOI --}}
                            @if($article->doi)
                            <div class="small mb-2">
                                <a href="https://doi.org/{{ $article->doi }}"
                                    target="_blank"
                                    class="text-decoration-none text-primary">
                                    https://doi.org/{{ $article->doi }}
                                </a>
                            </div>
                            @endif

                            {{-- PDF Button --}}
                            @php
                            $manuscriptFile = $article->files
                            ->whereIn('file_type', ['manuscript', 'revised'])
                            ->sortByDesc('version')
                            ->first();
                            @endphp

                            <div class="d-flex gap-2 mt-2">
                                <a href="{{ route('articles.show', $article) }}"
                                    class="btn btn-sm btn-outline-primary">
                                    <i class="bi bi-eye me-1"></i> Abstract
                                </a>
                                @if($manuscriptFile)
                                <a href="{{ route('articles.download', $article) }}"
                                    class="btn btn-sm btn-danger">
                                    <i class="bi bi-file-earmark-pdf me-1"></i> Download PDF
                                </a>
                                @else
                                <button class="btn btn-sm btn-outline-secondary" disabled>
                                    <i class="bi bi-file-earmark-pdf me-1"></i> PDF Not Available
                                </button>
                                @endif
                            </div>

                        </div>
                    </div>
                </div>
                @empty
                <div class="text-center text-muted py-5">
                    <i class="bi bi-journal-x fs-1 d-block mb-3"></i>
                    <h6>No articles in this issue yet.</h6>
                    <p class="small">Articles will appear here once published by the editor.</p>
                </div>
                @endforelse

            </div>
        </div>
    </div>
</section>

@endsection

@push('styles')
<style>
    .section-title {
        font-size: 1rem;
        font-weight: 700;
        color: #1a3c5e;
        border-left: 3px solid #2d6a9f;
        padding-left: 10px;
    }
</style>
@endpush