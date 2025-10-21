<?php
// app/Http/Controllers/InactivityController.php
namespace App\Http\Controllers;

use App\Models\InactivityLog;
use App\Models\Penalty;
use App\Models\SystemSetting;
use Illuminate\Http\Request;

class InactivityController extends Controller
{
    // API Methods
    public function logInactivity(Request $request)
    {
        $request->validate([
            'type' => 'required|in:alert,warning,logout',
            'duration' => 'required|integer'
        ]);

        $user = auth()->user();
        
        InactivityLog::create([
            'user_id' => $user->id,
            'idle_duration' => $request->duration,
            'type' => $request->type,
            'reason' => 'Auto-detected inactivity',
            'triggered_at' => now(),
        ]);

        return response()->json(['message' => 'Inactivity logged successfully']);
    }

    // Admin Methods
    public function index()
    {
        $inactivities = InactivityLog::with('user')
            ->latest()
            ->paginate(15);

        return view('admin.inactivities.index', compact('inactivities'));
    }

    public function penalties()
    {
        $penalties = Penalty::with('user')
            ->latest()
            ->paginate(12);

        return view('admin.penalties.index', compact('penalties'));
    }

    public function clearOldPenalties()
    {
        // Delete penalties older than 90 days
        Penalty::where('penalty_date', '<', now()->subDays(90))->delete();

        return redirect()->route('admin.penalties')
            ->with('success', 'Old penalties cleared successfully.');
    }

    public function settings()
    {
        $settings = SystemSetting::all();
        return view('admin.settings.index', compact('settings'));
    }

    public function updateSettings(Request $request)
    {
        $validated = $request->validate([
            'idle_timeout' => 'required|integer|min:1',
            'idle_warning_timeout' => 'required|integer|min:1',
            'idle_logout_timeout' => 'required|integer|min:1',
            'activity_monitoring_enabled' => 'required|boolean',
            'inactivity_penalty_enabled' => 'required|boolean',
        ]);

        foreach ($validated as $key => $value) {
            SystemSetting::setValue($key, $value);
        }

        return redirect()->back()->with('success', 'Settings updated successfully.');
    }
}