<?php
// app/Services/InactivityService.php
namespace App\Services;

use App\Models\InactivityLog;
use App\Models\Penalty;
use App\Models\User;
use App\Models\SystemSetting;

class InactivityService
{
    public function checkInactivity(User $user)
    {
        $lastActivity = $user->last_activity_at;
        if (!$lastActivity) return;

        $idleDuration = now()->diffInSeconds($lastActivity);
        
        $alertTimeout = (int) SystemSetting::getValue('idle_timeout', 5);
        $warningTimeout = (int) SystemSetting::getValue('idle_warning_timeout', 10);
        $logoutTimeout = (int) SystemSetting::getValue('idle_logout_timeout', 15);

        if ($idleDuration >= $logoutTimeout) {
            return $this->handleLogout($user, $idleDuration);
        } elseif ($idleDuration >= $warningTimeout) {
            return $this->handleWarning($user, $idleDuration);
        } elseif ($idleDuration >= $alertTimeout) {
            return $this->handleAlert($user, $idleDuration);
        }
    }

    protected function handleAlert(User $user, int $duration)
    {
        InactivityLog::create([
            'user_id' => $user->id,
            'idle_duration' => $duration,
            'type' => 'alert',
            'reason' => 'First inactivity alert triggered',
            'triggered_at' => now(),
        ]);

        return [
            'type' => 'alert',
            'message' => 'You have been inactive for a while.',
            'duration' => $duration,
        ];
    }

    protected function handleWarning(User $user, int $duration)
    {
        InactivityLog::create([
            'user_id' => $user->id,
            'idle_duration' => $duration,
            'type' => 'warning',
            'reason' => 'Second inactivity warning triggered',
            'triggered_at' => now(),
        ]);

        return [
            'type' => 'warning',
            'message' => 'Warning: You will be logged out soon due to inactivity.',
            'duration' => $duration,
        ];
    }

    protected function handleLogout(User $user, int $duration)
    {
        InactivityLog::create([
            'user_id' => $user->id,
            'idle_duration' => $duration,
            'type' => 'logout',
            'reason' => 'Automatic logout due to prolonged inactivity',
            'triggered_at' => now(),
        ]);

        // Add penalty if enabled
        if (SystemSetting::getValue('inactivity_penalty_enabled', true)) {
            $this->addPenalty($user, $duration);
        }

        // Logout the user
        auth()->logout();
        request()->session()->invalidate();
        request()->session()->regenerateToken();

        return [
            'type' => 'logout',
            'message' => 'You have been logged out due to inactivity.',
            'duration' => $duration,
        ];
    }

    protected function addPenalty(User $user, int $duration)
    {
        $penalty = Penalty::where('user_id', $user->id)
            ->where('reason', 'inactivity_logout')
            ->first();

        if ($penalty) {
            $penalty->update([
                'count' => $penalty->count + 1,
                'details' => [
                    'last_duration' => $duration,
                    'total_penalties' => $penalty->count + 1,
                ],
                'penalty_date' => now(),
            ]);
        } else {
            Penalty::create([
                'user_id' => $user->id,
                'reason' => 'inactivity_logout',
                'count' => 1,
                'details' => [
                    'last_duration' => $duration,
                    'total_penalties' => 1,
                ],
                'penalty_date' => now(),
            ]);
        }
    }

    public function resetInactivity(User $user)
    {
        $user->update(['last_activity_at' => now()]);
    }
}