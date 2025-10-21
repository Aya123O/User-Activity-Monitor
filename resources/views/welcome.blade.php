
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Activity Monitor</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
        body {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        .welcome-card {
            background: white;
            border-radius: 15px;
            box-shadow: 0 20px 40px rgba(0,0,0,0.1);
            padding: 3rem;
            max-width: 450px;
            width: 100%;
            text-align: center;
        }
        .logo {
            font-size: 2.5rem;
            color: #667eea;
            margin-bottom: 1rem;
        }
        .btn-custom {
            padding: 12px 30px;
            border-radius: 8px;
            font-weight: 600;
            transition: all 0.3s ease;
        }
        .test-accounts {
            background: #f8f9fa;
            border-radius: 8px;
            padding: 1rem;
            margin-top: 2rem;
            font-size: 0.9rem;
        }
    </style>
</head>
<body>
    <div class="welcome-card">
        <div class="logo">
            <i class="fas fa-shield-alt"></i>
        </div>
        <h1 class="h3 mb-3 fw-bold">User Activity Monitor</h1>
        <p class="text-muted mb-4">Track user activities and monitor inactivity with our comprehensive system</p>
        
        <div class="d-grid gap-3">
            <a href="/login" class="btn btn-primary btn-custom">
                <i class="fas fa-sign-in-alt me-2"></i>Login
            </a>
            <a href="/register" class="btn btn-outline-primary btn-custom">
                <i class="fas fa-user-plus me-2"></i>Register
            </a>
        </div>

        <div class="test-accounts">
            <p class="mb-2"><strong>Test Accounts:</strong></p>
            <p class="mb-1">👑 Admin: admin@example.com / password</p>
            <p class="mb-0">👤 User: user@example.com / password</p>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
