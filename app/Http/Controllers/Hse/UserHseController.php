<?php

namespace App\Http\Controllers\Hse;

use App\Http\Controllers\Controller;
use App\Models\Substation;
use App\Models\HseStat;
use App\Models\PlaylistVideo;
use Carbon\Carbon;
use Carbon\CarbonPeriod;
use Illuminate\Http\Request;

class UserHseController extends Controller
{
    public function dashboard()
    {
        $substations = Substation::all();
        $playlistItems = PlaylistVideo::orderBy('order')->get();

        return view('hse.hse_dashboard', [
            'substations' => $substations,
            'playlistItems' => $playlistItems,
        ]);
    }

    public function monitoringIot(Substation $substation)
    {
        $substation->load('iotDevices.latestData');
        
        return view('hse.monitoring_iot', [
            'substation' => $substation,
        ]);
    }
}