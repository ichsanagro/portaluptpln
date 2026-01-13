<?php

namespace App\Http\Controllers\Hse;

use App\Http\Controllers\Controller;
use App\Models\HseStat;
use Carbon\Carbon;
use Carbon\CarbonPeriod;
use Illuminate\Http\Request;

class AdminHseController extends Controller
{
    public function dashboard()
    {
        $stats = HseStat::firstOrFail();
        $today = Carbon::today();

        // This block updates the database record for safe_working_days based on conditions.
        // It's essential for persistent data and independent of view display.
        if ($stats->accident_count === 0) {
            // Calculate working days from start_date to today to potentially update DB
            $startDateForDbUpdate = $stats->start_date ?? Carbon::createFromDate($today->year, 1, 1);
            $periodForDbWorkingDays = CarbonPeriod::create($startDateForDbUpdate, $today);
            $currentWorkingDaysFromStart = 0;
            foreach ($periodForDbWorkingDays as $date) {
                if (!$date->isWeekend()) {
                    $currentWorkingDaysFromStart++;
                }
            }

            if ($stats->safe_working_days !== $currentWorkingDaysFromStart || $stats->last_safe_working_day_update < $today) {
                $stats->safe_working_days = $currentWorkingDaysFromStart;
                $stats->last_safe_working_day_update = $today;
                $stats->save();
            }
        } else {
            if ($stats->last_safe_working_day_update && $stats->last_safe_working_day_update < $today) {
                $periodForSafeDaysIncrement = CarbonPeriod::create($stats->last_safe_working_day_update->addDay(), $today);
                $daysToAdd = 0;
                foreach ($periodForSafeDaysIncrement as $date) {
                    if (!$date->isWeekend()) {
                        $daysToAdd++;
                    }
                }

                if ($daysToAdd > 0) {
                    $stats->safe_working_days += $daysToAdd;
                    $stats->last_safe_working_day_update = $today;
                    $stats->save();
                }
            }
        }

        // Data for Admin Panel inputs
        return view('hse.admin_dashboard', [
            'safeWorkingDays' => $stats->safe_working_days,
            'accidentCount' => $stats->accident_count,
            'startDate' => $stats->start_date ? $stats->start_date->format('Y-m-d') : '',
        ]);
    }

    public function updateStats(Request $request)
    {
        $validated = $request->validate([
            'safe_working_days' => 'required|integer|min:0',
            'accident_count' => 'required|integer|min:0',
            'start_date' => 'nullable|date',
        ]);

        $stats = HseStat::firstOrFail();

        // If accident count increases, reset safe days
        if ($validated['accident_count'] > $stats->accident_count) {
            $validated['safe_working_days'] = 0;
            $stats->last_safe_working_day_update = Carbon::today();
        }

        $stats->update($validated);

        return response()->json(['success' => true, 'message' => 'Statistik berhasil diperbarui.']);
    }

    public function resetStats()
    {
        $stats = HseStat::firstOrFail();
        $stats->update([
            'safe_working_days' => 0,
            'accident_count' => 0,
            'start_date' => Carbon::createFromDate(Carbon::today()->year, 1, 1),
            'last_safe_working_day_update' => Carbon::today(),
        ]);

        return response()->json(['success' => true, 'message' => 'Statistik berhasil direset.']);
    }
}