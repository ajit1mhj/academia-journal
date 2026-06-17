@extends('layouts.app')
@section('title', 'Manuscripts')
@section('page-title', 'Manuscript Management')

@section('content')
<div class="card">
    <div class="card-header">
        <div class="d-flex gap-2 flex-wrap">
            @foreach([
                'all'                => 'All',
                'submitted'          => 'Submitted',
                'under_review'       => 'Under Review',
                'revision_requested' => 'Revision',
                'accepted'           => 'Accepted',
                'rejected'           => 'Rejected',
                'published'          => 'Published',
            ] as $status => $label)
            <a href="{{ request()->fullUrlWithQuery(['status' => $status]) }}"
               class="btn btn-sm {{ request('status', 'all') === $status ? 'btn-primary' : 'btn-outline-secondary' }}">
                {{ $label }}
                <span class="badge {{ request('status', 'all') === $status ? 'bg-light text-dark' : 'bg-secondary' }} ms-1">
                    {{ $counts[$status] }}
                </span>
            </a>
            @endforeach
        </div>
    </div>
    <div class="card-body p-0">
        <table class="table table-hover align-middle mb-0">
            <thead class="table-light">
                <tr>
                    <th>#</th>
                    <th>Title</th>
                    <th>Authors</th>
                    <th>Reviews</th>
                    <th>Status</th>
                    <th>Submitted</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($articles as $article)
                <tr>
                    <td class="text-muted small">{{ $article->id }}</td>
                    <td>
                        <div class="fw-semibold small">
                            {{ Str::limit($article->title, 55) }}
                        </div>
                        @if($article->subject_area)
                        <div class="text-muted" style="font-size:0.72rem">
                            {{ $article->subject_area }}
                        </div>
                        @endif
                    </td>
                    <td class="small text-muted">
                        {{ Str::limit($article->authors, 40) }}
                    </td>
                    <td class="small">
                        @if($article->reviews->count())
                            {{ $article->reviews->where('status','submitted')->count() }}
                            / {{ $article->reviews->count() }}
                        @else
                            <span class="text-muted">—</span>
                        @endif
                    </td>
                    <td>
                        <span class="badge badge-{{ $article->status }}">
                            {{ ucfirst(str_replace('_', ' ', $article->status)) }}
                        </span>
                    </td>
                    <td class="small text-muted">
                        {{ $article->created_at->format('d M Y') }}
                    </td>
                    <td>
                        <a href="{{ route('editor.articles.show', $article) }}"
                           class="btn btn-sm btn-outline-primary">
                            <i class="bi bi-eye"></i>
                        </a>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" class="text-center text-muted py-5">
                        <i class="bi bi-inbox fs-2 d-block mb-2"></i>
                        No manuscripts found.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    @if($articles->hasPages())
    <div class="card-footer">{{ $articles->links() }}</div>
    @endif
</div>
@endsection