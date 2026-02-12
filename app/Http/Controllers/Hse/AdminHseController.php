<?php

namespace App\Http\Controllers\Hse;

use App\Http\Controllers\Controller;
use App\Models\AccidentLog;
use App\Models\HseStat;
use App\Models\PlaylistVideo;
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
        ]);
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

    public function playlist()
    {
        $files = PlaylistVideo::orderBy('order')->get();
        return view('hse.admin.playlist', compact('files'));
    }

    public function playlistStore(Request $request)
    {
        // Handle YouTube Links
        if ($request->has('links')) {
            $validated = $request->validate([
                'links' => 'required|string',
            ]);

            $links = preg_split('/\\r\\n|\\n|\\r/', $validated['links']);
            $links = array_filter($links); // Remove empty lines

            if (empty($links)) {
                return back()->withErrors(['links' => 'Kolom link tidak boleh kosong.']);
            }

            foreach ($links as $link) {
                $videoId = $this->getYouTubeVideoId($link);

                if ($videoId) {
                    PlaylistVideo::create([
                        'path' => $videoId,
                        'original_name' => $link,
                        'type' => 'youtube',
                        'order' => PlaylistVideo::max('order') + 1,
                    ]);
                }
            }

            return back()->with('success', 'YouTube video(s) added successfully.');
        }

        // Handle File Uploads
        if ($request->hasFile('files')) {
            $request->validate([
                'files.*' => 'required|mimetypes:video/mp4,video/avi,video/mpeg,image/jpeg,image/png,image/jpg,image/gif,image/svg|max:5242880', // 5GB Max
            ]);

            foreach ($request->file('files') as $file) {
                $path = $file->store('playlist_files', 'public');
                $type = str_starts_with($file->getMimeType(), 'video') ? 'video' : 'image';

                PlaylistVideo::create([
                    'path' => $path,
                    'original_name' => $file->getClientOriginalName(),
                    'type' => $type,
                    'order' => PlaylistVideo::max('order') + 1,
                ]);
            }
            return back()->with('success', 'Files uploaded successfully.');
        }

        return back()->withErrors(['files' => 'Tidak ada file atau link yang diberikan.']);
    }

    private function getYouTubeVideoId(string $url): ?string
    {
        $pattern = '%(?:youtube(?:-nocookie)?\.com/(?:[^/]+/.+/|(?:v|e(?:mbed)?)/|.*[?&]v=)|youtu\.be/)([^"&?/ ]{11})%i';
        if (preg_match($pattern, $url, $match)) {
            return $match[1];
        }
        return null;
    }

    public function playlistDestroy($id)
    {
        $file = PlaylistVideo::findOrFail($id);
        Storage::disk('public')->delete($file->path);
        $file->delete();

        return back()->with('success', 'File deleted successfully.');
    }

    public function playlistUpdateOrder(Request $request)
    {
        $request->validate([
            'order' => 'required|array',
            'order.*' => 'integer',
        ]);

        foreach ($request->order as $index => $id) {
            PlaylistVideo::where('id', $id)->update(['order' => $index]);
        }

        return response()->json(['status' => 'success']);
    }
}