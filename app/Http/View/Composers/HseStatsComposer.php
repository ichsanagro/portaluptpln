<?php

namespace App\Http\View\Composers;

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

            $periodForWorkingDays = CarbonPeriod::create($startDate, $today);
            $workingDaysThisYear = 0;
            foreach ($periodForWorkingDays as $date) {
                if (!$date->isWeekend()) {
                    $workingDaysThisYear++;
                }
            }

            $displayedSafeWorkingDays = 0;

            if ($stats->accident_count === 0) {
                $displayedSafeWorkingDays = $workingDaysThisYear;
            } else {
                $tempSafeWorkingDays = $stats->safe_working_days;
                if ($stats->last_safe_working_day_update && $stats->last_safe_working_day_update < $today) {
                    $periodForSafeDaysIncrement = CarbonPeriod::create($stats->last_safe_working_day_update->addDay(), $today);
                    $daysToAdd = 0;
                    foreach ($periodForSafeDaysIncrement as $date) {
                        if (!$date->isWeekend()) {
                            $daysToAdd++;
                        }
                    }
                    $tempSafeWorkingDays += $daysToAdd;
                }
                $displayedSafeWorkingDays = $tempSafeWorkingDays;
            }
            
            $view->with([
                'safeWorkingDays' => $displayedSafeWorkingDays,
                'accidentCount' => $stats->accident_count,
                'workingDaysThisYear' => $workingDaysThisYear
            ]);

        } catch (\Exception $e) {
            // In case the database or table hasn't been set up, provide defaults
            $view->with([
                'safeWorkingDays' => 0,
                'accidentCount' => 0,
                'workingDaysThisYear' => 0
            ]);
        }
    }
}
