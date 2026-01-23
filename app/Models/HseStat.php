<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class HseStat extends Model
{
    protected $fillable = [
        'safe_working_days',
        'accident_count',
        'start_date',
        'last_safe_working_day_update',
        'video_url',
        'image_path',
        'display_mode',
    ];

    protected $casts = [
        'start_date' => 'date',
        'last_safe_working_day_update' => 'date',
    ];
}
