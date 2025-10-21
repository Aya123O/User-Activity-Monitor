<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'User Activity Monitor')</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f8f9fa;
            margin: 0;
            padding: 0;
        }
        .sidebar {
            background: #2c3e50;
            min-height: 100vh;
            padding: 20px;
        }
        .sidebar .nav-link {
            color: #ecf0f1;
            padding: 12px 15px;
            border-left: 3px solid transparent;
            margin-bottom: 5px;
            border-radius: 0;
        }
        .sidebar .nav-link:hover {
            color: #3498db;
            background: rgba(255,255,255,0.1);
            border-left-color: #3498db;
        }
        .sidebar .nav-link.active {
            color: #3498db;
            background: rgba(255,255,255,0.1);
            border-left-color: #3498db;
        }
        .main-content {
            padding: 20px;
        }
    </style>
</head>
<body>
    @yield('content')

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    @stack('scripts')
</body>
</html>