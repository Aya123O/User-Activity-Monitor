<?php
// app/Models/InactivitySession.php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class InactivitySession extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'session_start',
        'last_activity',
        'idle_timeout',
        'warning_count',
        'status',
    ];

    protected $casts = [
        'session_start' => 'datetime',
        'last_activity' => 'datetime',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function penalties()
    {
        return $this->hasMany(Penalty::class);
    }

    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }

    public function getTimeIdle()
    {
        return now()->diffInSeconds($this->last_activity);
    }
}