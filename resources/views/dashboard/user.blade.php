<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Dashboard - User Activity Monitor</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
        body {
            background: #f8f9fa;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        .stat-card {
            transition: transform 0.3s ease, box-shadow 0.3s ease;
            border: none;
            border-radius: 15px;
            overflow: hidden;
        }
        .stat-card:hover {
            transform: translateY(-8px);
            box-shadow: 0 10px 25px rgba(0,0,0,0.15);
        }
        .navbar-brand {
            font-weight: 700;
        }
        .activity-item {
            border-left: 3px solid #007bff;
            padding-left: 15px;
            margin-bottom: 15px;
        }
        .profile-avatar {
            width: 80px;
            height: 80px;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 2rem;
            font-weight: bold;
            color: white;
            margin: 0 auto;
        }
        .inactivity-warning {
            border-left: 4px solid #ffc107;
            background: #fffbf0;
        }
        .session-active {
            border-left: 4px solid #28a745;
            background: #f8fff9;
        }
    </style>
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-primary shadow">
        <div class="container">
            <a class="navbar-brand" href="#">
                <i class="fas fa-shield-alt me-2"></i>Activity Monitor
            </a>
            <div class="navbar-nav ms-auto">
                <span class="navbar-text me-3">
                    <i class="fas fa-user me-1"></i>Welcome, {{ $user->name }}
                </span>
                <a href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();" 
                   class="btn btn-outline-light btn-sm">
                    <i class="fas fa-sign-out-alt me-1"></i>Logout
                </a>
                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                    @csrf
                </form>
            </div>
        </div>
    </nav>

    <div class="container mt-4">
        <div class="row">
            <div class="col-12">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h2 class="text-dark"><i class="fas fa-tachometer-alt me-2"></i>User Dashboard</h2>
                    <div class="text-muted">
                        <i class="fas fa-clock me-1"></i>
                        <span id="current-time">{{ now()->format('g:i A') }}</span>
                    </div>
                </div>
                
                <!-- Stats Cards with Real Data -->
                <div class="row mb-4">
                    <div class="col-md-3 mb-3">
                        <div class="card stat-card text-white bg-primary">
                            <div class="card-body">
                                <div class="d-flex justify-content-between">
                                    <div>
                                        <h6 class="card-title opacity-75">My Activities</h6>
                                        <h2 class="card-text">{{ $userStats['total_activities'] ?? 0 }}</h2>
                                        <small>Total actions</small>
                                    </div>
                                    <div class="align-self-center">
                                        <i class="fas fa-history fa-2x opacity-75"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3 mb-3">
                        <div class="card stat-card text-white bg-success">
                            <div class="card-body">
                                <div class="d-flex justify-content-between">
                                    <div>
                                        <h6 class="card-title opacity-75">Today's Actions</h6>
                                        <h2 class="card-text">{{ $userStats['today_activities'] ?? 0 }}</h2>
                                        <small>Actions today</small>
                                    </div>
                                    <div class="align-self-center">
                                        <i class="fas fa-chart-line fa-2x opacity-75"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3 mb-3">
                        <div class="card stat-card text-white bg-warning">
                            <div class="card-body">
                                <div class="d-flex justify-content-between">
                                    <div>
                                        <h6 class="card-title opacity-75">Inactivity Warnings</h6>
                                        <h2 class="card-text">{{ $userStats['inactivity_count'] ?? 0 }}</h2>
                                        <small>Total warnings</small>
                                    </div>
                                    <div class="align-self-center">
                                        <i class="fas fa-clock fa-2x opacity-75"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3 mb-3">
                        <div class="card stat-card text-white bg-info">
                            <div class="card-body">
                                <div class="d-flex justify-content-between">
                                    <div>
                                        <h6 class="card-title opacity-75">Penalties</h6>
                                        <h2 class="card-text">{{ $userStats['penalty_count'] ?? 0 }}</h2>
                                        <small>Active penalties</small>
                                    </div>
                                    <div class="align-self-center">
                                        <i class="fas fa-exclamation-triangle fa-2x opacity-75"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Main Content -->
                <div class="row">
                    <!-- Recent Activity -->
                    <div class="col-md-8">
                        <div class="card shadow-sm mb-4">
                            <div class="card-header bg-white border-0 py-3">
                                <h5 class="card-title mb-0 text-primary">
                                    <i class="fas fa-bell me-2"></i>Recent Activity
                                </h5>
                            </div>
                            <div class="card-body">
                                @if(isset($recentActivities) && $recentActivities->count() > 0)
                                    @foreach($recentActivities as $activity)
                                    <div class="activity-item mb-3 p-3 bg-light rounded">
                                        <div class="d-flex w-100 justify-content-between">
                                            <h6 class="mb-1 text-capitalize text-dark">{{ $activity->action }}</h6>
                                            <small class="text-muted">{{ $activity->created_at->diffForHumans() }}</small>
                                        </div>
                                        <p class="mb-1 text-muted">{{ $activity->description }}</p>
                                        <div class="d-flex gap-2 mt-2">
                                            <span class="badge bg-secondary">
                                                <i class="fas fa-globe me-1"></i>{{ $activity->browser ?? 'Unknown' }}
                                            </span>
                                            <span class="badge bg-light text-dark border">
                                                <i class="fas fa-desktop me-1"></i>{{ $activity->platform ?? 'Unknown' }}
                                            </span>
                                            @if($activity->ip_address)
                                            <span class="badge bg-light text-dark border">
                                                <i class="fas fa-network-wired me-1"></i>{{ $activity->ip_address }}
                                            </span>
                                            @endif
                                        </div>
                                    </div>
                                    @endforeach
                                @else
                                    <div class="alert alert-info">
                                        <i class="fas fa-info-circle me-2"></i>
                                        <strong>Welcome to the User Activity Monitor!</strong>
                                        <p class="mb-0 mt-2">Your activities will appear here as you use the system. Currently, no activities have been recorded.</p>
                                    </div>
                                @endif
                            </div>
                        </div>

                        <!-- Inactivity Warnings -->
                        @if(isset($recentInactivities) && $recentInactivities->count() > 0)
                        <div class="card shadow-sm">
                            <div class="card-header bg-white border-0 py-3">
                                <h5 class="card-title mb-0 text-warning">
                                    <i class="fas fa-clock me-2"></i>Recent Inactivity Warnings
                                </h5>
                            </div>
                            <div class="card-body">
                                @foreach($recentInactivities as $inactivity)
                                <div class="inactivity-warning mb-3 p-3 rounded">
                                    <div class="d-flex w-100 justify-content-between">
                                        <h6 class="mb-1 text-warning">
                                            <i class="fas fa-exclamation-triangle me-1"></i>
                                            {{ ucfirst($inactivity->type) }} Alert
                                        </h6>
                                        <small class="text-muted">{{ $inactivity->created_at->diffForHumans() }}</small>
                                    </div>
                                    <p class="mb-1 text-muted">{{ $inactivity->reason }}</p>
                                    <small class="text-warning">
                                        <i class="fas fa-stopwatch me-1"></i>
                                        Idle for {{ $inactivity->idle_duration }} seconds
                                    </small>
                                </div>
                                @endforeach
                            </div>
                        </div>
                        @endif
                    </div>
                    
                    <!-- Sidebar -->
                    <div class="col-md-4">
                        <!-- Profile Card -->
                        <div class="card shadow-sm mb-4">
                            <div class="card-header bg-white border-0 py-3">
                                <h5 class="card-title mb-0 text-primary">
                                    <i class="fas fa-user me-2"></i>My Profile
                                </h5>
                            </div>
                            <div class="card-body text-center">
                                <div class="profile-avatar mb-3">
                                    {{ strtoupper(substr($user->name, 0, 1)) }}
                                </div>
                                <h5 class="text-dark">{{ $user->name }}</h5>
                                <p class="text-muted">{{ $user->email }}</p>
                                <div class="mb-3">
                                    <span class="badge bg-primary">{{ ucfirst($user->role) }}</span>
                                    <span class="badge bg-success">Active</span>
                                </div>
                                <small class="text-muted d-block">
                                    <i class="fas fa-calendar me-1"></i>
                                    Member since {{ $user->created_at->format('M Y') }}
                                </small>
                                <small class="text-muted d-block mt-1">
                                    <i class="fas fa-clock me-1"></i>
                                    Last active: {{ $userStats['last_activity'] ?? 'Never' }}
                                </small>
                            </div>
                        </div>

                        <!-- Session Status -->
                        <div class="card shadow-sm mb-4">
                            <div class="card-header bg-white border-0 py-3">
                                <h5 class="card-title mb-0 text-success">
                                    <i class="fas fa-play-circle me-2"></i>Session Status
                                </h5>
                            </div>
                            <div class="card-body">
                                <div class="session-active p-3 rounded">
                                    <div class="d-flex align-items-center">
                                        <i class="fas fa-check-circle text-success fa-2x me-3"></i>
                                        <div>
                                            <h6 class="mb-1 text-success">Session Active</h6>
                                            <p class="mb-0 text-muted small">You are currently logged in and active</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="mt-3">
                                    <small class="text-muted">
                                        <i class="fas fa-shield-alt me-1"></i>
                                        Session started: {{ now()->format('g:i A') }}
                                    </small>
                                </div>
                            </div>
                        </div>

                        <!-- System Notice -->
                        <div class="card shadow-sm">
                            <div class="card-header bg-white border-0 py-3">
                                <h5 class="card-title mb-0 text-warning">
                                    <i class="fas fa-exclamation-triangle me-2"></i>System Notice
                                </h5>
                            </div>
                            <div class="card-body">
                                <div class="alert alert-warning mb-0">
                                    <small>
                                        <i class="fas fa-info-circle me-1"></i>
                                        <strong>Inactivity Monitoring Active</strong>
                                        <p class="mb-0 mt-1">The system will automatically log you out after periods of inactivity to ensure security.</p>
                                    </small>
                                </div>
                                <div class="mt-3">
                                    <div class="progress mb-2" style="height: 8px;">
                                        <div class="progress-bar bg-warning" role="progressbar" style="width: 25%;" 
                                             aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
                                    </div>
                                    <small class="text-muted">Inactivity monitoring: <strong>Active</strong></small>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <footer class="bg-dark text-white text-center py-4 mt-5">
        <div class="container">
            <small>
                <i class="fas fa-shield-alt me-1"></i>
                &copy; 2024 User Activity Monitor System. All rights reserved.
            </small>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Update current time
        function updateTime() {
            const now = new Date();
            const timeString = now.toLocaleTimeString('en-US', { 
                hour: 'numeric', 
                minute: '2-digit',
                hour12: true 
            });
            document.getElementById('current-time').textContent = timeString;
        }
        
        // Update time every minute
        setInterval(updateTime, 60000);
        updateTime();

        // Inactivity monitoring
        let inactivityTime = 0;
        const inactivityInterval = setInterval(() => {
            inactivityTime += 1;
            // You can add inactivity warnings here
        }, 1000);

        // Reset inactivity timer on user activity
        document.addEventListener('mousemove', resetInactivity);
        document.addEventListener('keypress', resetInactivity);
        document.addEventListener('click', resetInactivity);

        function resetInactivity() {
            inactivityTime = 0;
        }

        // Auto-refresh stats every 30 seconds
        setInterval(() => {
            // You can add AJAX call to refresh stats here
            console.log('Refreshing dashboard stats...');
        }, 30000);
    </script>
</body>
</html>