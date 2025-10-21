<?php
// app/Models/InactivityLog.php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InactivityLog extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id', 'idle_duration', 'type', 'reason', 'triggered_at'
    ];

    protected $casts = [
        'triggered_at' => 'datetime',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}