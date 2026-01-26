<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Substation extends Model
{
    protected $fillable = ['name', 'latitude', 'longitude'];
}
