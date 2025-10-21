@extends('layouts.app')

@section('title', 'Activity Logs')

@section('content')
<div class="container-fluid">
    <div class="row">
        @include('layouts.sidebar')
        
        <div class="col-md-9 col-lg-10 main-content">
            <!-- Creative Header -->
            <div class="creative-header bg-gradient-primary rounded-4 p-4 mb-4 text-white position-relative overflow-hidden">
                <div class="position-absolute top-0 end-0 w-100 h-100 opacity-10">
                    <div class="pattern-dots"></div>
                </div>
                <div class="position-relative z-1">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h1 class="h2 mb-2 fw-bold">
                                <i class="fas fa-history me-3"></i>Activity Timeline
                            </h1>
                            <p class="mb-0 opacity-75">Track every user interaction in real-time</p>
                        </div>
                        <div class="text-end">
                            <div class="stats-badge bg-white bg-opacity-20 px-3 py-2 rounded-3">
                                <div class="h4 mb-0">{{ $activities->total() }}</div>
                                <small class="opacity-75">Total Activities</small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Quick Actions -->
            <div class="row mb-4">
                <div class="col-12">
                    <div class="card creative-card border-0 shadow-sm">
                        <div class="card-body p-3">
                            <div class="d-flex justify-content-between align-items-center">
                                <div class="d-flex gap-2">
                                    <button class="btn btn-primary btn-sm creative-btn" onclick="refreshLogs()">
                                        <i class="fas fa-sync me-2"></i>Refresh Timeline
                                    </button>
                                    <button class="btn btn-outline-danger btn-sm creative-btn" onclick="clearOldLogs()">
                                        <i class="fas fa-broom me-2"></i>Clear Old Logs
                                    </button>
                                </div>
                                <div class="text-muted">
                                    <i class="fas fa-clock me-1"></i>
                                    Updated: <span id="last-updated">{{ now()->format('g:i A') }}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Activity Timeline -->
            <div class="creative-timeline">
                @if($activities->count() > 0)
                    @foreach($activities as $index => $activity)
                    <div class="timeline-item {{ $index % 2 === 0 ? 'left' : 'right' }}">
                        <div class="timeline-marker">
                            <div class="marker-dot {{ $activity->action }}-dot">
                                <i class="fas fa-{{ getActionIcon($activity->action) }}"></i>
                            </div>
                            <div class="marker-line"></div>
                        </div>
                        <div class="timeline-card creative-card border-0 shadow-sm hover-lift">
                            <div class="card-body p-4">
                                <div class="d-flex justify-content-between align-items-start mb-3">
                                    <div class="d-flex align-items-center">
                                        <div class="user-avatar bg-gradient-{{ getActionColor($activity->action) }} rounded-circle me-3">
                                            <span class="text-white fw-bold">{{ substr($activity->user->name ?? 'U', 0, 1) }}</span>
                                        </div>
                                        <div>
                                            <h6 class="mb-1 fw-bold">{{ $activity->user->name ?? 'Unknown User' }}</h6>
                                            <small class="text-muted">{{ $activity->user->email ?? 'N/A' }}</small>
                                        </div>
                                    </div>
                                    <div class="text-end">
                                        <span class="badge action-badge bg-{{ getActionColor($activity->action) }}">
                                            {{ ucfirst($activity->action) }}
                                        </span>
                                        <div class="mt-2">
                                            <small class="text-muted">{{ $activity->created_at->format('M j, Y') }}</small>
                                            <br>
                                            <small class="text-muted">{{ $activity->created_at->format('g:i A') }}</small>
                                        </div>
                                    </div>
                                </div>
                                
                                <p class="mb-3 text-dark">{{ $activity->description }}</p>
                                
                                <div class="activity-meta d-flex flex-wrap gap-2 mb-3">
                                    <span class="meta-item">
                                        <i class="fas fa-globe me-1"></i>
                                        {{ $activity->browser ?? 'Unknown' }}
                                    </span>
                                    <span class="meta-item">
                                        <i class="fas fa-desktop me-1"></i>
                                        {{ $activity->platform ?? 'Unknown' }}
                                    </span>
                                    <span class="meta-item">
                                        <i class="fas fa-network-wired me-1"></i>
                                        {{ $activity->ip_address }}
                                    </span>
                                    @if($activity->model_type)
                                    <span class="meta-item">
                                        <i class="fas fa-database me-1"></i>
                                        {{ class_basename($activity->model_type) }}
                                    </span>
                                    @endif
                                </div>

                                <div class="d-flex justify-content-between align-items-center">
                                    <small class="text-muted">
                                        <i class="fas fa-clock me-1"></i>
                                        {{ $activity->created_at->diffForHumans() }}
                                    </small>
                                    <div class="btn-group btn-group-sm">
                                        <a href="{{ route('activity-logs.show', $activity->id) }}" 
                                           class="btn btn-outline-primary creative-btn-sm">
                                            <i class="fas fa-eye me-1"></i>Details
                                        </a>
                                        <button type="button" 
                                                class="btn btn-outline-danger creative-btn-sm" 
                                                onclick="deleteActivity({{ $activity->id }})">
                                            <i class="fas fa-trash me-1"></i>Delete
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endforeach
                @else
                    <!-- Empty State -->
                    <div class="text-center py-5">
                        <div class="empty-state-icon mb-4">
                            <i class="fas fa-history fa-4x text-muted opacity-25"></i>
                        </div>
                        <h4 class="text-muted mb-3">No Activities Yet</h4>
                        <p class="text-muted mb-4">User activities will appear here as they interact with the system.</p>
                        <button class="btn btn-primary creative-btn" onclick="refreshLogs()">
                            <i class="fas fa-sync me-2"></i>Check for New Activities
                        </button>
                    </div>
                @endif
            </div>

            <!-- Pagination -->
            @if($activities->hasPages())
            <div class="d-flex justify-content-center mt-5">
                <nav aria-label="Activity pagination">
                    <ul class="pagination creative-pagination">
                        {{ $activities->links() }}
                    </ul>
                </nav>
            </div>
            @endif
        </div>
    </div>
</div>

<!-- Delete Confirmation Modal -->
<div class="modal fade" id="deleteModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content creative-modal border-0 shadow-lg">
            <div class="modal-header border-0">
                <h5 class="modal-title text-danger">
                    <i class="fas fa-exclamation-triangle me-2"></i>Confirm Deletion
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body text-center py-4">
                <i class="fas fa-trash-alt fa-3x text-danger mb-3"></i>
                <h5>Delete Activity Log?</h5>
                <p class="text-muted">This action cannot be undone. The activity log will be permanently removed from the system.</p>
            </div>
            <div class="modal-footer border-0">
                <button type="button" class="btn btn-outline-secondary creative-btn" data-bs-dismiss="modal">Cancel</button>
                <form id="deleteForm" method="POST" style="display: inline;">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger creative-btn">
                        <i class="fas fa-trash me-2"></i>Delete Permanently
                    </button>
                </form>
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
                showNotification('Activity log deleted successfully', 'success');
                setTimeout(() => location.reload(), 1000);
            } else {
                showNotification('Error deleting activity log', 'error');
            }
        });
    }
}

function clearOldLogs() {
    if (confirm('Delete all activity logs older than 30 days? This will help improve system performance.')) {
        fetch('/activity-logs/clear-old', {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'Content-Type': 'application/json'
            }
        }).then(response => {
            if (response.ok) {
                showNotification('Old activity logs cleared successfully', 'success');
                setTimeout(() => location.reload(), 1000);
            } else {
                showNotification('Error clearing old logs', 'error');
            }
        });
    }
}

function refreshLogs() {
    document.getElementById('last-updated').textContent = new Date().toLocaleTimeString('en-US', { 
        hour: 'numeric', 
        minute: '2-digit',
        hour12: true 
    });
    showNotification('Timeline refreshed', 'info');
}

function showNotification(message, type) {
    // Simple notification implementation
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

// Auto-refresh every 30 seconds
setInterval(refreshLogs, 30000);
</script>

<style>
.creative-header {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
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

.creative-card.hover-lift:hover {
    transform: translateY(-5px);
    box-shadow: 0 12px 35px rgba(0,0,0,0.1) !important;
}

.creative-btn {
    border-radius: 12px;
    font-weight: 600;
    transition: all 0.3s ease;
}

.creative-btn-sm {
    border-radius: 8px;
    font-weight: 500;
}

.creative-timeline {
    position: relative;
    padding: 20px 0;
}

.timeline-item {
    display: flex;
    margin-bottom: 40px;
    position: relative;
}

.timeline-item.left {
    justify-content: flex-start;
    padding-right: 50%;
}

.timeline-item.right {
    justify-content: flex-end;
    padding-left: 50%;
}

.timeline-marker {
    position: absolute;
    top: 0;
    width: 50%;
    display: flex;
    align-items: center;
}

.timeline-item.left .timeline-marker {
    right: 0;
    justify-content: flex-start;
}

.timeline-item.right .timeline-marker {
    left: 0;
    justify-content: flex-end;
}

.marker-dot {
    width: 60px;
    height: 60px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
    font-size: 1.2rem;
    position: relative;
    z-index: 2;
    box-shadow: 0 4px 15px rgba(0,0,0,0.1);
}

.marker-line {
    position: absolute;
    top: 30px;
    width: 100%;
    height: 2px;
    background: linear-gradient(90deg, #e9ecef, #667eea, #e9ecef);
}

.timeline-item.left .marker-line {
    left: 60px;
}

.timeline-item.right .marker-line {
    right: 60px;
}

.user-avatar {
    width: 50px;
    height: 50px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-weight: bold;
}

.action-badge {
    font-size: 0.75rem;
    padding: 6px 12px;
    border-radius: 20px;
}

.activity-meta .meta-item {
    background: #f8f9fa;
    padding: 4px 12px;
    border-radius: 20px;
    font-size: 0.8rem;
    color: #6c757d;
}

/* Action-specific styles */
.login-dot { background: linear-gradient(135deg, #28a745, #20c997); }
.logout-dot { background: linear-gradient(135deg, #6c757d, #adb5bd); }
.create-dot { background: linear-gradient(135deg, #007bff, #6f42c1); }
.read-dot { background: linear-gradient(135deg, #17a2b8, #20c997); }
.update-dot { background: linear-gradient(135deg, #ffc107, #fd7e14); }
.delete-dot { background: linear-gradient(135deg, #dc3545, #e83e8c); }
.upload-dot { background: linear-gradient(135deg, #28a745, #20c997); }
.download-dot { background: linear-gradient(135deg, #007bff, #6f42c1); }

.bg-gradient-login { background: linear-gradient(135deg, #28a745, #20c997); }
.bg-gradient-logout { background: linear-gradient(135deg, #6c757d, #adb5bd); }
.bg-gradient-create { background: linear-gradient(135deg, #007bff, #6f42c1); }
.bg-gradient-read { background: linear-gradient(135deg, #17a2b8, #20c997); }
.bg-gradient-update { background: linear-gradient(135deg, #ffc107, #fd7e14); }
.bg-gradient-delete { background: linear-gradient(135deg, #dc3545, #e83e8c); }
.bg-gradient-upload { background: linear-gradient(135deg, #28a745, #20c997); }
.bg-gradient-download { background: linear-gradient(135deg, #007bff, #6f42c1); }

.creative-modal {
    border-radius: 20px;
}

.creative-pagination .page-link {
    border-radius: 12px;
    margin: 0 4px;
    border: none;
    font-weight: 600;
}

.empty-state-icon {
    opacity: 0.5;
}

/* Responsive */
@media (max-width: 768px) {
    .timeline-item {
        flex-direction: column;
        padding: 0 !important;
    }
    
    .timeline-marker {
        position: relative;
        width: 100%;
        justify-content: center !important;
        margin-bottom: 20px;
    }
    
    .marker-line {
        display: none;
    }
    
    .creative-header {
        text-align: center;
    }
}
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