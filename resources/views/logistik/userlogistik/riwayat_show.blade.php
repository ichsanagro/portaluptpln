@extends('layouts.app')

@section('title', 'Detail Riwayat Peminjaman')

@section('content')
<x-card>
    <div class="border-b border-slate-200 p-6 flex justify-between items-center">
        <div>
            <h3 class="text-xl font-semibold text-slate-800">Detail Riwayat Peminjaman</h3>
            <p class="mt-1 text-sm text-slate-600">Detail untuk Peminjaman ID #{{ $peminjaman->id }}</p>
        </div>
        <div>
            <a href="{{ route('logistik.userlogistik.riwayat') }}" class="inline-flex items-center justify-center rounded-md border border-slate-300 bg-white px-4 py-2 text-sm font-medium text-slate-700 shadow-sm hover:bg-slate-50 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">
                Kembali
            </a>
        </div>
    </div>

    <div class="p-6">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
                <h4 class="font-semibold text-slate-800">Informasi Peminjam</h4>
                <dl class="mt-2 divide-y divide-slate-200">
                    <div class="py-3 flex justify-between text-sm font-medium">
                        <dt class="text-slate-500">Nama</dt>
                        <dd class="text-slate-900">{{ $peminjaman->user->name }}</dd>
                    </div>
                    <div class="py-3 flex justify-between text-sm font-medium">
                        <dt class="text-slate-500">Email</dt>
                        <dd class="text-slate-900">{{ $peminjaman->user->email }}</dd>
                    </div>
                    <div class="py-3 flex justify-between text-sm font-medium">
                        <dt class="text-slate-500">Tanggal Pengajuan</dt>
                        <dd class="text-slate-900">{{ $peminjaman->created_at->format('d M Y, H:i') }}</dd>
                    </div>
                    <div class="py-3 flex justify-between text-sm font-medium">
                        <dt class="text-slate-500">Jenis</dt>
                        <dd class="text-slate-900">{{ ucfirst($peminjaman->jenis_peminjaman) }}</dd>
                    </div>
                    <div class="py-3 flex justify-between text-sm font-medium items-center">
                        <dt class="text-slate-500">Status</dt>
                        <dd>
                            <span class="inline-flex items-center rounded-full px-2.5 py-0.5 text-xs font-medium {{
                                $peminjaman->status === 'pending' ? 'bg-yellow-100 text-yellow-800' :
                                ($peminjaman->status === 'approved' ? 'bg-green-100 text-green-800' :
                                ($peminjaman->status === 'completed' ? 'bg-blue-100 text-blue-800' :
                                ($peminjaman->status === 'rejected' ? 'bg-red-100 text-red-800' :
                                'bg-gray-100 text-gray-800')))
                            }}">
                                {{ ucfirst($peminjaman->status) }}
                            </span>
                        </dd>
                    </div>
                </dl>
            </div>
        </div>

        <div class="mt-8">
            <h4 class="font-semibold text-slate-800">Detail Material</h4>
            <div class="mt-4 flow-root">
                <div class="-my-2 -mx-4 overflow-x-auto sm:-mx-6 lg:-mx-8">
                    <div class="inline-block min-w-full py-2 align-middle sm:px-6 lg:px-8">
                        <table class="min-w-full divide-y divide-slate-200">
                            <thead class="bg-slate-50">
                                <tr>
                                    <th scope="col" class="py-3.5 pl-4 pr-3 text-left text-sm font-semibold text-slate-900 sm:pl-6">Nama Material</th>
                                    <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-slate-900">Jumlah Diminta</th>
                                    <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-slate-900">Jumlah Kembali</th>
                                    <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-slate-900">Catatan</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-slate-200 bg-white">
                                @foreach ($peminjaman->details as $detail)
                                <tr>
                                    <td class="whitespace-nowrap py-4 pl-4 pr-3 text-sm font-medium text-slate-900 sm:pl-6">{{ $detail->material->nama_material }}</td>
                                    <td class="whitespace-nowrap px-3 py-4 text-sm text-slate-500">{{ $detail->jumlah }} {{ $detail->material->satuan }}</td>
                                    <td class="whitespace-nowrap px-3 py-4 text-sm text-slate-500">{{ $detail->returned_jumlah ?? 0 }} {{ $detail->material->satuan }}</td>
                                    <td class="whitespace-pre-wrap px-3 py-4 text-sm text-slate-500">{{ $detail->catatan ?: '-' }}</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-card>
@endsection
