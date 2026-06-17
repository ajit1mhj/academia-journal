@extends('layouts.app')
@section('title', 'Notifications')
@section('page-title', 'Notifications')

@section('content')
<div class="card" style="max-width:800px">
    <div class="card-header d-flex justify-content-between align-items-center">
        <span>All Notifications</span>
        <form method="POST" action="{{ route('notifications.read-all') }}">
            @csrf @method('PUT')
            <button class="btn btn-sm btn-outline-secondary">
                <i class="bi bi-check-all me-1"></i> Mark All Read
            </button>
        </form>
    </div>
    <div class="card-body p-0">
        @forelse($notifications as $notif)
        <div class="p-3 border-bottom d-flex gap-3 {{ $notif->is_read ? '' : 'bg-primary bg-opacity-5' }}">
            <div class="mt-1">
                <i class="bi bi-{{ $notif->type === 'submission' ? 'upload' : ($notif->type === 'review' ? 'clipboard-check' : 'bell') }} text-primary"></i>
            </div>
            <div class="flex-grow-1">
                <div class="fw-semibold small">{{ $notif->title }}</div>
                <div class="text-muted small">{{ $notif->message }}</div>
                <div class="text-muted" style="font-size:0.7rem">{{ $notif->created_at->diffForHumans() }}</div>
            </div>
            <div class="d-flex gap-1 align-items-start">
                @if(!$notif->is_read)
                <form method="POST" action="{{ route('notifications.read', $notif) }}">
                    @csrf @method('PUT')
                    <button class="btn btn-sm btn-outline-primary" title="Mark read">
                        <i class="bi bi-check"></i>
                    </button>
                </form>
                @endif
                <form method="POST" action="{{ route('notifications.destroy', $notif) }}"
                      onsubmit="return confirm('Delete?')">
                    @csrf @method('DELETE')
                    <button class="btn btn-sm btn-outline-danger" title="Delete">
                        <i class="bi bi-trash"></i>
                    </button>
                </form>
            </div>
        </div>
        @empty
        <div class="text-center text-muted py-5">
            <i class="bi bi-bell-slash fs-2 d-block mb-2"></i>
            No notifications.
        </div>
        @endforelse
    </div>
    @if($notifications->hasPages())
    <div class="card-footer">{{ $notifications->links() }}</div>
    @endif
</div>
@endsection