<?php
// app/Http/Controllers/DashboardController.php
namespace App\Http\Controllers;

use App\Models\User;
use App\Models\ActivityLog;
use App\Models\InactivityLog;
use App\Models\Penalty;
use App\Models\SystemSetting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        
        if ($user->role === 'admin') {
            return $this->adminDashboard();
        }
        
        return $this->userDashboard();
    }

    protected function adminDashboard()
    {
        try {
            $totalUsers = User::count();
            $activeUsers = User::where('is_active', true)->count();
            $totalActivities = ActivityLog::count();
            $todayActivities = ActivityLog::whereDate('created_at', today())->count();
            
            // Check if Penalty model exists
            $activePenalties = class_exists(Penalty::class) ? Penalty::count() : 0;
            
            // Check if InactivityLog model exists
            $todayInactivities = class_exists(InactivityLog::class) ? InactivityLog::whereDate('created_at', today())->count() : 0;

            // Recent activities with user data
            $recentActivities = ActivityLog::with('user')
                ->latest()
                ->limit(10)
                ->get();

            // Chart data - activities per day for last 7 days
            $activityChart = ActivityLog::select(
                    DB::raw('DATE(created_at) as date'),
                    DB::raw('COUNT(*) as count')
                )
                ->where('created_at', '>=', now()->subDays(7))
                ->groupBy('date')
                ->orderBy('date')
                ->get();

            // User activity statistics
            $userActivityStats = User::withCount(['activityLogs as total_activities'])
                ->withCount(['activityLogs as today_activities' => function($query) {
                    $query->whereDate('created_at', today());
                }])
                ->orderBy('total_activities', 'desc')
                ->limit(10)
                ->get();

            // Recent penalties - only if model exists
            $recentPenalties = class_exists(Penalty::class) ? 
                Penalty::with('user')->latest()->limit(5)->get() : 
                collect();

            // System settings for display
            $idleTimeout = class_exists(SystemSetting::class) ? 
                SystemSetting::getValue('idle_timeout', 5) : 5;
            $monitoringEnabled = class_exists(SystemSetting::class) ? 
                SystemSetting::getValue('activity_monitoring_enabled', true) : true;

            return view('dashboard.admin', compact(
                'totalUsers', 
                'activeUsers', 
                'totalActivities',
                'todayActivities',
                'activePenalties',
                'todayInactivities',
                'recentActivities',
                'activityChart',
                'userActivityStats',
                'recentPenalties',
                'idleTimeout',
                'monitoringEnabled'
            ));

        } catch (\Exception $e) {
            // Fallback if any models are missing
            return $this->fallbackAdminDashboard();
        }
    }

    protected function fallbackAdminDashboard()
    {
        $totalUsers = User::count();
        $activeUsers = User::where('is_active', true)->count();
        $totalActivities = 0;
        $todayActivities = 0;
        $activePenalties = 0;
        $todayInactivities = 0;
        $recentActivities = collect();
        $activityChart = collect();
        $userActivityStats = collect();
        $recentPenalties = collect();
        $idleTimeout = 5;
        $monitoringEnabled = true;

        return view('dashboard.admin', compact(
            'totalUsers', 
            'activeUsers', 
            'totalActivities',
            'todayActivities',
            'activePenalties',
            'todayInactivities',
            'recentActivities',
            'activityChart',
            'userActivityStats',
            'recentPenalties',
            'idleTimeout',
            'monitoringEnabled'
        ));
    }

    protected function userDashboard()
    {
        try {
            $user = auth()->user();
            
            $userStats = [
                'total_activities' => $user->activityLogs()->count(),
                'today_activities' => $user->activityLogs()->whereDate('created_at', today())->count(),
                'inactivity_count' => class_exists(InactivityLog::class) ? $user->inactivityLogs()->count() : 0,
                'penalty_count' => class_exists(Penalty::class) ? $user->penalties()->count() : 0,
                'last_activity' => $user->last_activity_at ? $user->last_activity_at->diffForHumans() : 'Never',
            ];

            // Recent user activities
            $recentActivities = $user->activityLogs()
                ->latest()
                ->limit(10)
                ->get();

            // Recent inactivity warnings
            $recentInactivities = class_exists(InactivityLog::class) ? 
                $user->inactivityLogs()->latest()->limit(5)->get() : 
                collect();

            return view('dashboard.user', compact(
                'userStats',
                'recentActivities',
                'recentInactivities'
            ));

        } catch (\Exception $e) {
            return $this->fallbackUserDashboard();
        }
    }

    protected function fallbackUserDashboard()
    {
        $user = auth()->user();
        
        $userStats = [
            'total_activities' => 0,
            'today_activities' => 0,
            'inactivity_count' => 0,
            'penalty_count' => 0,
            'last_activity' => 'Never',
        ];

        $recentActivities = collect();
        $recentInactivities = collect();

        return view('dashboard.user', compact(
            'userStats',
            'recentActivities',
            'recentInactivities'
        ));
    }

    public function getDashboardStats()
    {
        $user = auth()->user();
        
        if ($user->role === 'admin') {
            $stats = [
                'totalUsers' => User::count(),
                'activeUsers' => User::where('is_active', true)->count(),
                'todayActivities' => ActivityLog::whereDate('created_at', today())->count(),
                'todayInactivities' => class_exists(InactivityLog::class) ? InactivityLog::whereDate('created_at', today())->count() : 0,
                'onlineUsers' => User::where('last_activity_at', '>=', now()->subMinutes(5))->count(),
            ];
        } else {
            $stats = [
                'todayActivities' => $user->activityLogs()->whereDate('created_at', today())->count(),
                'inactivityCount' => class_exists(InactivityLog::class) ? $user->inactivityLogs()->count() : 0,
                'penaltyCount' => class_exists(Penalty::class) ? $user->penalties()->count() : 0,
                'lastActivity' => $user->last_activity_at ? $user->last_activity_at->diffForHumans() : 'Never',
            ];
        }

        return response()->json($stats);
    }
}