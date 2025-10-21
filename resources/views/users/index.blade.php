@extends('layouts.app')

@section('title', 'User Management - User Activity Monitor')

@section('content')
<div class="container-fluid">
    <div class="row">
        @include('layouts.sidebar')
        
        <div class="col-md-9 ml-sm-auto col-lg-10 px-4 py-4">
            <!-- Header Section -->
            <div class="d-flex justify-content-between align-items-center mb-4">
                <div>
                    <h1 class="h3 mb-1 text-gradient-primary">User Management</h1>
                    <p class="text-muted">Manage all system users and their permissions</p>
                </div>
                <div class="btn-toolbar">
                    <a href="{{ route('users.create') }}" class="btn btn-primary">
                        <i class="fas fa-user-plus me-2"></i> Add New User
                    </a>
                </div>
            </div>

            <!-- Alerts -->
            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <div class="d-flex align-items-center">
                        <i class="fas fa-check-circle me-2"></i>
                        <div>
                            {{ session('success') }}
                        </div>
                    </div>
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            @if(session('error'))
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <div class="d-flex align-items-center">
                        <i class="fas fa-exclamation-circle me-2"></i>
                        <div>
                            {{ session('error') }}
                        </div>
                    </div>
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            <!-- Stats Overview -->
            <div class="row mb-4">
                <div class="col-xl-3 col-md-6 mb-3">
                    <div class="card stats-card bg-primary text-white">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <h6 class="card-title text-white-50 mb-2">Total Users</h6>
                                    <h3 class="mb-0">{{ $users->total() }}</h3>
                                </div>
                                <div class="stats-icon">
                                    <i class="fas fa-users fa-2x opacity-50"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="col-xl-3 col-md-6 mb-3">
                    <div class="card stats-card bg-success text-white">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <h6 class="card-title text-white-50 mb-2">Active Users</h6>
                                    <h3 class="mb-0">{{ $users->where('is_active', true)->count() }}</h3>
                                </div>
                                <div class="stats-icon">
                                    <i class="fas fa-user-check fa-2x opacity-50"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="col-xl-3 col-md-6 mb-3">
                    <div class="card stats-card bg-info text-white">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <h6 class="card-title text-white-50 mb-2">Admins</h6>
                                    <h3 class="mb-0">{{ $users->where('role', 'admin')->count() }}</h3>
                                </div>
                                <div class="stats-icon">
                                    <i class="fas fa-crown fa-2x opacity-50"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="col-xl-3 col-md-6 mb-3">
                    <div class="card stats-card bg-warning text-white">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <h6 class="card-title text-white-50 mb-2">With Penalties</h6>
                                    <h3 class="mb-0">{{ $users->where('penalties_count', '>', 0)->count() }}</h3>
                                </div>
                                <div class="stats-icon">
                                    <i class="fas fa-exclamation-triangle fa-2x opacity-50"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Users Table Card -->
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-transparent border-0 py-3">
                    <h5 class="card-title mb-0 d-flex align-items-center">
                        <i class="fas fa-users text-primary me-2"></i>
                        All Users
                    </h5>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover align-middle mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th class="ps-4">User</th>
                                    <th>Role</th>
                                    <th>Status</th>
                                    <th class="text-center">Activities</th>
                                    <th class="text-center">Penalties</th>
                                    <th class="text-end pe-4">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($users as $user)
                                <tr class="user-row">
                                    <td class="ps-4">
                                        <div class="d-flex align-items-center">
                                            <div class="avatar-wrapper me-3">
                                                @if($user->avatar)
                                                    <img src="{{ Storage::disk('public')->url($user->avatar) }}" 
                                                         alt="{{ $user->name }}" 
                                                         class="avatar-img rounded-circle">
                                                @else
                                                    <div class="avatar-placeholder bg-primary rounded-circle d-flex align-items-center justify-content-center">
                                                        <span class="text-white fw-bold">{{ strtoupper(substr($user->name, 0, 1)) }}</span>
                                                    </div>
                                                @endif
                                            </div>
                                            <div>
                                                <h6 class="mb-1 user-name">{{ $user->name }}</h6>
                                                <small class="text-muted">{{ $user->email }}</small>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <span class="badge role-badge bg-{{ $user->role === 'admin' ? 'primary' : 'secondary' }}">
                                            <i class="fas fa-{{ $user->role === 'admin' ? 'crown' : 'user' }} me-1"></i>
                                            {{ ucfirst($user->role) }}
                                        </span>
                                    </td>
                                    <td>
                                        <span class="badge status-badge bg-{{ $user->is_active ? 'success' : 'danger' }}">
                                            <i class="fas fa-{{ $user->is_active ? 'check-circle' : 'times-circle' }} me-1"></i>
                                            {{ $user->is_active ? 'Active' : 'Inactive' }}
                                        </span>
                                    </td>
                                    <td class="text-center">
                                        <div class="activity-count">
                                            <i class="fas fa-history text-info me-1"></i>
                                            <span class="fw-bold">{{ $user->activity_logs_count }}</span>
                                        </div>
                                    </td>
                                    <td class="text-center">
                                        <div class="penalty-count">
                                            <i class="fas fa-exclamation-triangle text-{{ $user->penalties_count > 0 ? 'warning' : 'muted' }} me-1"></i>
                                            <span class="fw-bold">{{ $user->penalties_count }}</span>
                                        </div>
                                    </td>
                                    <td class="text-end pe-4">
                                        <div class="action-buttons">
                                            <a href="{{ route('users.show', $user) }}" class="btn btn-sm btn-outline-info action-btn" 
                                               data-bs-toggle="tooltip" title="View Profile">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                            <a href="{{ route('users.edit', $user) }}" class="btn btn-sm btn-outline-warning action-btn" 
                                               data-bs-toggle="tooltip" title="Edit User">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            @if($user->id !== auth()->id())
                                            <form action="{{ route('users.destroy', $user) }}" method="POST" class="d-inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-outline-danger action-btn" 
                                                        data-bs-toggle="tooltip" title="Delete User"
                                                        onclick="return confirm('Are you sure you want to delete {{ $user->name }}?')">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </form>
                                            @else
                                            <button class="btn btn-sm btn-outline-secondary action-btn" 
                                                    data-bs-toggle="tooltip" title="Cannot delete your own account" disabled>
                                                <i class="fas fa-trash"></i>
                                            </button>
                                            @endif
                                        </div>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    
                    <!-- Pagination -->
                    @if($users->hasPages())
                    <div class="card-footer bg-transparent border-0 py-3">
                        <div class="d-flex justify-content-between align-items-center">
                            <div class="text-muted">
                                Showing {{ $users->firstItem() }} to {{ $users->lastItem() }} of {{ $users->total() }} users
                            </div>
                            <div>
                                {{ $users->links() }}
                            </div>
                        </div>
                    </div>
                    @endif
                </div>
            </div>

            <!-- Empty State -->
            @if($users->count() == 0)
            <div class="text-center py-5">
                <div class="empty-state">
                    <i class="fas fa-users fa-4x text-muted mb-3"></i>
                    <h4 class="text-muted">No users found</h4>
                    <p class="text-muted mb-4">Get started by creating your first user</p>
                    <a href="{{ route('users.create') }}" class="btn btn-primary">
                        <i class="fas fa-user-plus me-2"></i> Create First User
                    </a>
                </div>
            </div>
            @endif
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

    .stats-card {
        border: none;
        border-radius: 12px;
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

    .stats-card:hover {
        transform: translateY(-3px);
        box-shadow: 0 8px 25px rgba(0,0,0,0.15);
    }

    .stats-icon {
        opacity: 0.8;
        transition: all 0.3s ease;
    }

    .stats-card:hover .stats-icon {
        transform: scale(1.1);
        opacity: 1;
    }

    .card {
        border: none;
        border-radius: 12px;
        box-shadow: 0 2px 15px rgba(0,0,0,0.08);
    }

    .table {
        margin-bottom: 0;
    }

    .table th {
        border-top: none;
        font-weight: 600;
        font-size: 0.875rem;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        color: #6c757d;
        padding: 1rem 0.75rem;
    }

    .table td {
        padding: 1rem 0.75rem;
        vertical-align: middle;
        border-color: #f8f9fa;
    }

    .user-row {
        transition: all 0.2s ease;
    }

    .user-row:hover {
        background-color: #f8fafc;
        transform: translateX(4px);
    }

    .avatar-wrapper {
        position: relative;
    }

    .avatar-img, .avatar-placeholder {
        width: 45px;
        height: 45px;
        object-fit: cover;
    }

    .avatar-placeholder {
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.1rem;
    }

    .user-name {
        font-weight: 600;
        color: #2d3748;
    }

    .badge {
        font-weight: 500;
        padding: 0.5rem 0.75rem;
        border-radius: 8px;
        font-size: 0.75rem;
    }

    .role-badge, .status-badge {
        border: 1px solid transparent;
    }

    .action-buttons {
        display: flex;
        gap: 0.5rem;
        justify-content: flex-end;
    }

    .action-btn {
        width: 36px;
        height: 36px;
        border-radius: 8px;
        display: flex;
        align-items: center;
        justify-content: center;
        transition: all 0.3s ease;
        border: 1px solid #e2e8f0;
    }

    .action-btn:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(0,0,0,0.1);
    }

    .activity-count, .penalty-count {
        font-size: 0.9rem;
        font-weight: 500;
    }

    .empty-state {
        padding: 3rem 1rem;
    }

    .table-responsive {
        border-radius: 12px;
    }

    .alert {
        border: none;
        border-radius: 12px;
        border-left: 4px solid;
    }

    .alert-success {
        border-left-color: #28a745;
        background: linear-gradient(135deg, #d4edda 0%, #c3e6cb 100%);
    }

    .alert-danger {
        border-left-color: #dc3545;
        background: linear-gradient(135deg, #f8d7da 0%, #f1b0b7 100%);
    }

    .pagination {
        margin-bottom: 0;
    }

    .page-link {
        border: none;
        border-radius: 8px;
        margin: 0 2px;
        color: #6c757d;
        font-weight: 500;
    }

    .page-item.active .page-link {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        border: none;
    }

    .page-link:hover {
        background-color: #e9ecef;
        color: #495057;
    }
</style>

<script>
    // Initialize tooltips
    document.addEventListener('DOMContentLoaded', function() {
        var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
        var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
            return new bootstrap.Tooltip(tooltipTriggerEl)
        });
    });
</script>
@endsection