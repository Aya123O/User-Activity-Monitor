<?php
// app/Http/Controllers/ActivityLogController.php
namespace App\Http\Controllers;

use App\Models\ActivityLog;
use App\Models\User;
use Illuminate\Http\Request;

class ActivityLogController extends Controller
{
    public function index(Request $request)
    {
        $query = ActivityLog::with('user')->latest();
        
        // Apply filters
        if ($request->has('user_id') && $request->user_id) {
            $query->where('user_id', $request->user_id);
        }
        
        if ($request->has('action') && $request->action) {
            $query->where('action', $request->action);
        }
        
        if ($request->has('date_from') && $request->date_from) {
            $query->whereDate('created_at', '>=', $request->date_from);
        }
        
        if ($request->has('date_to') && $request->date_to) {
            $query->whereDate('created_at', '<=', $request->date_to);
        }
        
        $activities = $query->paginate(20);
        $users = User::all();
        
        return view('activity-logs.index', compact('activities', 'users'));
    }

    public function show(ActivityLog $activityLog)
    {
        return view('activity-logs.show', compact('activityLog'));
    }

    public function destroy(ActivityLog $activityLog)
    {
        $activityLog->delete();

        return redirect()->route('activity-logs.index')
            ->with('success', 'Activity log deleted successfully.');
    }

    public function clearOldLogs()
    {
        // Delete logs older than 30 days
        ActivityLog::where('created_at', '<', now()->subDays(30))->delete();

        return redirect()->route('activity-logs.index')
            ->with('success', 'Old activity logs cleared successfully.');
    }

    // Helper method for badge colors
    public function getActionBadgeColor($action)
    {
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
}