@extends('layouts.app')
@section('title', 'CMS Pages')
@section('page-title', 'CMS — Static Pages')

@section('content')
<div class="card">
    <div class="card-header">Manage Pages</div>
    <div class="card-body p-0">
        <table class="table table-hover align-middle mb-0">
            <thead class="table-light">
                <tr>
                    <th>Page</th>
                    <th>Last Updated</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($pageData as $key => $page)
                <tr>
                    <td>
                        <div class="fw-semibold small">{{ $page['label'] }}</div>
                        <div class="text-muted" style="font-size:0.75rem">/{{ $page['key'] }}</div>
                    </td>
                    <td class="small text-muted">{{ $page['last_updated'] }}</td>
                    <td>
                        <a href="{{ route('admin.cms.edit', $page['key']) }}"
                           class="btn btn-sm btn-outline-primary">
                            <i class="bi bi-pencil me-1"></i> Edit
                        </a>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection