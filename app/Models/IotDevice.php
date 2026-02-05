<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class IotDevice extends Model
{
    use HasFactory;

    protected $fillable = [
        'substation_id',
        'room',
        'name',
        'topic',
        'is_active',
    ];

    public function substation()
    {
        return $this->belongsTo(Substation::class);
    }

    /**
     * Get the latest sensor data for this device.
     */
    public function latestData()
    {
        return $this->hasOne(SensorData::class, 'topic', 'topic')->latestOfMany();
    }
}
