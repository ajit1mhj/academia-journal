@extends('layouts.app')
@section('title', 'Reviewer Dashboard')
@section('page-title', 'My Review Dashboard')

@section('content')
<div class="row g-3 mb-4">
    @foreach($stats as $stat)
    <div class="col-6 col-md-4">
        <div class="stat-card">
            <div class="stat-value">{{ $stat['value'] }}</div>
            <div class="stat-label">{{ $stat['label'] }}</div>
        </div>
    </div>
    @endforeach
</div>

<div class="card">
    <div class="card-header">Assigned Reviews</div>
    <div class="card-body p-0">
        <table class="table table-hover align-middle mb-0">
            <thead class="table-light">
                <tr>
                    <th>Manuscript</th>
                    <th>Deadline</th>
                    <th>Status</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                @foreach(\App\Models\Review::where('reviewer_id', auth()->id())->with('article')->latest()->take(8)->get() as $review)
                <tr>
                    <td class="small fw-semibold">{{ Str::limit($review->article->title, 60) }}</td>
                    <td class="small {{ $review->deadline < now() && $review->status === 'pending' ? 'text-danger fw-bold' : 'text-muted' }}">
                        {{ $review->deadline?->format('d M Y') }}
                    </td>
                    <td>
                        <span class="badge {{ $review->status === 'submitted' ? 'bg-success' : 'bg-warning text-dark' }}">
                            {{ ucfirst($review->status) }}
                        </span>
                    </td>
                    <td>
                        <a href="{{ route('reviewer.reviews.show', $review) }}"
                           class="btn btn-sm btn-outline-primary">
                            {{ $review->status === 'pending' ? 'Review' : 'View' }}
                        </a>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection