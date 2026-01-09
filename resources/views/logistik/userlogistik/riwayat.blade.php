@extends('layouts.app')

@section('title', 'Riwayat Peminjaman')

@section('content')
<x-card>
    <div class="border-b border-slate-200 p-6">
        <h3 class="text-xl font-semibold text-slate-800">Riwayat Peminjaman Material</h3>
        <p class="mt-1 text-sm text-slate-600">Daftar semua material yang pernah Anda pinjam.</p>
    </div>

    @if ($riwayatPeminjaman->isEmpty())
        <div class="p-6 text-center text-gray-500 italic">
            <p>Belum ada riwayat peminjaman.</p>
        </div>
    @else
        <div class="flow-root">
            <div class="-my-2 -mx-4 overflow-x-auto sm:-mx-6 lg:-mx-8">
                <div class="inline-block min-w-full py-2 align-middle sm:px-6 lg:px-8">
                    <table class="min-w-full divide-y divide-slate-200">
                        <thead class="bg-slate-50">
                            <tr>
                                <th scope="col" class="py-3.5 pl-4 pr-3 text-left text-sm font-semibold text-slate-900 sm:pl-6">ID Peminjaman</th>
                                <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-slate-900">Tanggal Peminjaman</th>
                                <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-slate-900">Status</th>
                                <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-slate-900">Detail Material</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-200 bg-white">
                            @foreach ($riwayatPeminjaman as $peminjaman)
                            <tr>
                                <td class="whitespace-nowrap py-4 pl-4 pr-3 text-sm font-medium text-slate-900 sm:pl-6">{{ $peminjaman->id }}</td>
                                <td class="whitespace-nowrap px-3 py-4 text-sm text-slate-500">{{ \Carbon\Carbon::parse($peminjaman->tanggal_peminjaman)->format('d M Y H:i') }}</td>
                                <td class="whitespace-nowrap px-3 py-4 text-sm text-slate-500">
                                    <span class="inline-flex items-center rounded-full px-2.5 py-0.5 text-xs font-medium {{
                                        $peminjaman->status === 'pending' ? 'bg-yellow-100 text-yellow-800' :
                                        ($peminjaman->status === 'approved' ? 'bg-green-100 text-green-800' :
                                        'bg-gray-100 text-gray-800')
                                    }}">
                                        {{ ucfirst($peminjaman->status) }}
                                    </span>
                                </td>
                                <td class="px-3 py-4 text-sm text-slate-500">
                                    <ul class="list-disc pl-5 space-y-1">
                                        @foreach ($peminjaman->details as $detail)
                                            <li>{{ $detail->material->nama_material }} ({{ $detail->jumlah }} {{ $detail->material->satuan }})</li>
                                        @endforeach
                                    </ul>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    @endif
</x-card>
@endsection
