<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'AJMS') — Academic Journal</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        body {
            background: #f0f4f8;
            min-height: 100vh;
        }

        .auth-card {
            max-width: 480px;
            margin: 60px auto;
            background: #fff;
            border-radius: 12px;
            box-shadow: 0 4px 24px rgba(0, 0, 0, 0.08);
            padding: 2.5rem;
        }

        .auth-logo {
            text-align: center;
            margin-bottom: 1.5rem;
        }

        .auth-logo h4 {
            font-weight: 700;
            color: #1a3c5e;
        }

        .btn-primary {
            background: #1a3c5e;
            border-color: #1a3c5e;
        }

        .btn-primary:hover {
            background: #14304d;
            border-color: #14304d;
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="auth-card">
            <div class="auth-logo">
                <h4><i class="bi bi-journal-richtext"></i> Academia Journal</h4>
                <p class="text-muted small"></p>
            </div>
            @include('components.alert')
            @yield('content')
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>