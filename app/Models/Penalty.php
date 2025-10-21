<?php
// app/Models/Penalty.php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Penalty extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id', 'reason', 'count', 'details', 'penalty_date'
    ];

    protected $casts = [
        'details' => 'array',
        'penalty_date' => 'datetime',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}