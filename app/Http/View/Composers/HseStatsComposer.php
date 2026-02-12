<?php

namespace App\Http\View\Composers;

use App\Models\AccidentLog;
use App\Models\HseStat;
use Carbon\Carbon;
use Carbon\CarbonPeriod;
use Illuminate\View\View;

class HseStatsComposer
{
    /**
     * Bind data to the view.
     *
     * @param  \Illuminate\View\View  $view
     * @return void
     */
    public function compose(View $view)
    {
        try {
            $stats = HseStat::firstOrFail();
            $today = Carbon::today();

            $startDate = $stats->start_date ?? Carbon::createFromDate($today->year, 1, 1);

            // Calculate total days including weekends
            $workingDaysThisYear = $startDate->diffInDays($today) + 1;

            $accidentLogs = AccidentLog::orderBy('accident_date', 'desc')->get();
            $displayedSafeWorkingDays = 0;

            if ($accidentLogs->isEmpty()) {
                // No accidents, safe days are the same as total working days
                $displayedSafeWorkingDays = $workingDaysThisYear;
            } else {
                // Accidents exist, calculate safe days from the last accident date
                $lastAccidentDate = Carbon::parse($accidentLogs->first()->accident_date);
                $displayedSafeWorkingDays = $lastAccidentDate->diffInDays($today);
            }
            
            $view->with([
                'safeWorkingDays' => $displayedSafeWorkingDays,
                'accidentCount' => $stats->accident_count,
                'workingDaysThisYear' => $workingDaysThisYear,
                'videoUrl' => $stats->video_url,
                'accidentLogs' => $accidentLogs,
            ]);

        } catch (\Exception $e) {
            // In case the database or table hasn't been set up, provide defaults
            $view->with([
                'safeWorkingDays' => 0,
                'accidentCount' => 0,
                'workingDaysThisYear' => 0,
                'videoUrl' => null,
                'accidentLogs' => [],
            ]);
        }
    }
}
