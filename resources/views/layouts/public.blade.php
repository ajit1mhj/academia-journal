<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'AJMS') — Academic Journal</title>

    <link rel="icon" type="image/png" href="{{ asset('storage/images/logo.png') }}">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        :root {
            --primary: #0B2E59;
            --primary-dark: #003372;
            --primary-light: #003170;
            --secondary: #F5F8FC;
            --border: #E4EAF2;
            --text: #2C3E50;
        }

        body {
            font-family: 'Segoe UI', sans-serif;
        }

        .navbar-brand {
            font-weight: 700;
            font-size: 1.3rem;
            color: #1a3c5e !important;
        }

        .navbar {
            background: #fff;
            border-bottom: 1px solid #e5e9f0;
        }

        .navbar .nav-link {
            color: #444 !important;
            font-size: 0.9rem;
        }

        .navbar .nav-link:hover {
            color: #1a3c5e !important;
        }

        .navbar .nav-link.active {
            color: #1a3c5e !important;
            font-weight: 600;
        }

        .hero {
            background: #1a3c5e;
            color: #fff;
            padding: 80px 0;
        }

        .hero h1 {
            font-size: 2.5rem;
            font-weight: 700;
        }

        .hero p {
            font-size: 1.1rem;
            opacity: 0.9;
        }

        .section-title {
            font-size: 1.5rem;
            font-weight: 700;
            color: #0B2E59;
            border-left: 4px solid #1D4F91;
            padding-left: 12px;
            margin-bottom: 1.5rem;
        }

        .article-card {
            border: none;
            border-radius: 10px;
            box-shadow: 0 2px 12px rgba(0, 0, 0, 0.07);
            transition: transform 0.2s, box-shadow 0.2s;
        }

        .article-card:hover {
            transform: translateY(-3px);
            box-shadow: 0 6px 20px rgba(0, 0, 0, 0.12);
        }

        footer {
            background: #1a3c5e;
            color: rgba(255, 255, 255, 0.8);
            padding: 40px 0 20px;
        }

        footer h6 {
            color: #fff;
            font-weight: 600;
        }

        footer a {
            color: rgba(255, 255, 255, 0.7);
            text-decoration: none;
            font-size: 0.875rem;
        }

        footer a:hover {
            color: #fff;
        }

        footer .footer-bottom {
            border-top: 1px solid rgba(255, 255, 255, 0.15);
            margin-top: 24px;
            padding-top: 16px;
            font-size: 0.8rem;
        }

        .dropdown-menu {
            border-radius: 10px;
            min-width: 220px;
        }

        .dropdown-item {
            font-size: 0.9rem;
            padding: 0.65rem 1rem;
        }

        .dropdown-item:hover {
            background: #f5f8fc;
            color: #1a3c5e;
        }

        .dropdown-item:active {
            background: #1a3c5e;
            color: #fff;
        }
    </style>
    @stack('styles')
</head>

<body>

    {{-- Navbar --}}
    <nav class="navbar navbar-expand-lg sticky-top shadow-sm">
        <div class="container">
            <a class="navbar-brand" href="{{ route('home') }}">
                <img src="{{ asset('storage/images/logo.png') }}" alt="AJMS Logo" width="24" height="24" class="me-2">Academia Journal
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navMenu">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navMenu">
                <ul class="navbar-nav me-auto">
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('home') ? 'active' : '' }}"
                            href="{{ route('home') }}">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('about') ? 'active' : '' }}"
                            href="{{ route('about') }}">About</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('editorial-board') ? 'active' : '' }}"
                            href="{{ route('editorial-board') }}">Editorial Board</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('current-issue') ? 'active' : '' }}"
                            href="{{ route('current-issue') }}">Current Issue</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('archives') ? 'active' : '' }}"
                            href="{{ route('archives') }}">
                            Archives
                        </a>
                    </li>

                    {{-- Authors Dropdown --}}
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle
        {{ request()->routeIs('submission-checklist') ||
           request()->routeIs('author-guidelines') ||
           request()->routeIs('submit-manuscript')
            ? 'active'
            : '' }}"
                            href="#"
                            id="authorsDropdown"
                            role="button"
                            data-bs-toggle="dropdown"
                            aria-expanded="false">
                            For Authors
                        </a>

                        <ul class="dropdown-menu shadow border-0" aria-labelledby="authorsDropdown">
                            <li>
                                <a class="dropdown-item"
                                    href="{{ route('submission-checklist') }}">
                                    Submission Checklist
                                </a>
                            </li>

                            <li>
                                <a class="dropdown-item"
                                    href="{{ route('author-guidelines') }}">
                                    Author Guidelines
                                </a>
                            </li>
                        </ul>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('contact') ? 'active' : '' }}"
                            href="{{ route('contact') }}">
                            Contact
                        </a>
                    </li>
                </ul>
                <div class="d-flex gap-2">
                    @auth
                    <a href="{{ route('dashboard') }}" class="btn btn-sm btn-outline-primary">
                        <i class="bi bi-speedometer2 me-1"></i> Dashboard
                    </a>
                    @else
                    <a href="{{ route('login') }}" class="btn btn-sm btn-outline-primary">Login</a>
                    <a href="{{ route('register') }}" class="btn btn-sm btn-primary" style="background-color: #003170;">Submit Manuscript</a>
                    @endauth
                </div>
            </div>
        </div>
    </nav>

    {{-- Page Content --}}
    @yield('content')

    {{-- Footer --}}
    <footer>
        <div class="container">
            <div class="row g-4">
                <div class="col-md-4">
                    <div class="d-flex align-items-center mb-2">
                        <img src="{{ asset('storage/images/college-logo.png') }}"
                            alt="AJMS Logo"
                            width="200"
                            height="80"
                            class="me-2">

                    </div>

                    <p style="font-size:1rem;opacity:0.8">
                        Academia Journal- Open-access journal
                        committed to research excellence.
                    </p>
                </div>
                <div class="col-md-2">
                    <h6>Journal</h6>
                    <ul class="list-unstyled">
                        <li><a href="{{ route('about') }}">About</a></li>
                        <li><a href="{{ route('editorial-board') }}">Editorial Board</a></li>
                        <li><a href="{{ route('publication-ethics') }}">Ethics Policy</a></li>
                    </ul>
                </div>
                <div class="col-md-2">
                    <h6>Articles</h6>
                    <ul class="list-unstyled">
                        <li><a href="{{ route('current-issue') }}">Current Issue</a></li>
                        <li><a href="{{ route('archives') }}">Archives</a></li>
                    </ul>
                </div>
                <div class="col-md-2">
                    <h6>Authors</h6>
                    <ul class="list-unstyled">
                        <li><a href="{{ route('register') }}">Submit Manuscript</a></li>
                        <li><a href="{{ route('login') }}">Author Login</a></li>
                    </ul>
                </div>
                <div class="col-md-2">
                    <h6>Contact</h6>
                    <ul class="list-unstyled">
                        <li><a href="{{ route('contact') }}">Contact Us</a></li>
                    </ul>
                </div>
            </div>
            <div class="footer-bottom text-center">
                &copy; 2026 Academia International College. All rights reserved.
            </div>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    @stack('scripts')
</body>

</html>