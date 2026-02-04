<?php

namespace App\Http\Controllers\Hse;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\SensorData;
use Illuminate\Support\Facades\DB; // DB facade can be kept or removed

class MonitoringController extends Controller
{
    /**
     * Display the IoT monitoring dashboard with the latest data per unique sensor.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        // This new logic ensures we get the latest record for EVERY unique sensor,
        // preventing cards from disappearing from the dashboard.

        $whitelist = config('sensors.whitelist', []);

        if (empty($whitelist)) {
            // If the whitelist is empty, return no data
            $sensorData = collect();
            return view('hse.monitoring.dashboard', compact('sensorData'));
        }

        // 1. Get the latest ID for each unique device_id within the whitelist.
        $latestIds = SensorData::whereIn(DB::raw("JSON_UNQUOTE(JSON_EXTRACT(payload, '$.device_id'))"), $whitelist)
            ->select(DB::raw('MAX(id) as id'))
            ->groupBy(DB::raw("JSON_UNQUOTE(JSON_EXTRACT(payload, '$.device_id'))"))
            ->pluck('id');

        // If no data found for whitelisted sensors, return empty collection
        if ($latestIds->isEmpty()) {
            $sensorData = collect();
            return view('hse.monitoring.dashboard', compact('sensorData'));
        }

        // 2. Fetch the full records for those latest IDs.
        $sensorData = SensorData::whereIn('id', $latestIds)
            ->orderBy('created_at', 'desc')
            ->get();

        return view('hse.monitoring.dashboard', compact('sensorData'));
    }
}
