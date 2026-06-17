@extends('layouts.public')
@section('title', 'Home')

@section('content')

{{-- Hero Banner --}}
<section class="hero py-4">
    <div class="container">
        <div class="d-flex align-items-center justify-content-between flex-wrap gap-3">
            <div>
                <h1 class="fw-bold mb-1" style="font-size:1.8rem">
                    Academic Journal Management System
                </h1>
                <p class="mb-0 opacity-85">
                    A peer-reviewed, open-access journal publishing high-quality research.
                </p>
            </div>
            <a href="{{ route('register') }}" class="btn btn-light px-4">
                <i class="bi bi-upload me-2"></i> Submit Manuscript
            </a>
        </div>
    </div>
</section>

{{-- Main Two-Column Layout --}}
<section class="py-4">
    <div class="container">
        <div class="row g-4">

            {{-- LEFT SIDEBAR --}}
            <div class="col-md-3">

                @php
                $latestIssue = \App\Models\Issue::where('status','published')
                ->with('volume.journal')
                ->latest('publication_date')
                ->first();

                $journal = $latestIssue?->volume?->journal
                ?? \App\Models\Journal::first();
                @endphp

                {{-- Cover Image --}}
                @if($journal?->cover_image)
                <div class="text-center mb-2">
                    <img src="{{ asset('storage/' . $journal->cover_image) }}"
                        alt="Journal Cover"
                        class="img-fluid rounded shadow-sm"
                        style="max-width:140px">
                </div>
                @elseif($latestIssue?->cover_image)
                <div class="text-center mb-2">
                    <img src="{{ asset('storage/' . $latestIssue->cover_image) }}"
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

                {{-- Journal Archive Tree --}}
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
                                @foreach($volume->issues as $issue)
                                <a href="{{ route('issue.show', ['volumeNo' => $volume->volume_no, 'issueNo' => $issue->issue_no]) }}"
                                    class="d-flex justify-content-between align-items-center px-4 py-1
                                          text-decoration-none small border-top
                                          {{ $issue->status === 'published' ? 'text-primary' : 'text-muted' }}"
                                    style="background:#f8f9fa">
                                    <span>
                                        <i class="bi bi-file-text me-1"></i>
                                        Issue {{ $issue->issue_no }}
                                    </span>
                                    @if($issue->status === 'published')
                                    <span class="badge bg-success" style="font-size:0.6rem">Published</span>
                                    @elseif($issue->status === 'upcoming')
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

                {{-- ISSN Info --}}
                @if($journal)
                <div class="card border-0 shadow-sm mt-3">
                    <div class="card-body py-3 px-3 small">
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

            </div>

            {{-- RIGHT MAIN CONTENT --}}
            <div class="col-md-9">

                {{-- Welcome Banner --}}
                <div class="alert mb-4 py-3 px-4 border-0"
                    style="background:#eef4fb;border-left:4px solid #1a3c5e !important;border-radius:8px">
                    <p class="mb-0 small">
                        Welcome to <strong>Academic Journal Management System (AJMS)</strong> —
                        a peer-reviewed, open-access scholarly journal committed to publishing
                        high-quality original research across multiple academic disciplines.
                    </p>
                </div>

                {{-- Current Issue --}}
                @php
                $currentIssue = \App\Models\Issue::where('status','published')
                ->with(['articles.files', 'volume.journal'])
                ->latest('publication_date')
                ->first();
                @endphp

                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h5 class="section-title mb-0">CURRENT ISSUE</h5>
                    @if($currentIssue)
                    <a href="{{ route('issue.show', ['volumeNo' => $currentIssue->volume->volume_no, 'issueNo' => $currentIssue->issue_no]) }}"
                        class="btn btn-sm btn-outline-primary">View All</a>
                    @endif
                </div>

                @if($currentIssue)
                <div class="card border-0 shadow-sm mb-4">
                    <div class="card-header py-2 px-3"
                        style="background:#f0f4f8;border-bottom:2px solid #1a3c5e">
                        <div class="fw-bold" style="color:#1a3c5e">
                            <a href="{{ route('issue.show', ['volumeNo' => $currentIssue->volume->volume_no, 'issueNo' => $currentIssue->issue_no]) }}"
                                class="text-decoration-none" style="color:#1a3c5e">
                                Volume {{ $currentIssue->volume->volume_no }},
                                Issue {{ $currentIssue->issue_no }},
                                {{ $currentIssue->publication_date?->format('Y') }}
                            </a>
                        </div>
                        @if($currentIssue->publication_date)
                        <div class="text-muted small">
                            Published: {{ $currentIssue->publication_date->format('d M Y') }}
                        </div>
                        @endif
                    </div>
                    <div class="card-body p-0">
                        @forelse($currentIssue->articles as $article)
                        <div class="p-3 border-bottom article-item">
                            <div class="text-muted small mb-1">
                                {{ $article->subject_area }}
                                @if($article->pages) &bull; pp. {{ $article->pages }} @endif
                            </div>
                            <h6 class="mb-1">
                                <a href="{{ route('articles.show', $article) }}"
                                    class="text-decoration-none fw-bold"
                                    style="color:#1a3c5e">
                                    {{ $article->title }}
                                </a>
                            </h6>
                            <div class="text-muted small mb-2">
                                {{ $article->authors }}
                            </div>
                            <p class="text-muted small mb-2">
                                {{ Str::limit($article->abstract, 200) }}
                            </p>
                            <div class="d-flex gap-2 align-items-center">
                                @if($article->doi)
                                <span class="text-muted small">
                                    <i class="bi bi-link-45deg me-1"></i>{{ $article->doi }}
                                </span>
                                @endif

                                @php
                                $manuscriptFile = $article->files
                                ->whereIn('file_type', ['manuscript', 'revised'])
                                ->sortByDesc('version')
                                ->first();
                                @endphp

                                <div class="ms-auto d-flex gap-2">
                                    <a href="{{ route('articles.show', $article) }}"
                                        class="btn btn-sm btn-outline-primary">
                                        Read Article
                                    </a>
                                    @if($manuscriptFile)
                                    <a href="{{ route('articles.download', $article) }}"
                                        class="btn btn-sm btn-danger">
                                        <i class="bi bi-file-earmark-pdf me-1"></i>PDF
                                    </a>
                                    @else
                                    <button class="btn btn-sm btn-outline-secondary" disabled>
                                        <i class="bi bi-file-earmark-pdf me-1"></i>PDF
                                    </button>
                                    @endif
                                </div>
                            </div>
                        </div>
                        @empty
                        <div class="p-4 text-center text-muted small">
                            <i class="bi bi-journal-x fs-2 d-block mb-2"></i>
                            No articles published in this issue yet.
                        </div>
                        @endforelse
                    </div>
                </div>
                @else
                <div class="card border-0 shadow-sm mb-4">
                    <div class="card-body text-center text-muted py-5">
                        <i class="bi bi-journal-x fs-1 d-block mb-2"></i>
                        No current issue available.
                    </div>
                </div>
                @endif

                {{-- Stats Row --}}
                <div class="row g-3 mb-4">
                    @foreach([
                    ['value' => \App\Models\Article::where('status','published')->count(), 'label' => 'Published Articles', 'icon' => 'bi-file-earmark-check'],
                    ['value' => \App\Models\Volume::count(), 'label' => 'Volumes', 'icon' => 'bi-collection'],
                    ['value' => \App\Models\Issue::where('status','published')->count(), 'label' => 'Issues', 'icon' => 'bi-layers'],
                    ['value' => \App\Models\User::whereHas('role', fn($q) => $q->where('name','author'))->count(), 'label' => 'Authors', 'icon' => 'bi-people'],
                    ] as $stat)
                    <div class="col-6 col-md-3">
                        <div class="card border-0 shadow-sm text-center py-3">
                            <i class="bi {{ $stat['icon'] }} text-primary fs-4 mb-1"></i>
                            <div class="fw-bold fs-5" style="color:#1a3c5e">{{ $stat['value'] }}</div>
                            <div class="text-muted small">{{ $stat['label'] }}</div>
                        </div>
                    </div>
                    @endforeach
                </div>

                {{-- Recent Articles --}}
                @php
                $latestArticles = \App\Models\Article::where('status','published')
                ->latest('published_at')
                ->take(4)
                ->get();
                @endphp

                @if($latestArticles->count())
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h5 class="section-title mb-0">RECENT ARTICLES</h5>
                    <a href="{{ route('archives') }}" class="btn btn-sm btn-outline-primary">Browse All</a>
                </div>

                <div class="row g-3">
                    @foreach($latestArticles as $article)
                    <div class="col-md-6">
                        <div class="card article-card h-100 border-0 shadow-sm">
                            <div class="card-body">
                                <div class="text-muted small mb-1">{{ $article->subject_area }}</div>
                                <h6 class="fw-bold mb-2" style="font-size:0.9rem">
                                    <a href="{{ route('articles.show', $article) }}"
                                        class="text-decoration-none text-dark">
                                        {{ Str::limit($article->title, 80) }}
                                    </a>
                                </h6>
                                <div class="text-muted small mb-2">
                                    <i class="bi bi-people me-1"></i>
                                    {{ $article->authors }}
                                </div>
                                <p class="text-muted small mb-0">
                                    {{ Str::limit($article->abstract, 100) }}
                                </p>
                            </div>
                            <div class="card-footer bg-transparent d-flex justify-content-between align-items-center">
                                <span class="text-muted small">
                                    <i class="bi bi-calendar me-1"></i>
                                    {{ $article->published_at?->format('d M Y') }}
                                </span>
                                <a href="{{ route('articles.show', $article) }}"
                                    class="btn btn-sm btn-outline-primary">Read</a>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
                @endif

            </div>

        </div>
    </div>
</section>

{{-- Call to Action --}}
<section class="py-4 mt-2" style="background:#1a3c5e">
    <div class="container text-center text-white">
        <h5 class="fw-bold mb-2">Ready to Submit Your Research?</h5>
        <p class="opacity-75 mb-3 small">
            Join researchers publishing with AJMS.
        </p>
        <a href="{{ route('register') }}" class="btn btn-light px-4">
            <i class="bi bi-upload me-2"></i> Submit Manuscript
        </a>
    </div>
</section>

@endsection

@push('styles')
<style>
    .article-item:hover {
        background: #f8fafc;
    }

    .article-item:last-child {
        border-bottom: none !important;
    }

    .section-title {
        font-size: 1rem;
        font-weight: 700;
        color: #1a3c5e;
        border-left: 3px solid #2d6a9f;
        padding-left: 10px;
        letter-spacing: 0.5px;
    }
</style>
@endpush