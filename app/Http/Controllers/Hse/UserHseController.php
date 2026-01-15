<?php

namespace App\Http\Controllers\Hse;

use App\Http\Controllers\Controller;
use App\Models\HseStat;
use Carbon\Carbon;
use Carbon\CarbonPeriod;
use Illuminate\Http\Request;

class UserHseController extends Controller
{
    public function dashboard()
    {
        $stats = HseStat::first();
        return view('hse.hse_dashboard', [
            'videoUrl' => $stats->video_url ?? null,
            'imageUrl' => $stats->image_path ? asset('storage/' . $stats->image_path) : null,
            'displayMode' => $stats->display_mode ?? 'video',
        ]);
    }
}