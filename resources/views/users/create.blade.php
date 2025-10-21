@extends('layouts.app')

@section('title', 'Create User - User Activity Monitor')

@section('content')
<div class="container-fluid">
    <div class="row">
        @include('layouts.sidebar')
        
        <div class="col-md-9 ml-sm-auto col-lg-10 px-4 py-4">
            <!-- Header Section -->
            <div class="d-flex justify-content-between align-items-center mb-4">
                <div>
                    <h1 class="h3 mb-1 text-gradient-primary">Create New User</h1>
                    <p class="text-muted">Add a new user to the activity monitoring system</p>
                </div>
                <div class="btn-toolbar">
                    <a href="{{ route('users.index') }}" class="btn btn-outline-secondary">
                        <i class="fas fa-arrow-left me-2"></i> Back to Users
                    </a>
                </div>
            </div>

            <!-- Alerts -->
            @if($errors->any())
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <div class="d-flex">
                        <i class="fas fa-exclamation-triangle me-3 mt-1"></i>
                        <div>
                            <h5 class="alert-heading mb-2">Please fix the following errors:</h5>
                            <ul class="mb-0">
                                @foreach($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <i class="fas fa-check-circle me-2"></i>
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            @if(session('error'))
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <i class="fas fa-exclamation-circle me-2"></i>
                    {{ session('error') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            <!-- Form Card -->
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-transparent border-0 py-4">
                    <h5 class="card-title mb-0 d-flex align-items-center">
                        <i class="fas fa-user-plus text-primary me-3"></i>
                        User Information
                    </h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('users.store') }}" method="POST" enctype="multipart/form-data" class="needs-validation" novalidate>
                        @csrf
                        
                        <div class="row">
                            <div class="col-lg-8">
                                <!-- Personal Information -->
                                <div class="form-section mb-5">
                                    <h6 class="section-title text-primary mb-4">
                                        <i class="fas fa-id-card me-2"></i>
                                        Personal Information
                                    </h6>
                                    <div class="row">
                                        <div class="col-md-6 mb-3">
                                            <label for="name" class="form-label">
                                                Full Name <span class="text-danger">*</span>
                                            </label>
                                            <div class="input-group">
                                                <span class="input-group-text bg-light border-end-0">
                                                    <i class="fas fa-user text-muted"></i>
                                                </span>
                                                <input type="text" class="form-control @error('name') is-invalid @enderror" 
                                                       id="name" name="name" value="{{ old('name') }}" 
                                                       placeholder="Enter full name" required>
                                                @error('name')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                        
                                        <div class="col-md-6 mb-3">
                                            <label for="email" class="form-label">
                                                Email Address <span class="text-danger">*</span>
                                            </label>
                                            <div class="input-group">
                                                <span class="input-group-text bg-light border-end-0">
                                                    <i class="fas fa-envelope text-muted"></i>
                                                </span>
                                                <input type="email" class="form-control @error('email') is-invalid @enderror" 
                                                       id="email" name="email" value="{{ old('email') }}" 
                                                       placeholder="Enter email address" required>
                                                @error('email')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Security Settings -->
                                <div class="form-section mb-5">
                                    <h6 class="section-title text-primary mb-4">
                                        <i class="fas fa-lock me-2"></i>
                                        Security Settings
                                    </h6>
                                    <div class="row">
                                        <div class="col-md-6 mb-3">
                                            <label for="password" class="form-label">
                                                Password <span class="text-danger">*</span>
                                            </label>
                                            <div class="input-group">
                                                <span class="input-group-text bg-light border-end-0">
                                                    <i class="fas fa-key text-muted"></i>
                                                </span>
                                                <input type="password" class="form-control @error('password') is-invalid @enderror" 
                                                       id="password" name="password" 
                                                       placeholder="Enter password" required>
                                                <button type="button" class="btn btn-outline-secondary toggle-password" 
                                                        data-target="password">
                                                    <i class="fas fa-eye"></i>
                                                </button>
                                                @error('password')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                            <small class="form-text text-muted">
                                                Minimum 8 characters with letters and numbers
                                            </small>
                                        </div>
                                        
                                        <div class="col-md-6 mb-3">
                                            <label for="password_confirmation" class="form-label">
                                                Confirm Password <span class="text-danger">*</span>
                                            </label>
                                            <div class="input-group">
                                                <span class="input-group-text bg-light border-end-0">
                                                    <i class="fas fa-key text-muted"></i>
                                                </span>
                                                <input type="password" class="form-control" 
                                                       id="password_confirmation" name="password_confirmation" 
                                                       placeholder="Confirm password" required>
                                                <button type="button" class="btn btn-outline-secondary toggle-password" 
                                                        data-target="password_confirmation">
                                                    <i class="fas fa-eye"></i>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Role & Permissions -->
                                <div class="form-section mb-4">
                                    <h6 class="section-title text-primary mb-4">
                                        <i class="fas fa-user-shield me-2"></i>
                                        Role & Permissions
                                    </h6>
                                    <div class="row">
                                        <div class="col-md-6 mb-3">
                                            <label for="role" class="form-label">
                                                User Role <span class="text-danger">*</span>
                                            </label>
                                            <select class="form-select @error('role') is-invalid @enderror" 
                                                    id="role" name="role" required>
                                                <option value="">Select a role</option>
                                                <option value="user" {{ old('role') == 'user' ? 'selected' : '' }}>
                                                    <i class="fas fa-user me-2"></i> User
                                                </option>
                                                <option value="admin" {{ old('role') == 'admin' ? 'selected' : '' }}>
                                                    <i class="fas fa-crown me-2"></i> Administrator
                                                </option>
                                            </select>
                                            @error('role')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Profile Picture Section -->
                            <div class="col-lg-4">
                                <div class="card bg-light border-0">
                                    <div class="card-body text-center">
                                        <h6 class="card-title text-muted mb-3">
                                            <i class="fas fa-camera me-2"></i>
                                            Profile Picture
                                        </h6>
                                        
                                        <!-- Avatar Preview -->
                                        <div class="avatar-upload mb-4">
                                            <div class="avatar-preview mx-auto mb-3">
                                                <div id="avatarPreview" class="rounded-circle bg-primary bg-opacity-10 d-flex align-items-center justify-content-center" 
                                                     style="width: 120px; height: 120px; margin: 0 auto;">
                                                    <i class="fas fa-user text-primary fa-3x"></i>
                                                </div>
                                            </div>
                                            <div class="avatar-edit">
                                                <input type="file" class="form-control @error('avatar') is-invalid @enderror" 
                                                       id="avatar" name="avatar" accept="image/*" 
                                                       onchange="previewImage(this)">
                                                <label for="avatar" class="btn btn-outline-primary btn-sm mt-2">
                                                    <i class="fas fa-upload me-1"></i> Choose Image
                                                </label>
                                                @error('avatar')
                                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>

                                        <div class="file-info small text-muted">
                                            <p class="mb-1">Recommended: Square image</p>
                                            <p class="mb-0">Max size: 2MB</p>
                                        </div>
                                    </div>
                                </div>

                                <!-- Role Information -->
                                <div class="card bg-light border-0 mt-4">
                                    <div class="card-body">
                                        <h6 class="card-title text-muted mb-3">
                                            <i class="fas fa-info-circle me-2"></i>
                                            Role Information
                                        </h6>
                                        <div class="role-info">
                                            <div class="role-item mb-2">
                                                <span class="badge bg-primary me-2">Admin</span>
                                                <small class="text-muted">Full system access</small>
                                            </div>
                                            <div class="role-item">
                                                <span class="badge bg-secondary me-2">User</span>
                                                <small class="text-muted">Basic access only</small>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Form Actions -->
                        <div class="form-actions mt-5 pt-4 border-top">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <a href="{{ route('users.index') }}" class="btn btn-outline-secondary">
                                        <i class="fas fa-times me-2"></i> Cancel
                                    </a>
                                </div>
                                <div>
                                    <button type="reset" class="btn btn-outline-danger me-2">
                                        <i class="fas fa-redo me-2"></i> Reset
                                    </button>
                                    <button type="submit" class="btn btn-primary px-4">
                                        <i class="fas fa-user-plus me-2"></i> Create User
                                    </button>
                                </div>
                            </div>
                        </div>
                    </form>
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

    .form-section {
        padding: 1.5rem;
        background: #f8f9fa;
        border-radius: 12px;
        border-left: 4px solid #007bff;
    }

    .section-title {
        font-weight: 600;
        font-size: 1.1rem;
    }

    .card {
        border: none;
        border-radius: 12px;
        box-shadow: 0 2px 15px rgba(0,0,0,0.08);
    }

    .form-control, .form-select {
        border-radius: 8px;
        border: 1px solid #e2e8f0;
        padding: 0.75rem 1rem;
        transition: all 0.3s ease;
    }

    .form-control:focus, .form-select:focus {
        border-color: #007bff;
        box-shadow: 0 0 0 3px rgba(0,123,255,0.1);
    }

    .input-group-text {
        border-radius: 8px 0 0 8px;
        background: #f8fafc;
        border: 1px solid #e2e8f0;
    }

    .toggle-password {
        border-radius: 0 8px 8px 0;
        border: 1px solid #e2e8f0;
        border-left: none;
    }

    .avatar-preview {
        transition: all 0.3s ease;
    }

    .avatar-preview:hover {
        transform: scale(1.05);
    }

    .avatar-edit input[type="file"] {
        display: none;
    }

    .form-actions {
        background: #f8fafc;
        margin: 0 -2rem -2rem;
        padding: 1.5rem 2rem;
    }

    .btn {
        border-radius: 8px;
        padding: 0.75rem 1.5rem;
        font-weight: 500;
        transition: all 0.3s ease;
    }

    .btn-primary {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        border: none;
    }

    .btn-primary:hover {
        transform: translateY(-2px);
        box-shadow: 0 5px 15px rgba(102, 126, 234, 0.4);
    }

    .alert {
        border: none;
        border-radius: 12px;
        border-left: 4px solid;
    }

    .alert-danger {
        border-left-color: #dc3545;
    }

    .alert-success {
        border-left-color: #28a745;
    }
</style>

<script>
    // Toggle password visibility
    document.querySelectorAll('.toggle-password').forEach(button => {
        button.addEventListener('click', function() {
            const targetId = this.getAttribute('data-target');
            const input = document.getElementById(targetId);
            const icon = this.querySelector('i');
            
            if (input.type === 'password') {
                input.type = 'text';
                icon.classList.remove('fa-eye');
                icon.classList.add('fa-eye-slash');
            } else {
                input.type = 'password';
                icon.classList.remove('fa-eye-slash');
                icon.classList.add('fa-eye');
            }
        });
    });

    // Image preview functionality
    function previewImage(input) {
        const preview = document.getElementById('avatarPreview');
        const file = input.files[0];
        const reader = new FileReader();

        reader.onload = function(e) {
            preview.innerHTML = `<img src="${e.target.result}" class="rounded-circle" style="width: 120px; height: 120px; object-fit: cover;">`;
        }

        if (file) {
            reader.readAsDataURL(file);
        }
    }

    // Form validation
    (function() {
        'use strict';
        window.addEventListener('load', function() {
            var forms = document.getElementsByClassName('needs-validation');
            var validation = Array.prototype.filter.call(forms, function(form) {
                form.addEventListener('submit', function(event) {
                    if (form.checkValidity() === false) {
                        event.preventDefault();
                        event.stopPropagation();
                    }
                    form.classList.add('was-validated');
                }, false);
            });
        }, false);
    })();
</script>
@endsection