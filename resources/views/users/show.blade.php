@extends('layouts.app')

@section('title', $user->name . ' - User Activity Monitor')

@section('content')
<div class="container-fluid">
    <div class="row">
        @include('layouts.sidebar')
        
        <div class="col-md-9 ml-sm-auto col-lg-10 px-4 py-4">
            <!-- Header Section -->
            <div class="d-flex justify-content-between align-items-center mb-4">
                <div>
                    <h1 class="h3 mb-1 text-gradient-primary">User Profile</h1>
                    <p class="text-muted">Detailed information and activity for {{ $user->name }}</p>
                </div>
                <div class="btn-toolbar">
                    <a href="{{ route('users.edit', $user) }}" class="btn btn-warning me-2">
                        <i class="fas fa-edit me-2"></i> Edit User
                    </a>
                    <a href="{{ route('users.index') }}" class="btn btn-outline-secondary">
                        <i class="fas fa-arrow-left me-2"></i> Back to Users
                    </a>
                </div>
            </div>

            <div class="row">
                <!-- Left Column - Profile Info -->
                <div class="col-lg-4 mb-4">
                    <!-- Profile Card -->
                    <div class="card border-0 shadow-sm">
                        <div class="card-body text-center p-4">
                            <!-- Avatar -->
                            <div class="avatar-section mb-4">
                                @if($user->avatar)
                                    <img src="{{ Storage::disk('public')->url($user->avatar) }}" 
                                         alt="{{ $user->name }}" 
                                         class="avatar-profile rounded-circle">
                                @else
                                    <div class="avatar-placeholder-profile bg-primary bg-opacity-10 rounded-circle d-inline-flex align-items-center justify-content-center">
                                        <span class="text-primary fw-bold display-6">{{ strtoupper(substr($user->name, 0, 1)) }}</span>
                                    </div>
                                @endif
                            </div>
                            
                            <!-- User Info -->
                            <h3 class="mb-2">{{ $user->name }}</h3>
                            <p class="text-muted mb-3">{{ $user->email }}</p>
                            
                            <!-- Status Badges -->
                            <div class="status-badges mb-4">
                                <span class="badge role-badge bg-{{ $user->role === 'admin' ? 'primary' : 'secondary' }} me-2">
                                    <i class="fas fa-{{ $user->role === 'admin' ? 'crown' : 'user' }} me-1"></i>
                                    {{ ucfirst($user->role) }}
                                </span>
                                <span class="badge status-badge bg-{{ $user->is_active ? 'success' : 'danger' }}">
                                    <i class="fas fa-{{ $user->is_active ? 'check-circle' : 'times-circle' }} me-1"></i>
                                    {{ $user->is_active ? 'Active' : 'Inactive' }}
                                </span>
                            </div>

                            <!-- Quick Stats -->
                            <div class="quick-stats row text-center mb-4">
                                <div class="col-6">
                                    <div class="stat-item">
                                        <div class="stat-number text-primary">{{ $user->activity_logs_count }}</div>
                                        <small class="text-muted">Activities</small>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="stat-item">
                                        <div class="stat-number text-{{ $user->penalties_count > 0 ? 'warning' : 'muted' }}">{{ $user->penalties_count }}</div>
                                        <small class="text-muted">Penalties</small>
                                    </div>
                                </div>
                            </div>

                            <!-- Timeline Info -->
                            <div class="timeline-info">
                                <div class="timeline-item d-flex align-items-center mb-2">
                                    <i class="fas fa-calendar-plus text-success me-3"></i>
                                    <div>
                                        <small class="text-muted">Joined</small>
                                        <div class="fw-semibold">{{ $user->created_at->format('M d, Y') }}</div>
                                    </div>
                                </div>
                                <div class="timeline-item d-flex align-items-center mb-2">
                                    <i class="fas fa-sync-alt text-info me-3"></i>
                                    <div>
                                        <small class="text-muted">Last Updated</small>
                                        <div class="fw-semibold">{{ $user->updated_at->format('M d, Y') }}</div>
                                    </div>
                                </div>
                                @if($user->last_activity_at)
                                <div class="timeline-item d-flex align-items-center">
                                    <i class="fas fa-clock text-warning me-3"></i>
                                    <div>
                                        <small class="text-muted">Last Activity</small>
                                        <div class="fw-semibold">{{ $user->last_activity_at->diffForHumans() }}</div>
                                    </div>
                                </div>
                                @endif
                            </div>
                        </div>
                    </div>

                    <!-- System Info Card -->
                    <div class="card border-0 shadow-sm mt-4">
                        <div class="card-header bg-transparent border-0 py-3">
                            <h6 class="card-title mb-0 d-flex align-items-center">
                                <i class="fas fa-info-circle text-primary me-2"></i>
                                Account Information
                            </h6>
                        </div>
                        <div class="card-body">
                            <div class="info-list">
                                <div class="info-item d-flex justify-content-between py-2 border-bottom">
                                    <span class="text-muted">User ID</span>
                                    <span class="fw-semibold">#{{ $user->id }}</span>
                                </div>
                                <div class="info-item d-flex justify-content-between py-2 border-bottom">
                                    <span class="text-muted">Email Verified</span>
                                    <span class="badge bg-{{ $user->email_verified_at ? 'success' : 'warning' }}">
                                        {{ $user->email_verified_at ? 'Yes' : 'No' }}
                                    </span>
                                </div>
                                <div class="info-item d-flex justify-content-between py-2">
                                    <span class="text-muted">Account Status</span>
                                    <span class="badge bg-{{ $user->is_active ? 'success' : 'danger' }}">
                                        {{ $user->is_active ? 'Active' : 'Suspended' }}
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Right Column - Activities & Penalties -->
                <div class="col-lg-8">
                    <!-- Activities Card -->
                    <div class="card border-0 shadow-sm mb-4">
                        <div class="card-header bg-transparent border-0 py-3">
                            <h5 class="card-title mb-0 d-flex align-items-center">
                                <i class="fas fa-history text-primary me-2"></i>
                                Recent Activities
                                <span class="badge bg-primary ms-2">{{ $activities->count() }}</span>
                            </h5>
                        </div>
                        <div class="card-body">
                            @if($activities->count() > 0)
                                <div class="activity-timeline">
                                    @foreach($activities as $activity)
                                    <div class="activity-item d-flex">
                                        <div class="activity-marker">
                                            <div class="activity-dot bg-primary"></div>
                                        </div>
                                        <div class="activity-content flex-grow-1 ms-3 pb-3">
                                            <div class="d-flex justify-content-between align-items-start mb-1">
                                                <h6 class="mb-0">{{ $activity->description ?? 'Activity recorded' }}</h6>
                                                <small class="text-muted">{{ $activity->created_at->diffForHumans() }}</small>
                                            </div>
                                            <p class="text-muted mb-2 small">
                                                <i class="fas fa-globe me-1"></i>{{ $activity->ip_address ?? 'Unknown IP' }} • 
                                                <i class="fas fa-desktop me-1"></i>{{ $activity->browser ?? 'Unknown' }} on {{ $activity->platform ?? 'Unknown OS' }}
                                            </p>
                                            @if($activity->action)
                                            <span class="badge bg-light text-dark border">
                                                <i class="fas fa-tag me-1"></i>{{ $activity->action }}
                                            </span>
                                            @endif
                                        </div>
                                    </div>
                                    @endforeach
                                </div>
                            @else
                                <div class="text-center py-4">
                                    <i class="fas fa-history fa-3x text-muted mb-3"></i>
                                    <h5 class="text-muted">No Activities Yet</h5>
                                    <p class="text-muted">User activity will appear here once they start using the system.</p>
                                </div>
                            @endif
                        </div>
                    </div>

                    <!-- Penalties Card -->
                    <div class="card border-0 shadow-sm">
                        <div class="card-header bg-transparent border-0 py-3">
                            <h5 class="card-title mb-0 d-flex align-items-center">
                                <i class="fas fa-exclamation-triangle text-warning me-2"></i>
                                Penalty History
                                <span class="badge bg-{{ $penalties->count() > 0 ? 'warning' : 'secondary' }} ms-2">{{ $penalties->count() }}</span>
                            </h5>
                        </div>
                        <div class="card-body">
                            @if($penalties->count() > 0)
                                <div class="penalties-list">
                                    @foreach($penalties as $penalty)
                                    <div class="penalty-item card border-{{ $penalty->is_active ? 'warning' : 'muted' }} mb-3">
                                        <div class="card-body">
                                            <div class="d-flex justify-content-between align-items-start mb-2">
                                                <h6 class="card-title text-{{ $penalty->is_active ? 'danger' : 'muted' }} mb-0">
                                                    {{ $penalty->reason }}
                                                </h6>
                                                <span class="badge bg-{{ $penalty->is_active ? 'warning' : 'secondary' }}">
                                                    {{ $penalty->is_active ? 'Active' : 'Resolved' }}
                                                </span>
                                            </div>
                                            <p class="card-text text-muted mb-3">{{ $penalty->description }}</p>
                                            <div class="penalty-meta d-flex justify-content-between align-items-center">
                                                <div class="penalty-dates">
                                                    <small class="text-muted">
                                                        <i class="fas fa-calendar me-1"></i>
                                                        Issued: {{ $penalty->created_at->format('M d, Y') }}
                                                    </small>
                                                    @if($penalty->expires_at)
                                                    <small class="text-muted ms-3">
                                                        <i class="fas fa-clock me-1"></i>
                                                        Expires: {{ $penalty->expires_at->format('M d, Y') }}
                                                    </small>
                                                    @endif
                                                </div>
                                                <div class="penalty-stats">
                                                    <small class="text-muted me-3">
                                                        Count: {{ $penalty->penalty_count }}
                                                    </small>
                                                    @if(method_exists($penalty, 'getSeverityColor'))
                                                    <span class="badge bg-{{ $penalty->getSeverityColor() }}">
                                                        Level {{ $penalty->severity_level }}
                                                    </span>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    @endforeach
                                </div>
                            @else
                                <div class="text-center py-4">
                                    <i class="fas fa-check-circle fa-3x text-success mb-3"></i>
                                    <h5 class="text-success">No Penalties</h5>
                                    <p class="text-muted">This user has a clean record with no penalties.</p>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .text-gradient-primary {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
    }

    .card {
        border: none;
        border-radius: 12px;
        box-shadow: 0 2px 15px rgba(0,0,0,0.08);
    }

    .avatar-profile {
        width: 120px;
        height: 120px;
        object-fit: cover;
        border: 4px solid #f8f9fa;
        box-shadow: 0 4px 15px rgba(0,0,0,0.1);
    }

    .avatar-placeholder-profile {
        width: 120px;
        height: 120px;
        border: 4px solid #f8f9fa;
        box-shadow: 0 4px 15px rgba(0,0,0,0.1);
    }

    .status-badges .badge {
        font-size: 0.8rem;
        padding: 0.5rem 0.75rem;
        border-radius: 8px;
    }

    .quick-stats .stat-number {
        font-size: 1.5rem;
        font-weight: 700;
        line-height: 1.2;
    }

    .quick-stats .stat-item {
        padding: 0.5rem;
    }

    .timeline-info .timeline-item {
        padding: 0.5rem 0;
    }

    .timeline-info .timeline-item:not(:last-child) {
        border-bottom: 1px solid #f8f9fa;
    }

    .info-list .info-item {
        font-size: 0.9rem;
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

    .penalty-item {
        border-left: 4px solid;
        transition: all 0.3s ease;
    }

    .penalty-item:hover {
        transform: translateX(5px);
        box-shadow: 0 4px 12px rgba(0,0,0,0.1);
    }

    .penalty-meta {
        font-size: 0.85rem;
    }

    .btn {
        border-radius: 8px;
        padding: 0.75rem 1.5rem;
        font-weight: 500;
        transition: all 0.3s ease;
    }

    .btn-warning {
        background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);
        border: none;
        color: white;
    }

    .btn-warning:hover {
        transform: translateY(-2px);
        box-shadow: 0 5px 15px rgba(240, 147, 251, 0.4);
    }

    .badge {
        font-weight: 500;
        padding: 0.5rem 0.75rem;
        border-radius: 8px;
        font-size: 0.75rem;
    }

    .text-muted {
        color: #6c757d !important;
    }

    .fw-semibold {
        font-weight: 600;
    }

    @media (max-width: 768px) {
        .avatar-profile,
        .avatar-placeholder-profile {
            width: 100px;
            height: 100px;
        }
        
        .quick-stats .stat-number {
            font-size: 1.25rem;
        }
    }
</style>
@endsection