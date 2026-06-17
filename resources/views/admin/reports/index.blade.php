@extends('layouts.app')
@section('title', 'Reports')
@section('page-title', 'Reports & Analytics')

@section('content')

{{-- Summary Stats --}}
<div class="row g-3 mb-4">
    <div class="col-6 col-md-3">
        <div class="stat-card">
            <div class="stat-value">{{ $stats['total_submissions'] }}</div>
            <div class="stat-label">Total Submissions</div>
        </div>
    </div>
    <div class="col-6 col-md-3">
        <div class="stat-card">
            <div class="stat-value text-success">{{ $stats['published'] }}</div>
            <div class="stat-label">Published</div>
        </div>
    </div>
    <div class="col-6 col-md-3">
        <div class="stat-card">
            <div class="stat-value text-warning">{{ $stats['under_review'] }}</div>
            <div class="stat-label">Under Review</div>
        </div>
    </div>
    <div class="col-6 col-md-3">
        <div class="stat-card">
            <div class="stat-value text-danger">{{ $stats['rejected'] }}</div>
            <div class="stat-label">Rejected</div>
        </div>
    </div>
    <div class="col-6 col-md-3">
        <div class="stat-card">
            <div class="stat-value">{{ $stats['total_users'] }}</div>
            <div class="stat-label">Total Users</div>
        </div>
    </div>
    <div class="col-6 col-md-3">
        <div class="stat-card">
            <div class="stat-value">{{ $stats['total_authors'] }}</div>
            <div class="stat-label">Authors</div>
        </div>
    </div>
    <div class="col-6 col-md-3">
        <div class="stat-card">
            <div class="stat-value">{{ $stats['total_reviewers'] }}</div>
            <div class="stat-label">Reviewers</div>
        </div>
    </div>
    <div class="col-6 col-md-3">
        <div class="stat-card">
            <div class="stat-value text-danger">{{ $stats['overdue_reviews'] }}</div>
            <div class="stat-label">Overdue Reviews</div>
        </div>
    </div>
</div>

{{-- Quick Links --}}
<div class="row g-3 mb-4">
    @foreach([
        ['route' => 'admin.reports.submissions',  'icon' => 'bi-file-earmark-text', 'label' => 'Submission Report',  'color' => 'primary'],
        ['route' => 'admin.reports.publications', 'icon' => 'bi-journal-check',     'label' => 'Publication Report', 'color' => 'success'],
        ['route' => 'admin.reports.users',        'icon' => 'bi-people',            'label' => 'User Report',        'color' => 'info'],
    ] as $link)
    <div class="col-md-4">
        <a href="{{ route($link['route']) }}"
           class="card text-decoration-none text-dark h-100 border-0 shadow-sm">
            <div class="card-body d-flex align-items-center gap-3">
                <div class="rounded-circle bg-{{ $link['color'] }} bg-opacity-10 d-flex align-items-center justify-content-center"
                     style="width:48px;height:48px;flex-shrink:0">
                    <i class="bi {{ $link['icon'] }} text-{{ $link['color'] }} fs-5"></i>
                </div>
                <div>
                    <div class="fw-semibold">{{ $link['label'] }}</div>
                    <div class="text-muted small">View detailed report</div>
                </div>
                <i class="bi bi-arrow-right ms-auto text-muted"></i>
            </div>
        </a>
    </div>
    @endforeach
</div>

<div class="row g-3 mb-4">
    {{-- Submission Status Breakdown --}}
    <div class="col-md-6">
        <div class="card h-100">
            <div class="card-header d-flex justify-content-between align-items-center">
                <span>Submission Status</span>
                <a href="{{ route('admin.reports.export', ['type' => 'submissions']) }}"
                   class="btn btn-sm btn-outline-secondary">
                    <i class="bi bi-download me-1"></i> CSV
                </a>
            </div>
            <div class="card-body">
                @foreach([
                    ['label' => 'Submitted',           'key' => 'submitted',          'class' => 'bg-primary'],
                    ['label' => 'Under Review',         'key' => 'under_review',       'class' => 'bg-warning'],
                    ['label' => 'Revision Requested',   'key' => 'revision_requested', 'class' => 'bg-purple'],
                    ['label' => 'Accepted',             'key' => 'accepted',           'class' => 'bg-success'],
                    ['label' => 'Rejected',             'key' => 'rejected',           'class' => 'bg-danger'],
                    ['label' => 'Published',            'key' => 'published',          'class' => 'bg-dark'],
                ] as $row)
                @php
                    $count = $stats[$row['key']];
                    $pct   = $stats['total_submissions'] > 0
                             ? round(($count / $stats['total_submissions']) * 100)
                             : 0;
                @endphp
                <div class="mb-3">
                    <div class="d-flex justify-content-between small mb-1">
                        <span>{{ $row['label'] }}</span>
                        <span class="fw-semibold">{{ $count }} ({{ $pct }}%)</span>
                    </div>
                    <div class="progress" style="height:6px">
                        <div class="progress-bar {{ $row['class'] }}"></div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>

    {{-- Top Articles by Views --}}
    <div class="col-md-6">
        <div class="card h-100">
            <div class="card-header d-flex justify-content-between align-items-center">
                <span>Top Articles by Views</span>
                <a href="{{ route('admin.reports.export', ['type' => 'publications']) }}"
                   class="btn btn-sm btn-outline-secondary">
                    <i class="bi bi-download me-1"></i> CSV
                </a>
            </div>
            <div class="card-body p-0">
                <table class="table table-sm table-hover mb-0">
                    <thead class="table-light">
                        <tr>
                            <th>Title</th>
                            <th class="text-end">Views</th>
                            <th class="text-end">Downloads</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($topArticles as $article)
                        <tr>
                            <td class="small">{{ Str::limit($article->title, 45) }}</td>
                            <td class="small text-end">{{ number_format($article->views) }}</td>
                            <td class="small text-end">{{ number_format($article->downloads) }}</td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="3" class="text-center text-muted py-3">No data.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<div class="row g-3">
    {{-- Submissions by Subject Area --}}
    <div class="col-md-6">
        <div class="card">
            <div class="card-header">Submissions by Subject Area</div>
            <div class="card-body p-0">
                <table class="table table-sm table-hover mb-0">
                    <thead class="table-light">
                        <tr>
                            <th>Subject Area</th>
                            <th class="text-end">Count</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($bySubjectArea as $row)
                        <tr>
                            <td class="small">{{ $row->subject_area }}</td>
                            <td class="small text-end fw-semibold">{{ $row->total }}</td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="2" class="text-center text-muted py-3">No data.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    {{-- Export Options --}}
    <div class="col-md-6">
        <div class="card">
            <div class="card-header">Export Reports</div>
            <div class="card-body">
                <p class="text-muted small mb-3">
                    Download reports as CSV files for external analysis.
                </p>
                <div class="d-flex flex-column gap-2">
                    @foreach([
                        ['type' => 'submissions',  'label' => 'All Submissions',      'icon' => 'bi-file-earmark-text'],
                        ['type' => 'publications', 'label' => 'Published Articles',   'icon' => 'bi-journal-check'],
                        ['type' => 'users',        'label' => 'User List',            'icon' => 'bi-people'],
                        ['type' => 'reviews',      'label' => 'Review Summary',       'icon' => 'bi-clipboard-check'],
                    ] as $export)
                    <a href="{{ route('admin.reports.export', ['type' => $export['type']]) }}"
                       class="btn btn-outline-secondary d-flex align-items-center gap-2">
                        <i class="bi {{ $export['icon'] }}"></i>
                        {{ $export['label'] }}
                        <span class="ms-auto badge bg-light text-dark border">CSV</span>
                    </a>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>

@endsection