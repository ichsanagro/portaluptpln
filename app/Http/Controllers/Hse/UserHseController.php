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
        $stats = HseStat::first();
        $substations = Substation::all();
        $videos = PlaylistVideo::orderBy('order')->get();

        return view('hse.hse_dashboard', [
            'videoUrl' => $stats->video_url ?? null,
            'imageUrl' => $stats->image_path ? asset('storage/' . $stats->image_path) : null,
            'displayMode' => $stats->display_mode ?? 'video',
            'substations' => $substations,
            'videos' => $videos,
        ]);
    }
}