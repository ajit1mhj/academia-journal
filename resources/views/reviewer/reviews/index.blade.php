@extends('layouts.app')
@section('title', 'My Reviews')
@section('page-title', 'My Assigned Reviews')

@section('content')
<div class="card">
    <div class="card-header">
        <div class="d-flex gap-2">
            @foreach(['all','pending','submitted','declined'] as $s)
            <a href="{{ request()->fullUrlWithQuery(['status' => $s]) }}"
               class="btn btn-sm {{ request('status', 'all') === $s ? 'btn-primary' : 'btn-outline-secondary' }}">
                {{ ucfirst($s) }}
            </a>
            @endforeach
        </div>
    </div>
    <div class="card-body p-0">
        <table class="table table-hover align-middle mb-0">
            <thead class="table-light">
                <tr>
                    <th>Manuscript</th>
                    <th>Assigned</th>
                    <th>Deadline</th>
                    <th>Status</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @forelse($reviews as $review)
                <tr>
                    <td>
                        <div class="fw-semibold small">
                            {{ Str::limit($review->article->title, 60) }}
                        </div>
                        <div class="text-muted" style="font-size:0.75rem">
                            {{ $review->article->subject_area }}
                        </div>
                    </td>
                    <td class="small text-muted">
                        {{ $review->created_at->format('d M Y') }}
                    </td>
                    <td class="small">
                        @if($review->deadline)
                            @php $overdue = $review->deadline < now() && $review->status === 'pending'; @endphp
                            <span class="{{ $overdue ? 'text-danger fw-bold' : 'text-muted' }}">
                                {{ $review->deadline->format('d M Y') }}
                                @if($overdue)
                                    <span class="badge bg-danger ms-1">Overdue</span>
                                @endif
                            </span>
                        @else
                            <span class="text-muted">—</span>
                        @endif
                    </td>
                    <td>
                        <span class="badge {{ match($review->status) {
                            'submitted' => 'bg-success',
                            'declined'  => 'bg-danger',
                            default     => 'bg-warning text-dark'
                        } }}">
                            {{ ucfirst($review->status) }}
                        </span>
                        @if($review->status === 'submitted' && $review->recommendation)
                        <div class="text-muted mt-1" style="font-size:0.7rem">
                            {{ ucfirst(str_replace('_', ' ', $review->recommendation)) }}
                        </div>
                        @endif
                    </td>
                    <td>
                        <a href="{{ route('reviewer.reviews.show', $review) }}"
                           class="btn btn-sm {{ $review->status === 'pending' ? 'btn-primary' : 'btn-outline-secondary' }}">
                            {{ $review->status === 'pending' ? 'Start Review' : 'View' }}
                        </a>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="text-center text-muted py-5">
                        <i class="bi bi-clipboard-x fs-2 d-block mb-2"></i>
                        No reviews assigned yet.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    @if($reviews->hasPages())
    <div class="card-footer">{{ $reviews->links() }}</div>
    @endif
</div>
@endsection