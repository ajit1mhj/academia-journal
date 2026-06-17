@extends('layouts.public')
@section('title', 'Editorial Board')

@section('content')
<div class="py-4 bg-light border-bottom">
    <div class="container">
        <h1 class="h3 fw-bold text-primary mb-0">Editorial Board</h1>
    </div>
</div>

<section class="py-5">
    <div class="container">
        @php
            $groups = \App\Models\EditorialBoard::orderBy('order')
                      ->get()
                      ->groupBy('category');
            $labels = [
                'editor_in_chief'  => 'Editor in Chief',
                'managing_editor'  => 'Managing Editor',
                'editorial_board'  => 'Editorial Board Members',
                'review_board'     => 'Review Board',
                'advisory_board'   => 'Advisory Board',
            ];
        @endphp

        @foreach($labels as $key => $label)
            @if(isset($groups[$key]) && $groups[$key]->count())
            <h3 class="section-title mt-4">{{ $label }}</h3>
            <div class="row g-3 mb-4">
                @foreach($groups[$key] as $member)
                <div class="col-md-4 col-lg-3">
                    <div class="card border-0 shadow-sm text-center h-100">
                        <div class="card-body py-4">
                            @if($member->photo)
                                <img src="{{ Storage::url($member->photo) }}"
                                     class="rounded-circle mb-3"
                                     width="80" height="80"
                                     style="object-fit:cover">
                            @else
                                <div class="rounded-circle bg-primary bg-opacity-10 text-primary d-flex align-items-center justify-content-center mx-auto mb-3"
                                     style="width:80px;height:80px;font-size:1.5rem;font-weight:700">
                                    {{ strtoupper(substr($member->name, 0, 1)) }}
                                </div>
                            @endif
                            <h6 class="fw-bold mb-0">{{ $member->name }}</h6>
                            @if($member->designation)
                            <div class="text-muted small">{{ $member->designation }}</div>
                            @endif
                            @if($member->institution)
                            <div class="text-muted small">{{ $member->institution }}</div>
                            @endif
                            @if($member->country)
                            <div class="text-muted" style="font-size:0.75rem">{{ $member->country }}</div>
                            @endif
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
            @endif
        @endforeach
    </div>
</section>
@endsection