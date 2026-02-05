<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\Substation;
use Illuminate\Http\Request;

class MonitoringController extends Controller
{
    public function getMonitoringData(Substation $substation)
    {
        $substation->load('iotDevices.latestData');

        $data = $substation->iotDevices->map(function ($device) {
            return [
                'id' => $device->id,
                'value' => $device->latestData->payload['value'] ?? null,
                'unit' => $device->latestData->payload['unit'] ?? '',
                'timestamp_human' => $device->latestData ? $device->latestData->created_at->diffForHumans() : 'No data',
            ];
        });

        return response()->json($data);
    }
}