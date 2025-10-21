@extends('layouts.app')

@section('title', 'Activity Details')

@section('content')
<div class="container-fluid">
    <div class="row">
        @include('layouts.sidebar')
        
        <div class="col-md-9 col-lg-10 main-content">
            <!-- Creative Header -->
            <div class="creative-header bg-gradient-{{ getActionColor($activityLog->action) }} rounded-4 p-4 mb-4 text-white position-relative overflow-hidden">
                <div class="position-absolute top-0 end-0 w-100 h-100 opacity-10">
                    <div class="pattern-dots"></div>
                </div>
                <div class="position-relative z-1">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <nav aria-label="breadcrumb" class="mb-2">
                                <ol class="breadcrumb breadcrumb-light">
                                    <li class="breadcrumb-item"><a href="{{ route('activity-logs.index') }}" class="text-white-50">Activity Timeline</a></li>
                                    <li class="breadcrumb-item active text-white">Log #{{ $activityLog->id }}</li>
                                </ol>
                            </nav>
                            <h1 class="h2 mb-2 fw-bold">
                                <i class="fas fa-{{ getActionIcon($activityLog->action) }} me-3"></i>Activity Details
                            </h1>
                            <p class="mb-0 opacity-75">Complete information about this user activity</p>
                        </div>
                        <div class="text-end">
                            <div class="stats-badge bg-white bg-opacity-20 px-3 py-2 rounded-3">
                                <div class="h4 mb-0">#{{ $activityLog->id }}</div>
                                <small class="opacity-75">Activity ID</small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Action Ribbon -->
            <div class="row mb-4">
                <div class="col-12">
                    <div class="card creative-card border-0 shadow-sm">
                        <div class="card-body p-4">
                            <div class="row align-items-center">
                                <div class="col-md-8">
                                    <div class="d-flex align-items-center">
                                        <div class="action-icon-large bg-{{ getActionColor($activityLog->action) }} rounded-3 p-3 me-4">
                                            <i class="fas fa-{{ getActionIcon($activityLog->action) }} fa-2x text-white"></i>
                                        </div>
                                        <div>
                                            <h4 class="mb-1 fw-bold">{{ ucfirst($activityLog->action) }} Action</h4>
                                            <p class="text-muted mb-0">{{ $activityLog->description }}</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4 text-md-end">
                                    <div class="mt-3 mt-md-0">
                                        <div class="h5 mb-1">{{ $activityLog->created_at->format('F j, Y') }}</div>
                                        <div class="text-muted">{{ $activityLog->created_at->format('g:i A') }}</div>
                                        <small class="text-muted">{{ $activityLog->created_at->diffForHumans() }}</small>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Details Grid -->
            <div class="row">
                <!-- User Information -->
                <div class="col-lg-4 mb-4">
                    <div class="card creative-card border-0 shadow-sm h-100">
                        <div class="card-header bg-transparent border-0 pb-0">
                            <h5 class="card-title">
                                <i class="fas fa-user me-2"></i>User Profile
                            </h5>
                        </div>
                        <div class="card-body text-center">
                            @if($activityLog->user)
                            <div class="user-avatar-large bg-gradient-{{ getActionColor($activityLog->action) }} rounded-circle mx-auto mb-4">
                                <span class="text-white fw-bold fs-2">{{ substr($activityLog->user->name, 0, 1) }}</span>
                            </div>
                            <h4 class="mb-2">{{ $activityLog->user->name }}</h4>
                            <p class="text-muted mb-3">{{ $activityLog->user->email }}</p>
                            
                            <div class="user-badges mb-4">
                                <span class="badge bg-primary rounded-pill px-3 py-2 me-2">
                                    {{ ucfirst($activityLog->user->role) }}
                                </span>
                                <span class="badge bg-{{ $activityLog->user->is_active ? 'success' : 'danger' }} rounded-pill px-3 py-2">
                                    {{ $activityLog->user->is_active ? 'Active' : 'Inactive' }}
                                </span>
                            </div>

                            <div class="user-stats">
                                <div class="row text-center">
                                    <div class="col-6 border-end">
                                        <div class="h5 mb-1 text-primary">{{ $activityLog->user->activityLogs()->count() }}</div>
                                        <small class="text-muted">Activities</small>
                                    </div>
                                    <div class="col-6">
                                        <div class="h5 mb-1 text-success">
                                            {{ $activityLog->user->created_at->diffInDays(now()) }}
                                        </div>
                                        <small class="text-muted">Days Active</small>
                                    </div>
                                </div>
                            </div>
                            @else
                            <div class="text-center py-4">
                                <div class="empty-user-icon mb-3">
                                    <i class="fas fa-user-slash fa-3x text-muted opacity-25"></i>
                                </div>
                                <h5 class="text-muted">User Not Found</h5>
                                <p class="text-muted mb-0">This user account may have been deleted</p>
                            </div>
                            @endif
                        </div>
                    </div>
                </div>

                <!-- Activity Details -->
                <div class="col-lg-8">
                    <div class="row">
                        <!-- Technical Information -->
                        <div class="col-12 mb-4">
                            <div class="card creative-card border-0 shadow-sm">
                                <div class="card-header bg-transparent border-0">
                                    <h5 class="card-title">
                                        <i class="fas fa-microchip me-2"></i>Technical Details
                                    </h5>
                                </div>
                                <div class="card-body">
                                    <div class="row g-3">
                                        <div class="col-md-6">
                                            <label class="form-label fw-semibold text-muted">IP Address</label>
                                            <div class="detail-box bg-light rounded-3 p-3">
                                                <div class="d-flex align-items-center">
                                                    <i class="fas fa-network-wired text-primary me-3"></i>
                                                    <code class="text-dark">{{ $activityLog->ip_address }}</code>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <label class="form-label fw-semibold text-muted">HTTP Method</label>
                                            <div class="detail-box bg-light rounded-3 p-3">
                                                <div class="d-flex align-items-center">
                                                    <i class="fas fa-code text-info me-3"></i>
                                                    <span class="text-dark fw-bold">{{ $activityLog->method }}</span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <label class="form-label fw-semibold text-muted">Browser</label>
                                            <div class="detail-box bg-light rounded-3 p-3">
                                                <div class="d-flex align-items-center">
                                                    <i class="fas fa-globe text-success me-3"></i>
                                                    <span class="text-dark">{{ $activityLog->browser ?? 'Unknown' }}</span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <label class="form-label fw-semibold text-muted">Platform</label>
                                            <div class="detail-box bg-light rounded-3 p-3">
                                                <div class="d-flex align-items-center">
                                                    <i class="fas fa-desktop text-warning me-3"></i>
                                                    <span class="text-dark">{{ $activityLog->platform ?? 'Unknown' }}</span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-12">
                                            <label class="form-label fw-semibold text-muted">User Agent</label>
                                            <div class="detail-box bg-light rounded-3 p-3">
                                                <code class="text-muted small">{{ $activityLog->user_agent }}</code>
                                            </div>
                                        </div>
                                        <div class="col-12">
                                            <label class="form-label fw-semibold text-muted">URL</label>
                                            <div class="detail-box bg-light rounded-3 p-3">
                                                <div class="d-flex align-items-center">
                                                    <i class="fas fa-link text-primary me-3"></i>
                                                    <span class="text-dark">{{ $activityLog->url }}</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Model Information -->
                        @if($activityLog->model_type)
                        <div class="col-12">
                            <div class="card creative-card border-0 shadow-sm">
                                <div class="card-header bg-transparent border-0">
                                    <h5 class="card-title">
                                        <i class="fas fa-database me-2"></i>Related Data
                                    </h5>
                                </div>
                                <div class="card-body">
                                    <div class="row g-3">
                                        <div class="col-md-6">
                                            <label class="form-label fw-semibold text-muted">Model Type</label>
                                            <div class="detail-box bg-light rounded-3 p-3">
                                                <div class="d-flex align-items-center">
                                                    <i class="fas fa-table text-info me-3"></i>
                                                    <span class="text-dark">{{ class_basename($activityLog->model_type) }}</span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <label class="form-label fw-semibold text-muted">Model ID</label>
                                            <div class="detail-box bg-light rounded-3 p-3">
                                                <div class="d-flex align-items-center">
                                                    <i class="fas fa-hashtag text-primary me-3"></i>
                                                    <span class="text-dark">#{{ $activityLog->model_id }}</span>
                                                </div>
                                            </div>
                                        </div>
                                        @if($activityLog->old_values)
                                        <div class="col-12">
                                            <label class="form-label fw-semibold text-muted">Previous Values</label>
                                            <div class="detail-box bg-light rounded-3 p-3">
                                                <pre class="mb-0 small"><code>{{ json_encode($activityLog->old_values, JSON_PRETTY_PRINT) }}</code></pre>
                                            </div>
                                        </div>
                                        @endif
                                        @if($activityLog->new_values)
                                        <div class="col-12">
                                            <label class="form-label fw-semibold text-muted">New Values</label>
                                            <div class="detail-box bg-light rounded-3 p-3">
                                                <pre class="mb-0 small"><code>{{ json_encode($activityLog->new_values, JSON_PRETTY_PRINT) }}</code></pre>
                                            </div>
                                        </div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Action Buttons -->
            <div class="row mt-4">
                <div class="col-12">
                    <div class="card creative-card border-0 shadow-sm">
                        <div class="card-body p-4">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <h6 class="mb-1">Activity Management</h6>
                                    <p class="text-muted mb-0">Manage this activity log entry</p>
                                </div>
                                <div class="d-flex gap-2">
                                    <a href="{{ route('activity-logs.index') }}" class="btn btn-outline-secondary creative-btn">
                                        <i class="fas fa-arrow-left me-2"></i>Back to Timeline
                                    </a>
                                    <button type="button" class="btn btn-outline-danger creative-btn" onclick="deleteActivity({{ $activityLog->id }})">
                                        <i class="fas fa-trash me-2"></i>Delete Log
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
function deleteActivity(activityId) {
    if (confirm('Are you sure you want to delete this activity log? This action cannot be undone.')) {
        fetch(`/activity-logs/${activityId}`, {
            method: 'DELETE',
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'Content-Type': 'application/json'
            }
        }).then(response => {
            if (response.ok) {
                window.location.href = '{{ route('activity-logs.index') }}';
            } else {
                alert('Error deleting activity log');
            }
        });
    }
}
</script>

<style>
.creative-header {
    background: linear-gradient(135deg, var(--gradient-start), var(--gradient-end));
}

.pattern-dots {
    background-image: radial-gradient(#fff 1px, transparent 1px);
    background-size: 20px 20px;
    height: 100%;
}

.stats-badge {
    backdrop-filter: blur(10px);
}

.creative-card {
    border-radius: 16px;
    transition: all 0.3s ease;
}

.breadcrumb-light .breadcrumb-item.active {
    color: #fff;
}

.breadcrumb-light .breadcrumb-item a {
    color: rgba(255,255,255,0.8);
    text-decoration: none;
}

.breadcrumb-light .breadcrumb-item a:hover {
    color: #fff;
}

.action-icon-large {
    box-shadow: 0 8px 25px rgba(0,0,0,0.15);
}

.user-avatar-large {
    width: 100px;
    height: 100px;
    display: flex;
    align-items: center;
    justify-content: center;
    box-shadow: 0 8px 25px rgba(0,0,0,0.15);
}

.user-badges .badge {
    font-size: 0.8rem;
}

.detail-box {
    border: 1px solid #f1f3f4;
}

.creative-btn {
    border-radius: 12px;
    font-weight: 600;
    transition: all 0.3s ease;
}

.creative-btn:hover {
    transform: translateY(-2px);
}

.empty-user-icon {
    opacity: 0.5;
}

/* Dynamic gradient colors based on action */
:root {
    --gradient-start: #667eea;
    --gradient-end: #764ba2;
}

.bg-gradient-success { --gradient-start: #28a745; --gradient-end: #20c997; }
.bg-gradient-secondary { --gradient-start: #6c757d; --gradient-end: #adb5bd; }
.bg-gradient-primary { --gradient-start: #007bff; --gradient-end: #6f42c1; }
.bg-gradient-info { --gradient-start: #17a2b8; --gradient-end: #20c997; }
.bg-gradient-warning { --gradient-start: #ffc107; --gradient-end: #fd7e14; }
.bg-gradient-danger { --gradient-start: #dc3545; --gradient-end: #e83e8c; }
</style>

@php
function getActionColor($action) {
    return match($action) {
        'login' => 'success',
        'logout' => 'secondary',
        'create' => 'primary',
        'read' => 'info',
        'update' => 'warning',
        'delete' => 'danger',
        'upload' => 'success',
        'download' => 'primary',
        default => 'secondary'
    };
}

function getActionIcon($action) {
    return match($action) {
        'login' => 'sign-in-alt',
        'logout' => 'sign-out-alt',
        'create' => 'plus-circle',
        'read' => 'eye',
        'update' => 'edit',
        'delete' => 'trash-alt',
        'upload' => 'cloud-upload-alt',
        'download' => 'cloud-download-alt',
        default => 'circle'
    };
}
@endphp
@endsection