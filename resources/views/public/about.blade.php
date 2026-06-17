@extends('layouts.public')
@section('title', 'About')

@section('content')
<div class="py-4 bg-light border-bottom">
    <div class="container">
        <h1 class="h3 fw-bold text-primary mb-0">About the Journal</h1>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-0 small">
                <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                <li class="breadcrumb-item active">About</li>
            </ol>
        </nav>
    </div>
</div>

<section class="py-5">
    <div class="container">
        <div class="row g-4">
            <div class="col-md-8">
                <h2 class="section-title">About AJMS</h2>
                <p>The Academic Journal Management System (AJMS) is a peer-reviewed,
                open-access scholarly journal committed to publishing high-quality original
                research across multiple academic disciplines.</p>

                <p>Our journal provides a platform for researchers, academics, and practitioners
                to share their findings with a global audience. We follow strict ethical guidelines
                and employ a rigorous double-blind peer review process to ensure the integrity
                and quality of published work.</p>

                <h4 class="mt-4 mb-3 fw-bold" style="color:#1a3c5e">Publication Frequency</h4>
                <p>AJMS publishes four issues per year (quarterly), with special issues
                published as needed.</p>

                <h4 class="mt-4 mb-3 fw-bold" style="color:#1a3c5e">Subject Areas</h4>
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
                                <td class="small fw-semibold">XXXX-XXXX</td>
                            </tr>
                            <tr>
                                <td class="text-muted small">ISSN (Online)</td>
                                <td class="small fw-semibold">XXXX-XXXX</td>
                            </tr>
                            <tr>
                                <td class="text-muted small">Frequency</td>
                                <td class="small fw-semibold">Quarterly</td>
                            </tr>
                            <tr>
                                <td class="text-muted small">Access</td>
                                <td class="small fw-semibold">Open Access</td>
                            </tr>
                            <tr>
                                <td class="text-muted small">Review Type</td>
                                <td class="small fw-semibold">Double Blind</td>
                            </tr>
                            <tr>
                                <td class="text-muted small">Language</td>
                                <td class="small fw-semibold">English</td>
                            </tr>
                        </table>
                        <a href="{{ route('author.submissions.create') }}"
                           class="btn btn-primary w-100 mt-2">
                            <i class="bi bi-upload me-2"></i> Submit Manuscript
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection