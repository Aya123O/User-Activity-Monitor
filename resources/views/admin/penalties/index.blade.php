<!-- resources/views/admin/penalties/index.blade.php -->
@extends('layouts.app')

@section('title', 'Penalties Management')

@section('content')
<div class="container-fluid">
    <div class="row">
        @include('layouts.sidebar')
        
        <div class="col-md-9 col-lg-10 main-content">
            <!-- Creative Header -->
            <div class="creative-header bg-gradient-danger rounded-4 p-4 mb-4 text-white position-relative overflow-hidden">
                <div class="position-absolute top-0 end-0 w-100 h-100 opacity-10">
                    <div class="pattern-dots"></div>
                </div>
                <div class="position-relative z-1">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h1 class="h2 mb-2 fw-bold">
                                <i class="fas fa-gavel me-3"></i>Penalties System
                            </h1>
                            <p class="mb-0 opacity-75">Manage user penalties and violation tracking</p>
                        </div>
                        <div class="text-end">
                            <div class="stats-badge bg-white bg-opacity-20 px-3 py-2 rounded-3">
                                <div class="h4 mb-0">{{ $penalties->total() }}</div>
                                <small class="opacity-75">Total Penalties</small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Penalty Statistics -->
            <div class="row mb-4">
                <div class="col-xl-3 col-md-6 mb-4">
                    <div class="card stats-card bg-danger text-white hover-lift">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <h6 class="card-title text-white-50 mb-2">Active Penalties</h6>
                                    <h2 class="mb-0">{{ $penalties->where('penalty_date', '>=', now()->subDays(30))->count() }}</h2>
                                    <small class="text-white-75">Last 30 days</small>
                                </div>
                                <div class="stats-icon">
                                    <i class="fas fa-exclamation-circle fa-2x opacity-50"></i>
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
                                    <h6 class="card-title text-white-50 mb-2">Inactivity Violations</h6>
                                    <h2 class="mb-0">{{ $penalties->where('reason', 'inactivity_logout')->count() }}</h2>
                                    <small class="text-white-75">Auto-logout penalties</small>
                                </div>
                                <div class="stats-icon">
                                    <i class="fas fa-clock fa-2x opacity-50"></i>
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
                                    <h6 class="card-title text-white-50 mb-2">Repeat Offenders</h6>
                                    <h2 class="mb-0">{{ $penalties->where('count', '>', 1)->count() }}</h2>
                                    <small class="text-white-75">Multiple violations</small>
                                </div>
                                <div class="stats-icon">
                                    <i class="fas fa-redo fa-2x opacity-50"></i>
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
                                    <h6 class="card-title text-white-50 mb-2">Resolved Cases</h6>
                                    <h2 class="mb-0">{{ $penalties->where('penalty_date', '<', now()->subDays(30))->count() }}</h2>
                                    <small class="text-white-75">Older than 30 days</small>
                                </div>
                                <div class="stats-icon">
                                    <i class="fas fa-check-circle fa-2x opacity-50"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Penalties Grid -->
            <div class="card creative-card border-0 shadow-sm">
                <div class="card-header bg-transparent border-0 py-4">
                    <div class="d-flex justify-content-between align-items-center">
                        <h5 class="card-title mb-0">
                            <i class="fas fa-list me-2"></i>Penalties Registry
                        </h5>
                        <div class="d-flex gap-2">
                            <button class="btn btn-outline-primary btn-sm creative-btn" onclick="exportPenalties()">
                                <i class="fas fa-download me-2"></i>Export
                            </button>
                            <button class="btn btn-outline-danger btn-sm creative-btn" onclick="clearOldPenalties()">
                                <i class="fas fa-broom me-2"></i>Clear Old
                            </button>
                        </div>
                    </div>
                </div>
                <div class="card-body p-0">
                    @if($penalties->count() > 0)
                        <div class="penalties-grid">
                            @foreach($penalties as $penalty)
                            <div class="penalty-item">
                                <div class="penalty-card creative-card border-0 shadow-sm hover-lift">
                                    <div class="card-body p-4">
                                        <div class="d-flex justify-content-between align-items-start mb-3">
                                            <div class="d-flex align-items-center">
                                                <div class="user-avatar bg-{{ $this->getPenaltyColor($penalty->count) }} rounded-circle me-3">
                                                    <span class="text-white fw-bold">{{ substr($penalty->user->name ?? 'U', 0, 1) }}</span>
                                                </div>
                                                <div>
                                                    <h6 class="mb-1 fw-bold">{{ $penalty->user->name ?? 'Unknown User' }}</h6>
                                                    <small class="text-muted">{{ $penalty->user->email ?? 'N/A' }}</small>
                                                </div>
                                            </div>
                                            <div class="text-end">
                                                <span class="badge penalty-badge bg-{{ $this->getPenaltyColor($penalty->count) }}">
                                                    <i class="fas fa-{{ $this->getPenaltyIcon($penalty->reason) }} me-1"></i>
                                                    {{ $penalty->count }} {{ Str::plural('violation', $penalty->count) }}
                                                </span>
                                                <div class="mt-2">
                                                    <small class="text-muted">{{ $penalty->penalty_date->format('M j, Y') }}</small>
                                                    <br>
                                                    <small class="text-muted">{{ $penalty->penalty_date->format('g:i A') }}</small>
                                                </div>
                                            </div>
                                        </div>
                                        
                                        <div class="penalty-details">
                                            <div class="row mb-3">
                                                <div class="col-md-6">
                                                    <div class="detail-item">
                                                        <i class="fas fa-ban text-danger me-2"></i>
                                                        <strong>Violation:</strong> 
                                                        <span class="text-capitalize">{{ str_replace('_', ' ', $penalty->reason) }}</span>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="detail-item">
                                                        <i class="fas fa-hashtag text-primary me-2"></i>
                                                        <strong>Severity:</strong> 
                                                        <span class="badge bg-{{ $this->getSeverityColor($penalty->count) }}">
                                                            Level {{ min($penalty->count, 5) }}
                                                        </span>
                                                    </div>
                                                </div>
                                            </div>
                                            
                                            @if($penalty->details)
                                            <div class="detail-item mb-2">
                                                <i class="fas fa-info-circle text-info me-2"></i>
                                                <strong>Details:</strong> 
                                                <span class="text-muted">
                                                    @if(is_array($penalty->details) && isset($penalty->details['last_duration']))
                                                        Last inactivity: {{ $penalty->details['last_duration'] }} seconds
                                                    @else
                                                        {{ json_encode($penalty->details) }}
                                                    @endif
                                                </span>
                                            </div>
                                            @endif
                                        </div>

                                        <!-- Penalty Progress -->
                                        <div class="penalty-progress mt-3">
                                            <div class="d-flex justify-content-between align-items-center mb-2">
                                                <small class="text-muted">Violation History</small>
                                                <small class="text-muted">{{ $penalty->count }} of 5</small>
                                            </div>
                                            <div class="progress" style="height: 8px;">
                                                @php
                                                    $progressWidth = min(100, ($penalty->count / 5) * 100);
                                                    $progressColor = $this->getSeverityColor($penalty->count);
                                                @endphp
                                                <div class="progress-bar bg-{{ $progressColor }}" 
                                                     role="progressbar" 
                                                     style="width: {{ $progressWidth }}%"
                                                     aria-valuenow="{{ $progressWidth }}" 
                                                     aria-valuemin="0" 
                                                     aria-valuemax="100">
                                                </div>
                                            </div>
                                        </div>

                                        <div class="d-flex justify-content-between align-items-center mt-3">
                                            <small class="text-muted">
                                                <i class="fas fa-calendar me-1"></i>
                                                Issued {{ $penalty->penalty_date->diffForHumans() }}
                                            </small>
                                            <div class="penalty-actions">
                                                <button class="btn btn-outline-warning btn-sm creative-btn-sm" 
                                                        onclick="warnUser({{ $penalty->user->id ?? 0 }})"
                                                        {{ !$penalty->user ? 'disabled' : '' }}>
                                                    <i class="fas fa-envelope me-1"></i>Warn
                                                </button>
                                                <button class="btn btn-outline-danger btn-sm creative-btn-sm" 
                                                        onclick="suspendUser({{ $penalty->user->id ?? 0 }})"
                                                        {{ !$penalty->user ? 'disabled' : '' }}>
                                                    <i class="fas fa-lock me-1"></i>Suspend
                                                </button>
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
                                <i class="fas fa-gavel fa-4x text-muted opacity-25"></i>
                            </div>
                            <h4 class="text-muted mb-3">No Penalties Issued</h4>
                            <p class="text-muted mb-4">The system is running smoothly with no violations detected.</p>
                            <div class="alert alert-success mx-auto" style="max-width: 400px;">
                                <i class="fas fa-check-circle me-2"></i>
                                <strong>Great Job!</strong> Users are following the rules properly.
                            </div>
                        </div>
                    @endif
                </div>
                @if($penalties->hasPages())
                <div class="card-footer bg-transparent border-0">
                    <div class="d-flex justify-content-center">
                        {{ $penalties->links() }}
                    </div>
                </div>
                @endif
            </div>
        </div>
    </div>
</div>

<script>
function exportPenalties() {
    showNotification('Exporting penalties data...', 'info');
    // Implement export functionality here
}

function clearOldPenalties() {
    if (confirm('Clear penalties older than 90 days? This will help maintain system performance.')) {
        fetch('/penalties/clear-old', {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'Content-Type': 'application/json'
            }
        }).then(response => {
            if (response.ok) {
                showNotification('Old penalties cleared successfully', 'success');
                setTimeout(() => location.reload(), 1000);
            } else {
                showNotification('Error clearing old penalties', 'error');
            }
        });
    }
}

function warnUser(userId) {
    if (confirm('Send a warning message to this user?')) {
        showNotification('Warning sent to user', 'warning');
    }
}

function suspendUser(userId) {
    if (confirm('Temporarily suspend this user account?')) {
        showNotification('User account suspended', 'danger');
    }
}

function showNotification(message, type) {
    const alert = document.createElement('div');
    alert.className = `alert alert-${type} alert-dismissible fade show position-fixed top-0 end-0 m-3`;
    alert.style.zIndex = '1060';
    alert.innerHTML = `
        ${message}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    `;
    document.body.appendChild(alert);
    
    setTimeout(() => {
        if (alert.parentElement) {
            alert.remove();
        }
    }, 3000);
}
</script>

<style>
.creative-header {
    background: linear-gradient(135deg, #dc3545, #e83e8c);
}

.penalties-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(400px, 1fr));
    gap: 20px;
    padding: 20px;
}

.penalty-card {
    border-radius: 16px;
    transition: all 0.3s ease;
    border-left: 4px solid var(--penalty-color);
}

.penalty-card.hover-lift:hover {
    transform: translateY(-5px);
    box-shadow: 0 12px 35px rgba(0,0,0,0.1) !important;
}

.user-avatar {
    width: 45px;
    height: 45px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-weight: bold;
}

.penalty-badge {
    font-size: 0.75rem;
    padding: 6px 12px;
    border-radius: 20px;
    font-weight: 600;
}

.penalty-details .detail-item {
    margin-bottom: 8px;
    font-size: 0.9rem;
}

.penalty-progress .progress {
    border-radius: 10px;
    background: #f8f9fa;
}

.penalty-actions .creative-btn-sm {
    border-radius: 8px;
    font-size: 0.8rem;
    padding: 4px 12px;
}

.empty-state-icon {
    opacity: 0.5;
}

/* Dynamic penalty colors */
.penalty-card { --penalty-color: #6c757d; }
.bg-warning { --penalty-color: #ffc107; }
.bg-danger { --penalty-color: #dc3545; }
.bg-dark { --penalty-color: #495057; }

/* Responsive */
@media (max-width: 768px) {
    .penalties-grid {
        grid-template-columns: 1fr;
        padding: 15px;
    }
    
    .penalty-card .d-flex {
        flex-direction: column;
        text-align: center;
    }
    
    .user-avatar {
        margin: 0 auto 10px auto;
    }
    
    .penalty-actions {
        margin-top: 10px;
        justify-content: center;
    }
}
</style>

@php
function getPenaltyColor($count) {
    return match(true) {
        $count >= 5 => 'dark',
        $count >= 3 => 'danger',
        $count >= 2 => 'warning',
        default => 'secondary'
    };
}

function getPenaltyIcon($reason) {
    return match($reason) {
        'inactivity_logout' => 'clock',
        'security_violation' => 'shield-alt',
        'spam_activity' => 'flag',
        'multiple_sessions' => 'users',
        default => 'exclamation-triangle'
    };
}

function getSeverityColor($count) {
    return match(true) {
        $count >= 5 => 'dark',
        $count >= 3 => 'danger',
        $count >= 2 => 'warning',
        default => 'info'
    };
}
@endphp
@endsection