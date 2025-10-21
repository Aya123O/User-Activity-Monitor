@extends('layouts.app')

@section('title', 'Admin Dashboard - User Activity Monitor')

@section('content')
<div class="container-fluid">
    <div class="row">
        @include('layouts.sidebar')
        
        <div class="col-md-9 col-lg-10 main-content">
            <!-- Header with Gradient -->
            <div class="dashboard-header bg-gradient-primary rounded-3 p-4 mb-4 text-white">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h1 class="h3 mb-1">Welcome back, {{ auth()->user()->name }}! 👋</h1>
                        <p class="mb-0 opacity-75">Here's what's happening with your system today</p>
                    </div>
                    <div class="text-end">
                        <span class="badge bg-light text-primary fs-6">{{ auth()->user()->role }}</span>
                        <div class="mt-2">
                            <small class="opacity-75">{{ now()->format('l, F j, Y') }}</small>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Stats Cards with Icons and Animations -->
            <div class="row mb-4">
                <div class="col-xl-3 col-md-6 mb-4">
                    <div class="card stats-card bg-primary text-white hover-lift">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <h6 class="card-title text-white-50 mb-2">Total Users</h6>
                                    <h2 class="mb-0">{{ $totalUsers ?? 0 }}</h2>
                                    <small class="text-white-75">Registered accounts</small>
                                </div>
                                <div class="stats-icon">
                                    <i class="fas fa-users fa-2x opacity-50"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="col-xl-3 col-md-6 mb-4">
                    <div class="card stats-card bg-success text-white hover-lift">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <h6 class="card-title text-white-50 mb-2">Active Users</h6>
                                    <h2 class="mb-0">{{ $activeUsers ?? 0 }}</h2>
                                    <small class="text-white-75">Currently online</small>
                                </div>
                                <div class="stats-icon">
                                    <i class="fas fa-user-check fa-2x opacity-50"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="col-xl-3 col-md-6 mb-4">
                    <div class="card stats-card bg-warning text-white hover-lift">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <h6 class="card-title text-white-50 mb-2">Total Activities</h6>
                                    <h2 class="mb-0">{{ $totalActivities ?? 0 }}</h2>
                                    <small class="text-white-75">System events</small>
                                </div>
                                <div class="stats-icon">
                                    <i class="fas fa-history fa-2x opacity-50"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="col-xl-3 col-md-6 mb-4">
                    <div class="card stats-card bg-danger text-white hover-lift">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <h6 class="card-title text-white-50 mb-2">Active Penalties</h6>
                                    <h2 class="mb-0">{{ $activePenalties ?? 0 }}</h2>
                                    <small class="text-white-75">Pending actions</small>
                                </div>
                                <div class="stats-icon">
                                    <i class="fas fa-exclamation-triangle fa-2x opacity-50"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Quick Actions with Modern Cards -->
            <div class="row mb-4">
                <div class="col-12">
                    <div class="card border-0 shadow-sm">
                        <div class="card-header bg-transparent border-0 py-3">
                            <h5 class="card-title mb-0 d-flex align-items-center">
                                <i class="fas fa-bolt text-primary me-2"></i>
                                Quick Actions
                            </h5>
                        </div>
                        <div class="card-body">
                            <div class="row g-3">
                                <div class="col-xl-3 col-md-6">
                                    <a href="{{ route('users.create') }}" class="card action-card text-decoration-none">
                                        <div class="card-body text-center p-4">
                                            <div class="action-icon bg-primary bg-opacity-10 text-primary rounded-circle mx-auto mb-3">
                                                <i class="fas fa-user-plus fa-lg"></i>
                                            </div>
                                            <h6 class="mb-1">Add User</h6>
                                            <small class="text-muted">Create new account</small>
                                        </div>
                                    </a>
                                </div>
                                <div class="col-xl-3 col-md-6">
                                    <a href="{{ route('users.index') }}" class="card action-card text-decoration-none">
                                        <div class="card-body text-center p-4">
                                            <div class="action-icon bg-success bg-opacity-10 text-success rounded-circle mx-auto mb-3">
                                                <i class="fas fa-users fa-lg"></i>
                                            </div>
                                            <h6 class="mb-1">Manage Users</h6>
                                            <small class="text-muted">View all accounts</small>
                                        </div>
                                    </a>
                                </div>
                                <div class="col-xl-3 col-md-6">
                                    <a href="#" class="card action-card text-decoration-none">
                                        <div class="card-body text-center p-4">
                                            <div class="action-icon bg-info bg-opacity-10 text-info rounded-circle mx-auto mb-3">
                                                <i class="fas fa-chart-bar fa-lg"></i>
                                            </div>
                                            <h6 class="mb-1">View Reports</h6>
                                            <small class="text-muted">Analytics & insights</small>
                                        </div>
                                    </a>
                                </div>
                                <div class="col-xl-3 col-md-6">
                                    <a href="#" class="card action-card text-decoration-none">
                                        <div class="card-body text-center p-4">
                                            <div class="action-icon bg-warning bg-opacity-10 text-warning rounded-circle mx-auto mb-3">
                                                <i class="fas fa-cog fa-lg"></i>
                                            </div>
                                            <h6 class="mb-1">Settings</h6>
                                            <small class="text-muted">System configuration</small>
                                        </div>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Recent Activity with Modern Design -->
            <div class="row">
                <div class="col-xl-8 mb-4">
                    <div class="card border-0 shadow-sm h-100">
                        <div class="card-header bg-transparent border-0 py-3">
                            <h5 class="card-title mb-0 d-flex align-items-center">
                                <i class="fas fa-clock text-primary me-2"></i>
                                Recent Activity
                            </h5>
                        </div>
                        <div class="card-body">
                            @if(isset($recentActivities) && $recentActivities->count() > 0)
                                <div class="activity-timeline">
                                    @foreach($recentActivities as $activity)
                                    <div class="activity-item d-flex">
                                        <div class="activity-marker">
                                            <div class="activity-dot bg-primary"></div>
                                        </div>
                                        <div class="activity-content flex-grow-1 ms-3 pb-3">
                                            <div class="d-flex justify-content-between align-items-start">
                                                <h6 class="mb-1">{{ $activity->user->name ?? 'Unknown User' }}</h6>
                                                <small class="text-muted">{{ $activity->created_at->diffForHumans() }}</small>
                                            </div>
                                            <p class="mb-1 text-muted">{{ $activity->description ?? 'No description' }}</p>
                                            <span class="badge bg-light text-dark border">
                                                <i class="fas fa-tag me-1"></i>{{ $activity->action ?? 'Unknown' }}
                                            </span>
                                        </div>
                                    </div>
                                    @endforeach
                                </div>
                            @else
                                <div class="text-center py-5">
                                    <i class="fas fa-inbox fa-3x text-muted mb-3"></i>
                                    <h5 class="text-muted">No recent activity</h5>
                                    <p class="text-muted">Activity will appear here as users interact with the system</p>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>

                <!-- System Status Card -->
                <div class="col-xl-4 mb-4">
                    <div class="card border-0 shadow-sm h-100">
                        <div class="card-header bg-transparent border-0 py-3">
                            <h5 class="card-title mb-0 d-flex align-items-center">
                                <i class="fas fa-heartbeat text-success me-2"></i>
                                System Status
                            </h5>
                        </div>
                        <div class="card-body">
                            <div class="system-status">
                                <div class="status-item d-flex justify-content-between align-items-center py-2">
                                    <span class="d-flex align-items-center">
                                        <i class="fas fa-database text-primary me-2"></i>
                                        Database
                                    </span>
                                    <span class="badge bg-success">Online</span>
                                </div>
                                <div class="status-item d-flex justify-content-between align-items-center py-2">
                                    <span class="d-flex align-items-center">
                                        <i class="fas fa-server text-info me-2"></i>
                                        Server
                                    </span>
                                    <span class="badge bg-success">Stable</span>
                                </div>
                                <div class="status-item d-flex justify-content-between align-items-center py-2">
                                    <span class="d-flex align-items-center">
                                        <i class="fas fa-shield-alt text-warning me-2"></i>
                                        Security
                                    </span>
                                    <span class="badge bg-success">Active</span>
                                </div>
                                <div class="status-item d-flex justify-content-between align-items-center py-2">
                                    <span class="d-flex align-items-center">
                                        <i class="fas fa-sync text-secondary me-2"></i>
                                        Last Backup
                                    </span>
                                    <span class="text-muted">2 hours ago</span>
                                </div>
                            </div>
                            
                            <div class="mt-4 p-3 bg-light rounded">
                                <h6 class="mb-2">Quick Stats</h6>
                                <div class="row text-center">
                                    <div class="col-6">
                                        <div class="border-end">
                                            <div class="h5 mb-1 text-primary">98%</div>
                                            <small class="text-muted">Uptime</small>
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="h5 mb-1 text-success">24/7</div>
                                        <small class="text-muted">Monitoring</small>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .dashboard-header {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    }
    
    .stats-card {
        border: none;
        border-radius: 15px;
        transition: all 0.3s ease;
        overflow: hidden;
        position: relative;
    }
    
    .stats-card::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        height: 4px;
        background: rgba(255,255,255,0.3);
    }
    
    .stats-card.hover-lift:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 25px rgba(0,0,0,0.1);
    }
    
    .stats-icon {
        opacity: 0.8;
        transition: all 0.3s ease;
    }
    
    .stats-card:hover .stats-icon {
        transform: scale(1.1);
        opacity: 1;
    }
    
    .action-card {
        border: 1px solid #e9ecef;
        border-radius: 12px;
        transition: all 0.3s ease;
    }
    
    .action-card:hover {
        border-color: #007bff;
        transform: translateY(-3px);
        box-shadow: 0 5px 15px rgba(0,123,255,0.1);
    }
    
    .action-icon {
        width: 60px;
        height: 60px;
        display: flex;
        align-items: center;
        justify-content: center;
        transition: all 0.3s ease;
    }
    
    .action-card:hover .action-icon {
        transform: scale(1.1);
    }
    
    .activity-timeline {
        position: relative;
    }
    
    .activity-timeline::before {
        content: '';
        position: absolute;
        left: 15px;
        top: 0;
        bottom: 0;
        width: 2px;
        background: #e9ecef;
    }
    
    .activity-item:last-child .activity-content {
        border-bottom: none;
        padding-bottom: 0;
    }
    
    .activity-dot {
        width: 12px;
        height: 12px;
        border-radius: 50%;
        border: 3px solid white;
        box-shadow: 0 0 0 3px #007bff;
    }
    
    .activity-content {
        border-bottom: 1px solid #f8f9fa;
    }
    
    .system-status .status-item {
        border-bottom: 1px solid #f8f9fa;
    }
    
    .system-status .status-item:last-child {
        border-bottom: none;
    }
    
    .bg-gradient-primary {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    }
    
    .card {
        border: none;
        box-shadow: 0 2px 10px rgba(0,0,0,0.08);
        border-radius: 12px;
    }
</style>

@endsection