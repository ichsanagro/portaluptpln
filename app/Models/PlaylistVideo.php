<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PlaylistVideo extends Model
{
    protected $fillable = [
        'path',
        'original_name',
        'order',
    ];
}
