<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Material;
use App\Models\Peminjaman;
use App\Models\HseStat;
use App\Models\AccidentLog;
use App\Models\KerusakanReport;

class DashboardController extends Controller
{
    /**
     * Display a global dashboard for Super Admin.
     */
    public function index()
    {
        // Logistik Data
        $totalMaterial = Material::count();
        $permintaanPending = Peminjaman::where('status', 'pending')->count();
        $permintaanDisetujui = Peminjaman::where('status', 'approved')->count();
        $stokHampirHabis = Material::where('stok', '<', 10)->count(); // Define low stock threshold as < 10

        // HSE Data
        $hseStats = HseStat::first(); // Assuming there's only one record for HSE statistics
        $safeWorkingDays = $hseStats ? $hseStats->safe_working_days : 0;
        $accidentCount = $hseStats ? $hseStats->accident_count : 0;
        $totalAccidentLogs = AccidentLog::count();

        // Pass data to the view
        return view('superadmin.dashboard', compact(
            'totalMaterial',
            'permintaanPending',
            'permintaanDisetujui',
            'stokHampirHabis',
            'safeWorkingDays',
            'accidentCount',
            'totalAccidentLogs'
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
