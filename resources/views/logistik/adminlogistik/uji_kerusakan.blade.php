@extends('layouts.app')

@section('title', 'Uji Kerusakan Material')

@section('content')
<x-card>
    {{-- Card Header --}}
    <div class="border-b border-slate-200 p-6">
        <div class="flex flex-wrap items-center justify-between gap-4">
            <div class="w-full md:w-auto">
                <h3 class="text-xl font-semibold text-slate-800">Daftar Laporan Kerusakan</h3>
                <p class="mt-1 text-sm text-slate-600">Berikut adalah daftar semua laporan kerusakan material dari user.</p>
            </div>
        </div>
    </div>

    {{-- Table --}}
    <div class="flow-root">
        <div class="-my-2 -mx-4 overflow-x-auto sm:-mx-6 lg:-mx-8">
            <div class="inline-block min-w-full py-2 align-middle sm:px-6 lg:px-8">
                <table class="min-w-full divide-y divide-slate-200">
                    <thead class="bg-slate-50">
                        <tr>
                            <th scope="col" class="py-3.5 pl-4 pr-3 text-left text-sm font-semibold text-slate-900 sm:pl-6">ID</th>
                            <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-slate-900">Nama Material</th>
                            <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-slate-900">Jumlah Rusak</th>
                            <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-slate-900">Pelapor</th>
                            <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-slate-900">Catatan</th>
                            <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-slate-900">Bukti</th>
                            <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-slate-900">Tanggal Laporan</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-200 bg-white">
                        @forelse ($kerusakanReports as $report)
                        <tr>
                            <td class="whitespace-nowrap py-4 pl-4 pr-3 text-sm font-medium text-slate-900 sm:pl-6">{{ $report->id }}</td>
                            <td class="whitespace-nowrap px-3 py-4 text-sm text-slate-500">{{ $report->peminjamanDetail->material->nama_material ?? 'N/A' }}</td>
                            <td class="whitespace-nowrap px-3 py-4 text-sm text-slate-500">{{ $report->jumlah_rusak }}</td>
                            <td class="whitespace-nowrap px-3 py-4 text-sm text-slate-500">{{ $report->peminjamanDetail->peminjaman->user->name ?? 'N/A' }}</td>
                            <td class="whitespace-nowrap px-3 py-4 text-sm text-slate-500">{{ $report->catatan ?? '-' }}</td>
                            <td class="whitespace-nowrap px-3 py-4 text-sm text-slate-500">
                                <a href="{{ asset('storage/' . $report->file_path) }}" target="_blank" class="text-blue-600 hover:text-blue-900">Lihat Bukti</a>
                            </td>
                            <td class="whitespace-nowrap px-3 py-4 text-sm text-slate-500">{{ $report->created_at->format('d M Y, H:i') }}</td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="7" class="whitespace-nowrap px-3 py-4 text-sm text-slate-500 text-center">
                                Tidak ada laporan kerusakan.
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-card>
@endsection
