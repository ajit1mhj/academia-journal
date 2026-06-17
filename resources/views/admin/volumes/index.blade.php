@extends('layouts.app')
@section('title', 'Volumes')
@section('page-title', 'Volume Management')

@section('content')
<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <span>All Volumes</span>
        <a href="{{ route('admin.volumes.create') }}" class="btn btn-sm btn-primary">
            <i class="bi bi-plus-lg me-1"></i> Add Volume
        </a>
    </div>
    <div class="card-body p-0">
        <table class="table table-hover align-middle mb-0">
            <thead class="table-light">
                <tr>
                    <th>#</th>
                    <th>Journal</th>
                    <th>Volume</th>
                    <th>Year</th>
                    <th>Issues</th>
                    <th>Status</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($volumes as $volume)
                <tr>
                    <td class="text-muted small">{{ $volume->id }}</td>
                    <td class="small fw-semibold">{{ $volume->journal->title }}</td>
                    <td class="small">Volume {{ $volume->volume_no }}</td>
                    <td class="small">{{ $volume->year }}</td>
                    <td class="small">{{ $volume->issues->count() }}</td>
                    <td>
                        <span class="badge {{ $volume->status === 'active' ? 'bg-success' : 'bg-secondary' }}">
                            {{ ucfirst($volume->status) }}
                        </span>
                    </td>
                    <td>
                        <div class="d-flex gap-1">
                            <a href="{{ route('admin.volumes.edit', $volume) }}"
                               class="btn btn-sm btn-outline-primary">
                                <i class="bi bi-pencil"></i>
                            </a>
                            <form method="POST" action="{{ route('admin.volumes.destroy', $volume) }}"
                                  onsubmit="return confirm('Delete this volume?')">
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
                    <td colspan="7" class="text-center text-muted py-4">No volumes found.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    @if($volumes->hasPages())
    <div class="card-footer">{{ $volumes->links() }}</div>
    @endif
</div>
@endsection