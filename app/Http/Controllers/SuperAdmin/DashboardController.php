<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Material;
use App\Models\Peminjaman;
use App\Models\HseStat;
use App\Models\AccidentLog;
use App\Models\KerusakanReport;
use App\Models\User;
use Carbon\Carbon;

class DashboardController extends Controller
{
    /**
     * Display a global dashboard for Super Admin.
     */
    public function index()
    {
        // --- Statistik ---
        $totalMaterial = Material::count();
        $totalPemesanan = Peminjaman::count();
        $totalUsers = User::count();
        $stokHampirHabis = Material::where('stok', '<', 10)->count();
        $hseStats = HseStat::first();
        $accidentCount = $hseStats ? $hseStats->accident_count : 0;
        $totalAccidentLogs = AccidentLog::count();

        // --- Material Orders Chart Data (Last 30 Days) ---
        $pemesananChartData = Peminjaman::selectRaw('DATE(created_at) as date, COUNT(*) as count')
            ->where('created_at', '>=', Carbon::now()->subDays(30))
            ->groupBy('date')
            ->orderBy('date', 'asc')
            ->pluck('count', 'date');

        $pemesananChartLabels = [];
        $pemesananChartValues = [];
        for ($i = 29; $i >= 0; $i--) {
            $date = Carbon::now()->subDays($i)->format('Y-m-d');
            $pemesananChartLabels[] = Carbon::parse($date)->format('M j');
            $pemesananChartValues[] = $pemesananChartData[$date] ?? 0;
        }

        $pemesananChart = [
            'labels' => $pemesananChartLabels,
            'data' => $pemesananChartValues,
        ];

        // --- Recent Activities ---
        $latestPeminjaman = Peminjaman::with('user')->latest()->take(5)->get()->map(function($item) {
            return [
                'type' => 'Permintaan Baru',
                'description' => 'Permintaan/peminjaman material oleh ' . ($item->user->name ?? 'N/A'),
                'timestamp' => $item->created_at,
                'user_name' => $item->user->name ?? 'N/A',
                'icon' => 'shopping-cart'
            ];
        });

        $latestKerusakan = KerusakanReport::with(['peminjamanDetail.peminjaman.user', 'peminjamanDetail.material'])->latest()->take(5)->get()->map(function($item) {
            return [
                'type' => 'Laporan Kerusakan',
                'description' => 'Laporan kerusakan material ' . ($item->peminjamanDetail->material->nama_material ?? 'N/A'),
                'timestamp' => $item->created_at,
                'user_name' => $item->peminjamanDetail->peminjaman->user->name ?? 'N/A',
                'icon' => 'exclamation-triangle'
            ];
        });

        $latestAccidents = AccidentLog::latest('accident_date')->take(5)->get()->map(function($item) {
            return [
                'type' => 'Kecelakaan Kerja',
                'description' => \Illuminate\Support\Str::limit($item->description, 50),
                'timestamp' => $item->accident_date,
                'user_name' => 'Admin HSE',
                'icon' => 'first-aid'
            ];
        });

        $latestUsers = User::latest()->take(5)->get()->map(function($item) {
            return [
                'type' => 'Pengguna Baru',
                'description' => 'Pengguna baru telah terdaftar: ' . $item->name,
                'timestamp' => $item->created_at,
                'user_name' => $item->name,
                'icon' => 'user-plus'
            ];
        });

        $recentActivities = collect($latestPeminjaman)
            ->merge($latestKerusakan)
            ->merge($latestAccidents)
            ->merge($latestUsers)
            ->sortByDesc('timestamp')
            ->take(10); 

        return view('superadmin.dashboard', compact(
            'totalMaterial',
            'totalPemesanan',
            'totalUsers',
            'stokHampirHabis',
            'accidentCount',
            'totalAccidentLogs',
            'recentActivities',
            'pemesananChart'
        ));
    }

    /**
     * Display a read-only listing of the materials.
     */
    public function monitoringMaterial(Request $request)
    {
        $search = $request->input('search');
        $sortBy = $request->input('sort_by', 'nama_material');
        $sortDirection = $request->input('sort_direction', 'asc');

        $allowedSortColumns = ['nama_material', 'stok', 'satuan', 'jenis_kebutuhan', 'lokasi'];

        if (!in_array($sortBy, $allowedSortColumns)) {
            $sortBy = 'nama_material';
        }
        if (!in_array($sortDirection, ['asc', 'desc'])) {
            $sortDirection = 'asc';
        }

        $materials = Material::when($search, function ($query, $search) {
            return $query->where('nama_material', 'like', '%' . $search . '%');
        })
        ->orderBy($sortBy, $sortDirection)
        ->get();

        if ($request->ajax()) {
            return response()->json(['materials' => $materials]);
        }

        return view('superadmin.monitoring.material', compact('materials', 'search', 'sortBy', 'sortDirection'));
    }

    /**
     * Display the specified material.
     */
    public function showMaterial(string $id)
    {
        $material = Material::findOrFail($id);
        return response()->json($material);
    }

    /**
     * Display a read-only listing of the borrowing history.
     */
    public function monitoringRiwayat()
    {
        $peminjamans = Peminjaman::with('user', 'details.material')->latest()->get();
        return view('superadmin.monitoring.riwayat', compact('peminjamans'));
    }

    /**
     * Display the specified borrowing history.
     */
    public function showRiwayat(string $id)
    {
        $peminjaman = Peminjaman::with('user', 'details.material')->findOrFail($id);
        return response()->json($peminjaman);
    }

    /**
     * Display a read-only listing of the damage reports.
     */
    public function monitoringKerusakan()
    {
        $kerusakanReports = KerusakanReport::with('peminjamanDetail.peminjaman.user', 'peminjamanDetail.material')->latest()->get();
        return view('superadmin.monitoring.kerusakan', compact('kerusakanReports'));
    }

    /**
     * Display a read-only listing of the accident logs.
     */
    public function monitoringKecelakaan()
    {
        $accidentLogs = AccidentLog::orderBy('accident_date', 'desc')->paginate(15);
        return view('superadmin.monitoring.kecelakaan', compact('accidentLogs'));
    }
}
