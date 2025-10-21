<!-- resources/views/layouts/sidebar.blade.php -->
<div class="col-md-3 col-lg-2 sidebar bg-dark text-white">
    <div class="text-center mb-4 pt-3">
        <h4 class="text-white">
            <i class="fas fa-shield-alt me-2"></i>Activity Monitor
        </h4>
        <small class="text-muted">Security & Monitoring</small>
    </div>
    <ul class="nav flex-column">
        <li class="nav-item">
            <a class="nav-link {{ request()->routeIs('dashboard') || request()->routeIs('home') ? 'active' : '' }}" href="{{ route('dashboard') }}">
                <i class="fas fa-tachometer-alt me-2"></i>Dashboard
            </a>
        </li>
        
        @if(auth()->user()->role === 'admin')
        <li class="nav-item">
            <a class="nav-link {{ request()->routeIs('users.*') ? 'active' : '' }}" href="{{ route('users.index') }}">
                <i class="fas fa-users me-2"></i>User Management
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link {{ request()->routeIs('activity-logs.*') ? 'active' : '' }}" href="{{ route('activity-logs.index') }}">
                <i class="fas fa-history me-2"></i>Activity Logs
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link {{ request()->routeIs('inactivities.index') ? 'active' : '' }}" href="{{ route('inactivities.index') }}">
                <i class="fas fa-clock me-2"></i>Inactivity Monitor
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link {{ request()->routeIs('penalties.index') ? 'active' : '' }}" href="{{ route('penalties.index') }}">
                <i class="fas fa-exclamation-triangle me-2"></i>Penalty System
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link {{ request()->routeIs('settings.index') ? 'active' : '' }}" href="{{ route('settings.index') }}">
                <i class="fas fa-cog me-2"></i>System Config
            </a>
        </li>
        @else
        <li class="nav-item">
            <a class="nav-link {{ request()->routeIs('activity-logs.*') ? 'active' : '' }}" href="{{ route('activity-logs.index') }}">
                <i class="fas fa-history me-2"></i>My Activities
            </a>
        </li>
        @endif
        
        <li class="nav-item mt-4 pt-3 border-top">
            <a class="nav-link text-warning" href="{{ route('logout') }}" 
               onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                <i class="fas fa-sign-out-alt me-2"></i>Logout
            </a>
            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                @csrf
            </form>
        </li>
    </ul>
</div>