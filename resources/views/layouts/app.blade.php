<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'AJMS') — Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        body {
            background: #f5f7fa;
        }

        .sidebar {
            width: 250px;
            min-height: 100vh;
            background: #1a3c5e;
            position: fixed;
            top: 0;
            left: 0;
            padding-top: 1rem;
            z-index: 100;
        }

        .sidebar-brand {
            color: #fff;
            font-weight: 700;
            font-size: 1.2rem;
            padding: 1rem 1.5rem 1.5rem;
            display: block;
            text-decoration: none;
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
            margin-bottom: 1rem;
        }

        .sidebar .nav-link {
            color: rgba(255, 255, 255, 0.75);
            padding: 0.6rem 1.5rem;
            font-size: 0.9rem;
            border-radius: 0;
            transition: all 0.2s;
        }

        .sidebar .nav-link:hover,
        .sidebar .nav-link.active {
            color: #fff;
            background: rgba(255, 255, 255, 0.1);
        }

        .sidebar .nav-link i {
            margin-right: 8px;
        }

        .sidebar-heading {
            color: rgba(255, 255, 255, 0.4);
            font-size: 0.7rem;
            text-transform: uppercase;
            letter-spacing: 1px;
            padding: 1rem 1.5rem 0.3rem;
        }

        .main-content {
            margin-left: 250px;
            padding: 0;
        }

        .topbar {
            background: #fff;
            border-bottom: 1px solid #e5e9f0;
            padding: 0.75rem 1.5rem;
            display: flex;
            align-items: center;
            justify-content: space-between;
            position: sticky;
            top: 0;
            z-index: 99;
        }

        .page-content {
            padding: 1.5rem;
        }

        .card {
            border: none;
            border-radius: 10px;
            box-shadow: 0 1px 8px rgba(0, 0, 0, 0.06);
        }

        .card-header {
            background: #fff;
            border-bottom: 1px solid #f0f0f0;
            font-weight: 600;
            border-radius: 10px 10px 0 0 !important;
        }

        .stat-card {
            background: #fff;
            border-radius: 10px;
            padding: 1.25rem;
            box-shadow: 0 1px 8px rgba(0, 0, 0, 0.06);
        }

        .stat-card .stat-value {
            font-size: 2rem;
            font-weight: 700;
            color: #1a3c5e;
        }

        .stat-card .stat-label {
            color: #6c757d;
            font-size: 0.85rem;
        }

        .badge-submitted {
            background: #e3f2fd;
            color: #1565c0;
        }

        .badge-under_review {
            background: #fff3e0;
            color: #e65100;
        }

        .badge-accepted {
            background: #e8f5e9;
            color: #2e7d32;
        }

        .badge-rejected {
            background: #ffebee;
            color: #c62828;
        }

        .badge-published {
            background: #e8f5e9;
            color: #1b5e20;
        }

        .badge-revision_requested {
            background: #f3e5f5;
            color: #6a1b9a;
        }

        .notification-dot {
            width: 8px;
            height: 8px;
            background: #dc3545;
            border-radius: 50%;
            display: inline-block;
            margin-left: 4px;
            vertical-align: middle;
        }
    </style>
    @stack('styles')
</head>

<body>

    {{-- Sidebar --}}
    <div class="sidebar">
        <a href="{{ route('dashboard') }}" class="sidebar-brand">
            <i class="bi bi-journal-richtext"></i> Academia Journal
        </a>

        @auth
        @php $role = auth()->user()->role?->name; @endphp

        {{-- Admin Menu --}}
        @if($role === 'admin')
        <div class="sidebar-heading">Main</div>
        <a href="{{ route('admin.dashboard') }}"
            class="nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
            <i class="bi bi-speedometer2"></i> Dashboard
        </a>

        <div class="sidebar-heading">Management</div>
        <a href="{{ route('admin.users.index') }}"
            class="nav-link {{ request()->routeIs('admin.users*') ? 'active' : '' }}">
            <i class="bi bi-people"></i> Users
        </a>
        <a href="{{ route('admin.journals.index') }}"
            class="nav-link {{ request()->routeIs('admin.journals*') ? 'active' : '' }}">
            <i class="bi bi-journal-text"></i> Journals
        </a>
        <a href="{{ route('admin.volumes.index') }}"
            class="nav-link {{ request()->routeIs('admin.volumes*') ? 'active' : '' }}">
            <i class="bi bi-collection"></i> Volumes
        </a>
        <a href="{{ route('admin.issues.index') }}"
            class="nav-link {{ request()->routeIs('admin.issues*') ? 'active' : '' }}">
            <i class="bi bi-layers"></i> Issues
        </a>
        <a href="{{ route('admin.editorial-board.index') }}"
            class="nav-link {{ request()->routeIs('admin.editorial-board*') ? 'active' : '' }}">
            <i class="bi bi-person-badge"></i> Editorial Board
        </a>

        <div class="sidebar-heading">Content</div>
        <a href="{{ route('admin.cms.index') }}"
            class="nav-link {{ request()->routeIs('admin.cms*') ? 'active' : '' }}">
            <i class="bi bi-file-earmark-text"></i> CMS Pages
        </a>
        <a href="{{ route('admin.reports.index') }}"
            class="nav-link {{ request()->routeIs('admin.reports*') ? 'active' : '' }}">
            <i class="bi bi-bar-chart"></i> Reports
        </a>
        @endif

        {{-- Editor Menu --}}
        @if($role === 'editor' || $role === 'admin')
        <div class="sidebar-heading">Editorial</div>
        <a href="{{ route('editor.dashboard') }}"
            class="nav-link {{ request()->routeIs('editor.dashboard') ? 'active' : '' }}">
            <i class="bi bi-speedometer2"></i> Dashboard
        </a>
        <a href="{{ route('editor.articles.index') }}"
            class="nav-link {{ request()->routeIs('editor.articles*') ? 'active' : '' }}">
            <i class="bi bi-file-earmark-richtext"></i> Manuscripts
        </a>
        @endif

        {{-- Author Menu --}}
        @if($role === 'author')
        <div class="sidebar-heading">My Work</div>
        <a href="{{ route('author.dashboard') }}"
            class="nav-link {{ request()->routeIs('author.dashboard') ? 'active' : '' }}">
            <i class="bi bi-speedometer2"></i> Dashboard
        </a>
        <a href="{{ route('author.submissions.index') }}"
            class="nav-link {{ request()->routeIs('author.submissions*') ? 'active' : '' }}">
            <i class="bi bi-upload"></i> My Submissions
        </a>
        <a href="{{ route('author.submissions.create') }}"
            class="nav-link {{ request()->routeIs('author.submissions.create') ? 'active' : '' }}">
            <i class="bi bi-plus-circle"></i> New Submission
        </a>
        @endif

        {{-- Reviewer Menu --}}
        @if($role === 'reviewer')
        <div class="sidebar-heading">Reviews</div>
        <a href="{{ route('reviewer.dashboard') }}"
            class="nav-link {{ request()->routeIs('reviewer.dashboard') ? 'active' : '' }}">
            <i class="bi bi-speedometer2"></i> Dashboard
        </a>
        <a href="{{ route('reviewer.reviews.index') }}"
            class="nav-link {{ request()->routeIs('reviewer.reviews*') ? 'active' : '' }}">
            <i class="bi bi-clipboard-check"></i> My Reviews
        </a>
        @endif

        {{-- Shared --}}
        <div class="sidebar-heading">Account</div>
        <a href="{{ route('profile.show') }}"
            class="nav-link {{ request()->routeIs('profile*') ? 'active' : '' }}">
            <i class="bi bi-person-circle"></i> Profile
        </a>
        @endauth
    </div>

    {{-- Main Content --}}
    <div class="main-content">

        {{-- Topbar --}}
        <div class="topbar">
            <div>
                <span class="fw-semibold text-muted">@yield('page-title', 'Dashboard')</span>
            </div>
            <div class="d-flex align-items-center gap-3">
                {{-- Notifications --}}
                <a href="{{ route('notifications.index') }}" class="text-muted text-decoration-none position-relative">
                    <i class="bi bi-bell fs-5"></i>
                    @php
                    $unreadCount = \App\Models\Notification::where('user_id', auth()->id())
                    ->where('is_read', false)
                    ->count();
                    @endphp
                    @if($unreadCount > 0)
                    <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger" style="font-size:0.6rem">
                        {{ $unreadCount }}
                    </span>
                    @endif
                </a>

                {{-- User Dropdown --}}
                <div class="dropdown">
                    <a href="#" class="dropdown-toggle text-decoration-none text-dark d-flex align-items-center gap-2"
                        data-bs-toggle="dropdown">
                        @if(auth()->user()->photo)
                        <img src="{{ Storage::url(auth()->user()->photo) }}"
                            class="rounded-circle" width="32" height="32"
                            style="object-fit:cover">
                        @else
                        <div class="rounded-circle bg-primary text-white d-flex align-items-center justify-content-center"
                            style="width:32px;height:32px;font-size:0.8rem;font-weight:600">
                            {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                        </div>
                        @endif
                        <span class="small fw-semibold">{{ auth()->user()->name }}</span>
                    </a>
                    <ul class="dropdown-menu dropdown-menu-end">
                        <li>
                            <span class="dropdown-item-text small text-muted">
                                {{ auth()->user()->role?->name }}
                            </span>
                        </li>
                        <li>
                            <hr class="dropdown-divider">
                        </li>
                        <li>
                            <a class="dropdown-item" href="{{ route('profile.show') }}">
                                <i class="bi bi-person me-2"></i> Profile
                            </a>
                        </li>
                        <li>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="dropdown-item text-danger">
                                    <i class="bi bi-box-arrow-right me-2"></i> Logout
                                </button>
                            </form>
                        </li>
                    </ul>
                </div>
            </div>
        </div>

        {{-- Page Content --}}
        <div class="page-content">
            @include('components.alert')
            @yield('content')
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    @stack('scripts')
</body>

</html>