<?php

namespace App\Http\Controllers\Hse;

use App\Http\Controllers\Controller;
use App\Models\AccidentLog;
use App\Models\HseStat;
use Carbon\Carbon;
use Carbon\CarbonPeriod;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

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
            'videoUrl' => $stats->video_url,
            'imageUrl' => $stats->image_path ? asset('storage/' . $stats->image_path) : null, // Get full URL for display
            'displayMode' => $stats->display_mode,
        ]);
    }

    public function updateDisplaySettings(Request $request)
    {
        $stats = HseStat::firstOrFail();

        $validated = $request->validate([
            'display_mode' => 'required|in:video,image',
            'video_url' => 'nullable|url',
            'dashboard_image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048', // 2MB Max
        ]);

        if ($validated['display_mode'] === 'video') {
            $stats->video_url = $validated['video_url'];
            $stats->image_path = null; // Clear image if switching to video
            // If there was an old image, delete it
            if ($request->hasFile('dashboard_image') && $stats->image_path) {
                Storage::disk('public')->delete($stats->image_path);
            }
        } elseif ($validated['display_mode'] === 'image') {
            $stats->video_url = null; // Clear video if switching to image
            
            // Handle image upload
            if ($request->hasFile('dashboard_image')) {
                // Delete old image if it exists
                if ($stats->image_path) {
                    Storage::disk('public')->delete($stats->image_path);
                }
                $imagePath = $request->file('dashboard_image')->store('dashboard_images', 'public');
                $stats->image_path = $imagePath;
            }
        }
        
        $stats->display_mode = $validated['display_mode'];
        $stats->save();

        return redirect()->route('hse.admin_dashboard')->with('success', 'Pengaturan tampilan berhasil diperbarui.');
    }

    public function updateStats(Request $request)
    {
        $validated = $request->validate([
            'safe_working_days' => 'required|integer|min:0',
            'accident_count' => 'required|integer|min:0',
            'start_date' => 'nullable|date',
            'last_accident_date' => 'nullable|date',
            'accident_description' => 'nullable|string',
        ]);

        $stats = HseStat::firstOrFail();

        // If a new accident date is present, it means a new accident was added.
        if (!empty($validated['last_accident_date'])) {
            $validated['safe_working_days'] = 0;
            $stats->last_safe_working_day_update = Carbon::today();
            
            // Create a new accident log
            AccidentLog::create([
                'accident_date' => $validated['last_accident_date'],
                'description' => $validated['accident_description'],
            ]);
        }

        // If admin sets accident count to 0, clear the logs
        if ((int)$validated['accident_count'] === 0 && $stats->accident_count > 0) {
            AccidentLog::truncate();
        }
        
        // We no longer store accident details directly on the HseStat model
        unset($validated['last_accident_date']);
        unset($validated['accident_description']);

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

        // Also clear the accident logs
        AccidentLog::truncate();

        return response()->json(['success' => true, 'message' => 'Statistik berhasil direset.']);
    }

    /**
     * Display a listing of the accident logs.
     */
    public function indexAccidents()
    {
        $accidentLogs = AccidentLog::orderBy('accident_date', 'desc')->paginate(15);
        return view('hse.admin_accidents', ['accidentLogs' => $accidentLogs]);
    }

    /**
     * Show the form for editing the specified accident log.
     */
    public function editAccident($id)
    {
        $accidentLog = AccidentLog::findOrFail($id);
        return view('hse.edit_accident', ['accidentLog' => $accidentLog]);
    }

    /**
     * Update the specified accident log in storage.
     */
    public function updateAccident(Request $request, $id)
    {
        $validated = $request->validate([
            'accident_date' => 'required|date',
            'description' => 'required|string',
        ]);

        $accidentLog = AccidentLog::findOrFail($id);
        $accidentLog->update($validated);

        return redirect()->route('hse.admin_accidents.index')->with('success', 'Data kecelakaan berhasil diperbarui.');
    }

    /**
     * Remove the specified accident log from storage.
     */
    public function destroyAccident($id)
    {
        $accidentLog = AccidentLog::findOrFail($id);
        $accidentLog->delete();

        // Decrement the counter in the main stats table
        $stats = HseStat::first();
        if ($stats && $stats->accident_count > 0) {
            $stats->decrement('accident_count');
        }

        return redirect()->route('hse.admin_accidents.index')->with('success', 'Data kecelakaan berhasil dihapus.');
    }
}