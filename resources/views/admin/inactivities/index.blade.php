<!-- resources/views/admin/inactivities/index.blade.php -->
@extends('layouts.app')

@section('title', 'Inactivity Logs')

@section('content')
<div class="container-fluid">
    <div class="row">
        @include('layouts.sidebar')
        
        <div class="col-md-9 col-lg-10 main-content">
            <!-- Creative Header -->
            <div class="creative-header bg-gradient-warning rounded-4 p-4 mb-4 text-white position-relative overflow-hidden">
                <div class="position-absolute top-0 end-0 w-100 h-100 opacity-10">
                    <div class="pattern-dots"></div>
                </div>
                <div class="position-relative z-1">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h1 class="h2 mb-2 fw-bold">
                                <i class="fas fa-clock me-3"></i>Inactivity Monitor
                            </h1>
                            <p class="mb-0 opacity-75">Track user inactivity sessions and automatic warnings</p>
                        </div>
                        <div class="text-end">
                            <div class="stats-badge bg-white bg-opacity-20 px-3 py-2 rounded-3">
                                <div class="h4 mb-0">{{ $inactivities->total() }}</div>
                                <small class="opacity-75">Total Sessions</small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Summary Cards -->
            <div class="row mb-4">
                <div class="col-xl-3 col-md-6 mb-4">
                    <div class="card stats-card bg-primary text-white hover-lift">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <h6 class="card-title text-white-50 mb-2">Alert Sessions</h6>
                                    <h2 class="mb-0">{{ $inactivities->where('type', 'alert')->count() }}</h2>
                                    <small class="text-white-75">First warnings</small>
                                </div>
                                <div class="stats-icon">
                                    <i class="fas fa-bell fa-2x opacity-50"></i>
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
                                    <h6 class="card-title text-white-50 mb-2">Warning Sessions</h6>
                                    <h2 class="mb-0">{{ $inactivities->where('type', 'warning')->count() }}</h2>
                                    <small class="text-white-75">Second warnings</small>
                                </div>
                                <div class="stats-icon">
                                    <i class="fas fa-exclamation-triangle fa-2x opacity-50"></i>
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
                                    <h6 class="card-title text-white-50 mb-2">Auto Logouts</h6>
                                    <h2 class="mb-0">{{ $inactivities->where('type', 'logout')->count() }}</h2>
                                    <small class="text-white-75">System logouts</small>
                                </div>
                                <div class="stats-icon">
                                    <i class="fas fa-sign-out-alt fa-2x opacity-50"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="col-xl-3 col-md-6 mb-4">
                    <div class="card stats-card bg-info text-white hover-lift">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <h6 class="card-title text-white-50 mb-2">Today's Sessions</h6>
                                    <h2 class="mb-0">{{ $inactivities->where('created_at', '>=', today())->count() }}</h2>
                                    <small class="text-white-75">Last 24 hours</small>
                                </div>
                                <div class="stats-icon">
                                    <i class="fas fa-calendar-day fa-2x opacity-50"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Inactivity Sessions Timeline -->
            <div class="card creative-card border-0 shadow-sm">
                <div class="card-header bg-transparent border-0 py-4">
                    <h5 class="card-title mb-0">
                        <i class="fas fa-list me-2"></i>Inactivity Sessions Timeline
                    </h5>
                </div>
                <div class="card-body p-0">
                    @if($inactivities->count() > 0)
                        <div class="inactivity-timeline">
                            @foreach($inactivities as $inactivity)
                            <div class="inactivity-item">
                                <div class="inactivity-marker">
                                    <div class="marker-dot {{ $inactivity->type }}-dot">
                                        <i class="fas fa-{{ getInactivityIcon($inactivity->type) }}"></i>
                                    </div>
                                </div>
                                <div class="inactivity-card creative-card border-0 shadow-sm hover-lift">
                                    <div class="card-body p-4">
                                        <div class="d-flex justify-content-between align-items-start mb-3">
                                            <div class="d-flex align-items-center">
                                                <div class="user-avatar bg-{{ getInactivityColor($inactivity->type) }} rounded-circle me-3">
                                                    <span class="text-white fw-bold">{{ substr($inactivity->user->name ?? 'U', 0, 1) }}</span>
                                                </div>
                                                <div>
                                                    <h6 class="mb-1 fw-bold">{{ $inactivity->user->name ?? 'Unknown User' }}</h6>
                                                    <small class="text-muted">{{ $inactivity->user->email ?? 'N/A' }}</small>
                                                </div>
                                            </div>
                                            <div class="text-end">
                                                <span class="badge inactivity-badge bg-{{ getInactivityColor($inactivity->type) }}">
                                                    <i class="fas fa-{{ getInactivityIcon($inactivity->type) }} me-1"></i>
                                                    {{ ucfirst($inactivity->type) }}
                                                </span>
                                                <div class="mt-2">
                                                    <small class="text-muted">{{ $inactivity->triggered_at->format('M j, Y') }}</small>
                                                    <br>
                                                    <small class="text-muted">{{ $inactivity->triggered_at->format('g:i A') }}</small>
                                                </div>
                                            </div>
                                        </div>
                                        
                                        <div class="inactivity-details">
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="detail-item">
                                                        <i class="fas fa-stopwatch text-primary me-2"></i>
                                                        <strong>Duration:</strong> 
                                                        <span class="text-warning fw-bold">{{ $inactivity->idle_duration }} seconds</span>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="detail-item">
                                                        <i class="fas fa-info-circle text-info me-2"></i>
                                                        <strong>Status:</strong> 
                                                        <span class="text-capitalize">{{ $inactivity->type }}</span>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="mt-2">
                                                <div class="detail-item">
                                                    <i class="fas fa-comment text-muted me-2"></i>
                                                    <strong>Reason:</strong> 
                                                    <span class="text-muted">{{ $inactivity->reason }}</span>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="progress mt-3" style="height: 8px;">
                                            @php
                                                $progressWidth = min(100, ($inactivity->idle_duration / 15) * 100);
                                                $progressColor = match($inactivity->type) {
                                                    'alert' => 'warning',
                                                    'warning' => 'danger',
                                                    'logout' => 'dark',
                                                    default => 'secondary'
                                                };
                                            @endphp
                                            <div class="progress-bar bg-{{ $progressColor }}" 
                                                 role="progressbar" 
                                                 style="width: {{ $progressWidth }}%"
                                                 aria-valuenow="{{ $progressWidth }}" 
                                                 aria-valuemin="0" 
                                                 aria-valuemax="100">
                                            </div>
                                        </div>

                                        <div class="d-flex justify-content-between align-items-center mt-3">
                                            <small class="text-muted">
                                                <i class="fas fa-clock me-1"></i>
                                                {{ $inactivity->created_at->diffForHumans() }}
                                            </small>
                                            <div class="session-indicator">
                                                <span class="badge bg-light text-dark border">
                                                    <i class="fas fa-user-clock me-1"></i>
                                                    Session #{{ $inactivity->id }}
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    @else
                        <div class="text-center py-5">
                            <div class="empty-state-icon mb-4">
                                <i class="fas fa-clock fa-4x text-muted opacity-25"></i>
                            </div>
                            <h4 class="text-muted mb-3">No Inactivity Sessions</h4>
                            <p class="text-muted mb-4">Inactivity sessions will appear here when users remain idle.</p>
                            <div class="alert alert-info mx-auto" style="max-width: 400px;">
                                <i class="fas fa-info-circle me-2"></i>
                                <strong>System is Active!</strong> No users have triggered inactivity warnings yet.
                            </div>
                        </div>
                    @endif
                </div>
                @if($inactivities->hasPages())
                <div class="card-footer bg-transparent border-0">
                    <div class="d-flex justify-content-center">
                        {{ $inactivities->links() }}
                    </div>
                </div>
                @endif
            </div>
        </div>
    </div>
</div>

<style>
.creative-header {
    background: linear-gradient(135deg, #ffc107, #fd7e14);
}

.stats-card {
    border: none;
    border-radius: 16px;
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
    box-shadow: 0 10px 25px rgba(0,0,0,0.15);
}

.inactivity-timeline {
    position: relative;
    padding: 20px 0;
}

.inactivity-item {
    display: flex;
    margin-bottom: 30px;
    position: relative;
}

.inactivity-marker {
    position: absolute;
    left: 30px;
    top: 0;
    z-index: 2;
}

.marker-dot {
    width: 50px;
    height: 50px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
    font-size: 1.1rem;
    box-shadow: 0 4px 15px rgba(0,0,0,0.1);
    border: 4px solid white;
}

.alert-dot { background: linear-gradient(135deg, #ffc107, #fd7e14); }
.warning-dot { background: linear-gradient(135deg, #dc3545, #e83e8c); }
.logout-dot { background: linear-gradient(135deg, #6c757d, #495057); }

.inactivity-card {
    margin-left: 80px;
    border-radius: 16px;
    transition: all 0.3s ease;
}

.inactivity-card.hover-lift:hover {
    transform: translateY(-3px);
    box-shadow: 0 8px 25px rgba(0,0,0,0.1) !important;
}

.user-avatar {
    width: 45px;
    height: 45px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-weight: bold;
}

.inactivity-badge {
    font-size: 0.75rem;
    padding: 6px 12px;
    border-radius: 20px;
    font-weight: 600;
}

.inactivity-details .detail-item {
    margin-bottom: 5px;
    font-size: 0.9rem;
}

.progress {
    border-radius: 10px;
    background: #f8f9fa;
}

.empty-state-icon {
    opacity: 0.5;
}

/* Responsive */
@media (max-width: 768px) {
    .inactivity-item {
        flex-direction: column;
    }
    
    .inactivity-marker {
        position: relative;
        left: 0;
        margin-bottom: 15px;
        display: flex;
        justify-content: center;
    }
    
    .inactivity-card {
        margin-left: 0;
    }
    
    .stats-card .d-flex {
        flex-direction: column;
        text-align: center;
    }
    
    .stats-icon {
        margin-top: 10px;
        margin-left: 0 !important;
    }
}
</style>

@php
function getInactivityColor($type) {
    return match($type) {
        'alert' => 'warning',
        'warning' => 'danger',
        'logout' => 'dark',
        default => 'secondary'
    };
}

function getInactivityIcon($type) {
    return match($type) {
        'alert' => 'bell',
        'warning' => 'exclamation-triangle',
        'logout' => 'sign-out-alt',
        default => 'clock'
    };
}
@endphp
@endsection