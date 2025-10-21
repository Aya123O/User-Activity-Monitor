<?php
// app/Services/ActivityLogService.php
namespace App\Services;

use App\Models\ActivityLog;
use App\Models\User;
use Illuminate\Http\Request;
use Jenssegers\Agent\Agent;

class ActivityLogService
{
    protected $agent;

    public function __construct()
    {
        $this->agent = new Agent();
    }

    public function logActivity(User $user, string $action, $model = null, array $oldValues = null, array $newValues = null, string $description = null)
    {
        $request = request();

        $logData = [
            'user_id' => $user->id,
            'action' => $action,
            'description' => $description ?? $this->generateDescription($action, $model),
            'ip_address' => $request->ip(),
            'user_agent' => $request->userAgent(),
            'browser' => $this->agent->browser(),
            'platform' => $this->agent->platform(),
            'device' => $this->agent->device(),
            'url' => $request->fullUrl(),
            'method' => $request->method(),
        ];

        if ($model) {
            $logData['model_type'] = get_class($model);
            $logData['model_id'] = $model->id;
        }

        if ($oldValues) {
            $logData['old_values'] = $oldValues;
        }

        if ($newValues) {
            $logData['new_values'] = $newValues;
        }

        ActivityLog::create($logData);

        // Update user's last activity
        $user->update(['last_activity_at' => now()]);
    }

    protected function generateDescription(string $action, $model = null): string
    {
        $modelName = $model ? class_basename($model) : 'system';

        return match($action) {
            'login' => 'User logged in',
            'logout' => 'User logged out',
            'create' => "Created new {$modelName}",
            'read' => "Viewed {$modelName}",
            'update' => "Updated {$modelName}",
            'delete' => "Deleted {$modelName}",
            'upload' => "Uploaded file",
            'download' => "Downloaded file",
            'approval' => "Approval action performed",
            default => "Performed {$action} on {$modelName}",
        };
    }
}