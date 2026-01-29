@extends('layouts.app')

@section('title', 'Monitoring Riwayat Kecelakaan Kerja')

@section('content')
<x-card>
    {{-- Card Header --}}
    <div class="border-b border-slate-200 p-6">
        <div class="flex flex-wrap items-center justify-between gap-4">
            <div class="w-full md:w-auto">
                <h3 class="text-xl font-semibold text-slate-800">Monitoring Riwayat Kecelakaan Kerja</h3>
                <p class="mt-1 text-sm text-slate-600">Melihat semua data kecelakaan kerja yang pernah tercatat dalam mode read-only.</p>
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
                            <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-slate-900">Tanggal Kecelakaan</th>
                            <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-slate-900">Deskripsi</th>
                            <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-slate-900">Tanggal Dicatat</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-200 bg-white">
                        @forelse ($accidentLogs as $log)
                        <tr>
                            <td class="whitespace-nowrap py-4 pl-4 pr-3 text-sm font-medium text-slate-900 sm:pl-6">{{ $log->id }}</td>
                            <td class="whitespace-nowrap px-3 py-4 text-sm text-slate-500">{{ \Carbon\Carbon::parse($log->accident_date)->format('d M Y') }}</td>
                            <td class="whitespace-pre-wrap px-3 py-4 text-sm text-slate-500 max-w-sm">{{ $log->description }}</td>
                            <td class="whitespace-nowrap px-3 py-4 text-sm text-slate-500">{{ \Carbon\Carbon::parse($log->created_at)->format('d M Y, H:i') }}</td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="4" class="text-center py-4 text-sm text-slate-500">Tidak ada data kecelakaan.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
                <div class="p-4">
                    {{ $accidentLogs->links() }}
                </div>
            </div>
        </div>
    </div>
</x-card>
@endsection
