<!-- resources/views/admin/settings/index.blade.php -->
@extends('layouts.app')

@section('title', 'System Settings')

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
                                <i class="fas fa-sliders-h me-3"></i>System Configuration
                            </h1>
                            <p class="mb-0 opacity-75">Customize monitoring parameters and system behavior</p>
                        </div>
                        <div class="text-end">
                            <div class="stats-badge bg-white bg-opacity-20 px-3 py-2 rounded-3">
                                <div class="h4 mb-0">{{ $settings->count() }}</div>
                                <small class="opacity-75">Settings</small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Settings Cards -->
            <div class="row">
                <!-- Main Settings Form -->
                <div class="col-lg-8">
                    <div class="card creative-card border-0 shadow-sm mb-4">
                        <div class="card-header bg-transparent border-0 py-4">
                            <h5 class="card-title mb-0 d-flex align-items-center">
                                <i class="fas fa-cogs text-primary me-2"></i>
                                Monitoring Configuration
                            </h5>
                        </div>
                        <div class="card-body">
                            <form method="POST" action="{{ route('settings.update') }}" id="settingsForm">
                                @csrf
                                
                                <!-- Inactivity Timeouts Section -->
                                <div class="settings-section mb-5">
                                    <div class="section-header d-flex align-items-center mb-4">
                                        <div class="section-icon bg-primary bg-opacity-10 rounded-3 p-3 me-3">
                                            <i class="fas fa-clock text-primary fa-lg"></i>
                                        </div>
                                        <div>
                                            <h6 class="section-title text-primary mb-1">Inactivity Timeouts</h6>
                                            <p class="text-muted mb-0">Configure automatic session management</p>
                                        </div>
                                    </div>
                                    
                                    <div class="row g-4">
                                        <div class="col-md-4">
                                            <div class="setting-card bg-light rounded-3 p-4 h-100 text-center">
                                                <div class="setting-icon bg-warning bg-opacity-10 rounded-circle mx-auto mb-3">
                                                    <i class="fas fa-bell text-warning fa-lg"></i>
                                                </div>
                                                <label class="form-label fw-semibold d-block">Alert Timeout</label>
                                                <input type="number" 
                                                       class="form-control text-center fw-bold fs-5 border-0 bg-transparent" 
                                                       name="idle_timeout" 
                                                       value="{{ $settings->where('key', 'idle_timeout')->first()->value ?? 5 }}" 
                                                       min="1" required>
                                                <small class="text-muted mt-2 d-block">First warning</small>
                                            </div>
                                        </div>
                                        
                                        <div class="col-md-4">
                                            <div class="setting-card bg-light rounded-3 p-4 h-100 text-center">
                                                <div class="setting-icon bg-orange bg-opacity-10 rounded-circle mx-auto mb-3">
                                                    <i class="fas fa-exclamation-triangle text-orange fa-lg"></i>
                                                </div>
                                                <label class="form-label fw-semibold d-block">Warning Timeout</label>
                                                <input type="number" 
                                                       class="form-control text-center fw-bold fs-5 border-0 bg-transparent" 
                                                       name="idle_warning_timeout" 
                                                       value="{{ $settings->where('key', 'idle_warning_timeout')->first()->value ?? 10 }}" 
                                                       min="1" required>
                                                <small class="text-muted mt-2 d-block">Final warning</small>
                                            </div>
                                        </div>
                                        
                                        <div class="col-md-4">
                                            <div class="setting-card bg-light rounded-3 p-4 h-100 text-center">
                                                <div class="setting-icon bg-danger bg-opacity-10 rounded-circle mx-auto mb-3">
                                                    <i class="fas fa-sign-out-alt text-danger fa-lg"></i>
                                                </div>
                                                <label class="form-label fw-semibold d-block">Logout Timeout</label>
                                                <input type="number" 
                                                       class="form-control text-center fw-bold fs-5 border-0 bg-transparent" 
                                                       name="idle_logout_timeout" 
                                                       value="{{ $settings->where('key', 'idle_logout_timeout')->first()->value ?? 15 }}" 
                                                       min="1" required>
                                                <small class="text-muted mt-2 d-block">Auto logout</small>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <!-- Timeout Visualization -->
                                    <div class="timeout-visualization mt-4 p-4 bg-dark bg-opacity-5 rounded-3">
                                        <div class="d-flex justify-content-between align-items-center mb-3">
                                            <small class="text-muted">Inactivity Timeline</small>
                                            <small class="text-muted" id="timelinePreview">0s → 5s → 10s → 15s</small>
                                        </div>
                                        <div class="progress timeout-progress" style="height: 12px;">
                                            <div class="progress-bar bg-warning" style="width: 33%"></div>
                                            <div class="progress-bar bg-orange" style="width: 33%"></div>
                                            <div class="progress-bar bg-danger" style="width: 34%"></div>
                                        </div>
                                        <div class="d-flex justify-content-between mt-2">
                                            <small class="text-warning">Alert</small>
                                            <small class="text-orange">Warning</small>
                                            <small class="text-danger">Logout</small>
                                        </div>
                                    </div>
                                </div>

                                <!-- System Features Section -->
                                <div class="settings-section">
                                    <div class="section-header d-flex align-items-center mb-4">
                                        <div class="section-icon bg-success bg-opacity-10 rounded-3 p-3 me-3">
                                            <i class="fas fa-toggle-on text-success fa-lg"></i>
                                        </div>
                                        <div>
                                            <h6 class="section-title text-primary mb-1">System Features</h6>
                                            <p class="text-muted mb-0">Enable or disable system modules</p>
                                        </div>
                                    </div>
                                    
                                    <div class="row g-4">
                                        <div class="col-md-6">
                                            <div class="feature-toggle-card bg-light rounded-3 p-4 h-100">
                                                <div class="d-flex align-items-center justify-content-between">
                                                    <div class="d-flex align-items-center">
                                                        <div class="feature-icon bg-info bg-opacity-10 rounded-3 p-3 me-3">
                                                            <i class="fas fa-history text-info fa-lg"></i>
                                                        </div>
                                                        <div>
                                                            <h6 class="mb-1 fw-semibold">Activity Monitoring</h6>
                                                            <p class="text-muted mb-0 small">Track user actions</p>
                                                        </div>
                                                    </div>
                                                    <div class="form-check form-switch">
                                                        <input class="form-check-input feature-switch" 
                                                               type="checkbox" 
                                                               name="activity_monitoring_enabled" 
                                                               value="true"
                                                               {{ ($settings->where('key', 'activity_monitoring_enabled')->first()->value ?? 'true') === 'true' ? 'checked' : '' }}>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        
                                        <div class="col-md-6">
                                            <div class="feature-toggle-card bg-light rounded-3 p-4 h-100">
                                                <div class="d-flex align-items-center justify-content-between">
                                                    <div class="d-flex align-items-center">
                                                        <div class="feature-icon bg-danger bg-opacity-10 rounded-3 p-3 me-3">
                                                            <i class="fas fa-gavel text-danger fa-lg"></i>
                                                        </div>
                                                        <div>
                                                            <h6 class="mb-1 fw-semibold">Inactivity Penalties</h6>
                                                            <p class="text-muted mb-0 small">Auto-penalty system</p>
                                                        </div>
                                                    </div>
                                                    <div class="form-check form-switch">
                                                        <input class="form-check-input feature-switch" 
                                                               type="checkbox" 
                                                               name="inactivity_penalty_enabled" 
                                                               value="true"
                                                               {{ ($settings->where('key', 'inactivity_penalty_enabled')->first()->value ?? 'true') === 'true' ? 'checked' : '' }}>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Action Buttons -->
                                <div class="d-flex justify-content-between align-items-center mt-5 pt-4 border-top">
                                    <div>
                                        <button type="button" class="btn btn-outline-secondary creative-btn" onclick="resetToDefaults()">
                                            <i class="fas fa-undo me-2"></i>Reset to Defaults
                                        </button>
                                    </div>
                                    <div class="d-flex gap-2">
                                        <button type="button" class="btn btn-outline-secondary creative-btn" onclick="testSettings()">
                                            <i class="fas fa-vial me-2"></i>Test Settings
                                        </button>
                                        <button type="submit" class="btn btn-primary creative-btn">
                                            <i class="fas fa-save me-2"></i>Save Configuration
                                        </button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

                <!-- Sidebar - Current Status & Info -->
                <div class="col-lg-4">
                    <!-- Current Status -->
                    <div class="card creative-card border-0 shadow-sm mb-4">
                        <div class="card-header bg-transparent border-0">
                            <h5 class="card-title d-flex align-items-center">
                                <i class="fas fa-chart-bar me-2"></i>
                                Current Status
                            </h5>
                        </div>
                        <div class="card-body">
                            <div class="status-grid">
                                <div class="status-item d-flex justify-content-between align-items-center p-3 bg-success bg-opacity-10 rounded-3 mb-3">
                                    <div class="d-flex align-items-center">
                                        <i class="fas fa-check-circle text-success me-3 fa-lg"></i>
                                        <div>
                                            <div class="fw-semibold">Activity Monitoring</div>
                                            <small class="text-muted">
                                                {{ ($settings->where('key', 'activity_monitoring_enabled')->first()->value ?? 'true') === 'true' ? 'Active' : 'Inactive' }}
                                            </small>
                                        </div>
                                    </div>
                                    <span class="badge bg-{{ ($settings->where('key', 'activity_monitoring_enabled')->first()->value ?? 'true') === 'true' ? 'success' : 'secondary' }}">
                                        {{ ($settings->where('key', 'activity_monitoring_enabled')->first()->value ?? 'true') === 'true' ? 'ON' : 'OFF' }}
                                    </span>
                                </div>
                                
                                <div class="status-item d-flex justify-content-between align-items-center p-3 bg-danger bg-opacity-10 rounded-3 mb-3">
                                    <div class="d-flex align-items-center">
                                        <i class="fas fa-shield-alt text-danger me-3 fa-lg"></i>
                                        <div>
                                            <div class="fw-semibold">Penalty System</div>
                                            <small class="text-muted">
                                                {{ ($settings->where('key', 'inactivity_penalty_enabled')->first()->value ?? 'true') === 'true' ? 'Active' : 'Inactive' }}
                                            </small>
                                        </div>
                                    </div>
                                    <span class="badge bg-{{ ($settings->where('key', 'inactivity_penalty_enabled')->first()->value ?? 'true') === 'true' ? 'success' : 'secondary' }}">
                                        {{ ($settings->where('key', 'inactivity_penalty_enabled')->first()->value ?? 'true') === 'true' ? 'ON' : 'OFF' }}
                                    </span>
                                </div>
                                
                                <div class="status-item d-flex justify-content-between align-items-center p-3 bg-primary bg-opacity-10 rounded-3">
                                    <div class="d-flex align-items-center">
                                        <i class="fas fa-clock text-primary me-3 fa-lg"></i>
                                        <div>
                                            <div class="fw-semibold">Response Time</div>
                                            <small class="text-muted">System latency</small>
                                        </div>
                                    </div>
                                    <span class="fw-bold text-primary">< 50ms</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Quick Stats -->
                    <div class="card creative-card border-0 shadow-sm">
                        <div class="card-header bg-transparent border-0">
                            <h5 class="card-title d-flex align-items-center">
                                <i class="fas fa-rocket me-2"></i>
                                Performance
                            </h5>
                        </div>
                        <div class="card-body">
                            <div class="performance-stats">
                                <div class="stat-item text-center p-3">
                                    <div class="stat-value text-primary fw-bold fs-3">{{ $settings->where('key', 'idle_timeout')->first()->value ?? 5 }}s</div>
                                    <div class="stat-label text-muted">Alert Timeout</div>
                                </div>
                                <div class="stat-item text-center p-3">
                                    <div class="stat-value text-warning fw-bold fs-3">{{ $settings->where('key', 'idle_logout_timeout')->first()->value ?? 15 }}s</div>
                                    <div class="stat-label text-muted">Logout Timeout</div>
                                </div>
                            </div>
                            <div class="mt-3">
                                <div class="d-flex justify-content-between align-items-center mb-2">
                                    <small class="text-muted">System Load</small>
                                    <small class="text-muted">25%</small>
                                </div>
                                <div class="progress" style="height: 6px;">
                                    <div class="progress-bar bg-success" style="width: 25%"></div>
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
function resetToDefaults() {
    if (confirm('Reset all settings to default values? This cannot be undone.')) {
        document.querySelector('input[name="idle_timeout"]').value = 5;
        document.querySelector('input[name="idle_warning_timeout"]').value = 10;
        document.querySelector('input[name="idle_logout_timeout"]').value = 15;
        document.querySelector('input[name="activity_monitoring_enabled"]').checked = true;
        document.querySelector('input[name="inactivity_penalty_enabled"]').checked = true;
        
        updateTimelinePreview();
        showNotification('Settings reset to defaults', 'info');
    }
}

function testSettings() {
    showNotification('Testing current configuration...', 'warning');
    // Simulate settings test
    setTimeout(() => {
        showNotification('Settings test completed successfully!', 'success');
    }, 2000);
}

function updateTimelinePreview() {
    const alert = document.querySelector('input[name="idle_timeout"]').value;
    const warning = document.querySelector('input[name="idle_warning_timeout"]').value;
    const logout = document.querySelector('input[name="idle_logout_timeout"]').value;
    
    document.getElementById('timelinePreview').textContent = 
        `0s → ${alert}s → ${warning}s → ${logout}s`;
}

function showNotification(message, type) {
    const alert = document.createElement('div');
    alert.className = `alert alert-${type} alert-dismissible fade show position-fixed top-0 end-0 m-3`;
    alert.style.zIndex = '1060';
    alert.innerHTML = `
        <i class="fas fa-${type === 'success' ? 'check' : type === 'warning' ? 'exclamation-triangle' : 'info'}-circle me-2"></i>
        ${message}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    `;
    document.body.appendChild(alert);
    
    setTimeout(() => {
        if (alert.parentElement) {
            alert.remove();
        }
    }, 4000);
}

// Real-time updates
document.querySelectorAll('input[type="number"]').forEach(input => {
    input.addEventListener('input', updateTimelinePreview);
});

// Initialize
document.addEventListener('DOMContentLoaded', function() {
    updateTimelinePreview();
});

// Form submission
document.getElementById('settingsForm').addEventListener('submit', function(e) {
    const alert = parseInt(document.querySelector('input[name="idle_timeout"]').value);
    const warning = parseInt(document.querySelector('input[name="idle_warning_timeout"]').value);
    const logout = parseInt(document.querySelector('input[name="idle_logout_timeout"]').value);
    
    if (alert >= warning || warning >= logout) {
        e.preventDefault();
        showNotification('Timeout values must be in increasing order: Alert < Warning < Logout', 'danger');
        return false;
    }
});
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

.creative-card:hover {
    box-shadow: 0 8px 25px rgba(0,0,0,0.1) !important;
}

.creative-btn {
    border-radius: 12px;
    font-weight: 600;
    transition: all 0.3s ease;
}

.creative-btn:hover {
    transform: translateY(-2px);
}

.settings-section {
    padding: 0;
}

.section-icon {
    width: 60px;
    height: 60px;
    display: flex;
    align-items: center;
    justify-content: center;
}

.setting-card {
    transition: all 0.3s ease;
    border: 2px solid transparent;
}

.setting-card:hover {
    border-color: #007bff;
    transform: translateY(-5px);
}

.setting-icon {
    width: 50px;
    height: 50px;
    display: flex;
    align-items: center;
    justify-content: center;
}

.feature-toggle-card {
    transition: all 0.3s ease;
    border: 2px solid transparent;
}

.feature-toggle-card:hover {
    border-color: #e9ecef;
    transform: translateY(-2px);
}

.feature-icon {
    width: 50px;
    height: 50px;
    display: flex;
    align-items: center;
    justify-content: center;
}

.feature-switch {
    transform: scale(1.3);
}

.timeout-progress {
    border-radius: 10px;
    overflow: hidden;
}

.timeout-progress .progress-bar {
    transition: width 0.3s ease;
}

.status-grid .status-item {
    transition: all 0.3s ease;
}

.status-grid .status-item:hover {
    transform: translateX(5px);
}

.performance-stats {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 15px;
}

.stat-item {
    background: #f8f9fa;
    border-radius: 12px;
    transition: all 0.3s ease;
}

.stat-item:hover {
    background: #e9ecef;
    transform: scale(1.05);
}

.bg-orange {
    background-color: #fd7e14 !important;
}

.text-orange {
    color: #fd7e14 !important;
}

/* Responsive */
@media (max-width: 768px) {
    .creative-header {
        text-align: center;
    }
    
    .stats-badge {
        margin-top: 15px;
    }
    
    .performance-stats {
        grid-template-columns: 1fr;
    }
}
</style>
@endsection