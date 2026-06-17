<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>403 — Unauthorized</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
    <div class="container text-center" style="padding-top:120px">
        <h1 class="display-1 fw-bold text-danger">403</h1>
        <h4 class="mb-3">Access Denied</h4>
        <p class="text-muted">You don't have permission to access this page.</p>
        <a href="{{ url()->previous() }}" class="btn btn-outline-secondary mt-2">Go Back</a>
        <a href="{{ route('dashboard') }}" class="btn btn-primary mt-2">Dashboard</a>
    </div>
</body>
</html>