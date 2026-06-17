@extends('layouts.app')
@section('title', 'Editorial Board')
@section('page-title', 'Editorial Board Management')

@section('content')
<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <span>All Members</span>
        <a href="{{ route('admin.editorial-board.create') }}" class="btn btn-sm btn-primary">
            <i class="bi bi-plus-lg me-1"></i> Add Member
        </a>
    </div>
    <div class="card-body p-0">
        <table class="table table-hover align-middle mb-0">
            <thead class="table-light">
                <tr>
                    <th>Member</th>
                    <th>Category</th>
                    <th>Institution</th>
                    <th>Country</th>
                    <th>Order</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($members as $member)
                <tr>
                    <td>
                        <div class="d-flex align-items-center gap-2">
                            @if($member->photo)
                                <img src="{{ Storage::url($member->photo) }}"
                                     class="rounded-circle"
                                     width="36" height="36"
                                     style="object-fit:cover">
                            @else
                                <div class="rounded-circle bg-primary text-white d-flex align-items-center justify-content-center"
                                     style="width:36px;height:36px;font-size:0.8rem;font-weight:600;flex-shrink:0">
                                    {{ strtoupper(substr($member->name, 0, 1)) }}
                                </div>
                            @endif
                            <div>
                                <div class="fw-semibold small">{{ $member->name }}</div>
                                <div class="text-muted" style="font-size:0.75rem">{{ $member->designation }}</div>
                            </div>
                        </div>
                    </td>
                    <td>
                        <span class="badge bg-primary bg-opacity-10 text-primary small">
                            {{ ucfirst(str_replace('_', ' ', $member->category)) }}
                        </span>
                    </td>
                    <td class="small text-muted">{{ $member->institution ?? '—' }}</td>
                    <td class="small text-muted">{{ $member->country ?? '—' }}</td>
                    <td class="small">{{ $member->order }}</td>
                    <td>
                        <div class="d-flex gap-1">
                            <a href="{{ route('admin.editorial-board.edit', $member) }}"
                               class="btn btn-sm btn-outline-primary">
                                <i class="bi bi-pencil"></i>
                            </a>
                            <form method="POST"
                                  action="{{ route('admin.editorial-board.destroy', $member) }}"
                                  onsubmit="return confirm('Remove this member?')">
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
                    <td colspan="6" class="text-center text-muted py-4">No members found.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    @if($members->hasPages())
    <div class="card-footer">{{ $members->links() }}</div>
    @endif
</div>
@endsection