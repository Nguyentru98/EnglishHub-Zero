<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CourseProgress extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id',
        'session_id',
        'completed_at',
        'watch_time_seconds',
        'is_completed',
    ];
}
