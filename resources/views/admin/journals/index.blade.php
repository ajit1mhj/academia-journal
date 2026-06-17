@extends('layouts.app')
@section('title', 'Journals')
@section('page-title', 'Journal Management')

@section('content')
<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <span>All Journals</span>
        <a href="{{ route('admin.journals.create') }}" class="btn btn-sm btn-primary">
            <i class="bi bi-plus-lg me-1"></i> Add Journal
        </a>
    </div>
    <div class="card-body p-0">
        <table class="table table-hover align-middle mb-0">
            <thead class="table-light">
                <tr>
                    <th>Journal</th>
                    <th>ISSN / e-ISSN</th>
                    <th>Frequency</th>
                    <th>Files</th>
                    <th>Status</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($journals as $journal)
                <tr>
                    <td>
                        <div class="d-flex align-items-center gap-2">
                            @if($journal->cover_image)
                            <img src="{{ Storage::url($journal->cover_image) }}"
                                class="rounded shadow-sm flex-shrink-0"
                                style="width:30px;height:42px;object-fit:cover">
                            @else
                            <div class="rounded d-flex align-items-center justify-content-center flex-shrink-0"
                                style="width:30px;height:42px;background:#1a3c5e">
                                <i class="bi bi-journal-richtext text-white"
                                    style="font-size:0.7rem"></i>
                            </div>
                            @endif
                            <div>
                                <div class="fw-semibold small">{{ $journal->title }}</div>
                                <div class="text-muted" style="font-size:0.72rem">
                                    {{ $journal->publication_frequency }}
                                    @if($journal->language)
                                    · {{ $journal->language }}
                                    @endif
                                </div>
                            </div>
                        </div>
                    </td>
                    <td class="small">
                        @if($journal->issn)
                        <div>{{ $journal->issn }}</div>
                        @endif
                        @if($journal->eissn)
                        <div class="text-muted">e: {{ $journal->eissn }}</div>
                        @endif
                        @if(!$journal->issn && !$journal->eissn) — @endif
                    </td>
                    <td class="small text-muted">
                        {{ $journal->publication_frequency ?? '—' }}
                    </td>
                    <td>
                        <div class="d-flex gap-1">
                            @if($journal->cover_image)
                            <span class="badge bg-light text-dark border" title="Has cover image">
                                <i class="bi bi-image text-primary"></i>
                            </span>
                            @endif
                            @if($journal->pdf_file)
                            <a href="{{ Storage::url($journal->pdf_file) }}"
                                target="_blank"
                                class="badge bg-danger text-white text-decoration-none"
                                title="View PDF">
                                <i class="bi bi-file-earmark-pdf"></i> PDF
                            </a>
                            @else
                            <span class="badge bg-light text-muted border">No PDF</span>
                            @endif
                        </div>
                    </td>
                    <td>
                        <span class="badge {{ $journal->status === 'active' ? 'bg-success' : 'bg-secondary' }}">
                            {{ ucfirst($journal->status) }}
                        </span>
                    </td>
                    <td>
                        <div class="d-flex gap-1">
                            <a href="{{ route('admin.journals.edit', $journal) }}"
                                class="btn btn-sm btn-outline-primary">
                                <i class="bi bi-pencil"></i>
                            </a>
                            <form method="POST"
                                action="{{ route('admin.journals.destroy', $journal) }}"
                                onsubmit="return confirm('Delete this journal?')">
                                @csrf @method('DELETE')
                                <button class="btn btn-sm btn-outline-danger">
                                    <i class="bi bi-trash"></i>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="text-center text-muted py-4">No journals found.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    @if($journals->hasPages())
    <div class="card-footer">{{ $journals->links() }}</div>
    @endif
</div>
@endsection