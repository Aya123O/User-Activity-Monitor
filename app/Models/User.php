<?php
// app/Models/User.php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\SoftDeletes;

class User extends Authenticatable
{
    use HasFactory, Notifiable, SoftDeletes;

    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'avatar',
        'is_active',
        'last_activity_at',
        'timezone',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'last_activity_at' => 'datetime',
        'is_active' => 'boolean',
    ];

    // Relationships
    public function activityLogs()
    {
        return $this->hasMany(ActivityLog::class);
    }

    public function inactivitySessions()
    {
        return $this->hasMany(InactivitySession::class);
    }

    public function penalties()
    {
        return $this->hasMany(Penalty::class);
    }

    public function activePenalties()
    {
        return $this->penalties()->where('is_active', true);
    }

    // Scopes
    public function scopeAdmins($query)
    {
        return $query->where('role', 'admin');
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    // Methods
    public function isAdmin()
    {
        return $this->role === 'admin';
    }

    public function updateLastActivity()
    {
        $this->update(['last_activity_at' => now()]);
    }

    public function getActivityStats()
    {
        return [
            'total_actions' => $this->activityLogs()->count(),
            'today_actions' => $this->activityLogs()->whereDate('created_at', today())->count(),
            'last_penalty' => $this->penalties()->latest()->first(),
            'active_penalties' => $this->activePenalties()->count(),
        ];
    }

    public function getAvatarUrl()
    {
        if ($this->avatar) {
            return asset('storage/' . $this->avatar);
        }
        
        // Generate default avatar based on name
        $name = urlencode($this->name);
        return "https://ui-avatars.com/api/?name={$name}&color=7F9CF5&background=EBF4FF";
    }

    public function hasActivePenalties()
    {
        return $this->activePenalties()->exists();
    }

    public function getStatusBadgeColor()
    {
        if (!$this->is_active) {
            return 'red';
        }
        
        if ($this->hasActivePenalties()) {
            return 'orange';
        }
        
        return 'green';
    }
}