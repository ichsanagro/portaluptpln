<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AccidentLog extends Model
{
    protected $fillable = [
        'accident_date',
        'description',
    ];
}
