@extends('layouts.public')
@section('title', 'About')

@section('content')
<section class="py-5">
    <div class="container">
        <div class="row g-4">
            <div class="col-md-8">
                <h2 class="section-title">About Academia Journal</h2>
                <p>
                    The Academia Journal is a peer-reviewed, open-access publication dedicated to
                    advancing scholarly inquiry across disciplines. We publish original research that
                    meets the highest standards of academic rigor — work that contributes meaningfully
                    to its field and stands up to scrutiny.
                </p>

                <p>
                    Every submission undergoes a strict double-blind peer review process, where
                    manuscripts are evaluated solely on their intellectual merit. Our editorial board
                    upholds principles of transparency, reproducibility, and research ethics at every
                    stage — from submission to publication.
                </p>

                <p>
                    We welcome contributions from researchers, academics, and practitioners across
                    Nepal and beyond. Whether you are presenting new findings, a systematic review,
                    or a practice-based case study, the Academia Journal provides a credible platform
                    to reach a broader academic audience.
                </p>

                <h4 class="mt-4 mb-3 fw-bold" style="color:#1a3c5e">Publication Frequency</h4>
                <p>
                    The journal publishes two issues annually — typically in June and December —
                    with occasional special issues on emerging or interdisciplinary themes. Special
                    issues are announced in advance and open for separate submissions.
                </p>

                <h4 class="mt-4 mb-3 fw-bold" style="color:#1a3c5e">Subject Areas</h4>
                <p class="text-muted small mb-3">
                    We accept manuscripts from, but not limited to, the following disciplines:
                </p>
                <div class="row g-2">
                    @foreach(['Medical Sciences','Engineering & Technology','Social Sciences','Natural Sciences','Humanities','Business & Management','Computer Science','Environmental Studies'] as $area)
                    <div class="col-md-6">
                        <div class="d-flex align-items-center gap-2 p-2 bg-light rounded">
                            <i class="bi bi-check-circle-fill text-primary"></i>
                            <span class="small">{{ $area }}</span>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>

            <div class="col-md-4">
                <div class="card border-0 shadow-sm">
                    <div class="card-body">
                        <h5 class="fw-bold mb-3" style="color:#1a3c5e">Journal Information</h5>
                        <table class="table table-sm table-borderless">
                            <tr>
                                <td class="text-muted small">ISSN (Print)</td>
                                <td class="small fw-semibold">3012-0313</td>
                            </tr>
                            <tr>
                                <td class="text-muted small">ISSN (Online)</td>
                                <td class="small fw-semibold">3012-0321</td>
                            </tr>
                            <tr>
                                <td class="text-muted small">Frequency</td>
                                <td class="small fw-semibold">Semiannual (Jun & Dec)</td>
                            </tr>
                            <tr>
                                <td class="text-muted small">Access</td>
                                <td class="small fw-semibold">Open Access — Free to Read</td>
                            </tr>
                            <tr>
                                <td class="text-muted small">Review Type</td>
                                <td class="small fw-semibold">Double-Blind Peer Review</td>
                            </tr>
                            <tr>
                                <td class="text-muted small">Language</td>
                                <td class="small fw-semibold">English</td>
                            </tr>
                            <tr>
                                <td class="text-muted small">Publisher</td>
                                <td class="small fw-semibold">Academia International College, Lalitpur</td>
                            </tr>
                        </table>
                        <a href="{{ route('author.submissions.create') }}"
                            class="btn btn-primary w-100 mt-2">
                            <i class="bi bi-upload me-2"></i> Submit Your Manuscript
                        </a>
                    </div>
                </div>

                <div class="mt-3 p-3 bg-light rounded small text-muted">
                    <strong class="d-block mb-1 text-dark">Before you submit</strong>
                    Please review our Author Guidelines to ensure your manuscript follows the
                    journal's formatting, citation, and ethical standards. Submissions that do
                    not meet these requirements will be returned without review.
                </div>
            </div>
        </div>
    </div>
</section>
@endsection