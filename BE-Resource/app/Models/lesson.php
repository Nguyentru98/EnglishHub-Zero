<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class lesson extends Model
{
    use HasFactory;
    protected $fillable = [
        'section_id',
        'type',
        'content',
        'title',
        'order_index',
        'video_path',
        'duration_seconds',
        'is_free_preview',
    ];
}
