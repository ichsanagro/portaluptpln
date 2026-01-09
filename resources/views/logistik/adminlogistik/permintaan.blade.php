@extends('layouts.app')

@section('title', 'Permintaan Material')

@section('content')
<x-card>
    {{-- Card Header --}}
    <div class="border-b border-slate-200 p-6">
        <div class="flex flex-wrap items-center justify-between gap-4">
            <div class="w-full md:w-auto">
                <h3 class="text-xl font-semibold text-slate-800">Daftar Permintaan</h3>
                <p class="mt-1 text-sm text-slate-600">Kelola permintaan material yang diajukan oleh user.</p>
            </div>
            <div class="w-full sm:w-auto">
                {{-- Search Box --}}
                <div class="relative">
                    <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3">
                         <svg class="h-5 w-5 text-slate-400" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-5.197-5.197m0 0A7.5 7.5 0 105.196 5.196a7.5 7.5 0 0010.607 10.607z" />
                        </svg>
                    </div>
                    <input type="text" name="search" id="search" class="block w-full rounded-md border-0 py-2.5 pl-10 text-slate-900 ring-1 ring-inset ring-slate-300 placeholder:text-slate-400 focus:ring-2 focus:ring-inset focus:ring-blue-600 sm:text-sm sm:leading-6" placeholder="Cari permintaan...">
                </div>
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
                            <th scope="col" class="py-3.5 pl-4 pr-3 text-left text-sm font-semibold text-slate-900 sm:pl-6">Tanggal</th>
                            <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-slate-900">User</th>
                            <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-slate-900">Material</th>
                            <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-slate-900">Jumlah</th>
                            <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-slate-900">Status</th>
                            <th scope="col" class="relative py-3.5 pl-3 pr-4 sm:pr-6">
                                <span class="sr-only">Aksi</span>
                            </th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-200 bg-white">
                        @forelse ($permintaanPeminjaman as $peminjaman)
                        <tr>
                            <td class="whitespace-nowrap py-4 pl-4 pr-3 text-sm text-slate-500 sm:pl-6">
                                {{ \Carbon\Carbon::parse($peminjaman->tanggal_peminjaman)->format('d M Y H:i') }}
                            </td>
                            <td class="whitespace-nowrap px-3 py-4 text-sm font-medium text-slate-900">
                                {{ $peminjaman->user->name ?? 'N/A' }}
                            </td>
                            <td class="px-3 py-4 text-sm text-slate-500">
                                <ul class="list-disc pl-5 space-y-1">
                                    @foreach ($peminjaman->details as $detail)
                                        <li>{{ $detail->material->nama_material }} ({{ $detail->jumlah }} {{ $detail->material->satuan }})</li>
                                    @endforeach
                                </ul>
                            </td>
                            <td class="whitespace-nowrap px-3 py-4 text-sm text-slate-500">{{ $peminjaman->details->sum('jumlah') }}</td>
                            <td class="whitespace-nowrap px-3 py-4 text-sm text-slate-500">
                                <span class="inline-flex items-center rounded-full px-2.5 py-0.5 text-xs font-medium {{
                                    $peminjaman->status === 'pending' ? 'bg-yellow-100 text-yellow-800' :
                                    ($peminjaman->status === 'approved' ? 'bg-green-100 text-green-800' :
                                    ($peminjaman->status === 'rejected' ? 'bg-red-100 text-red-800' :
                                    'bg-gray-100 text-gray-800'))
                                }}">
                                    {{ ucfirst($peminjaman->status) }}
                                </span>
                            </td>
                            <td class="relative space-x-2 whitespace-nowrap py-4 pl-3 pr-4 text-right text-sm font-medium sm:pr-6">
                                @if ($peminjaman->status === 'pending')
                                    <form action="{{ route('logistik.adminlogistik.permintaan.approve', $peminjaman->id) }}" method="POST" class="inline">
                                        @csrf
                                        <button type="submit" class="rounded-md bg-green-600 px-3 py-1 text-xs font-semibold text-white shadow-sm hover:bg-green-500" onclick="return confirm('Anda yakin ingin menyetujui permintaan ini?')">Setuju</button>
                                    </form>
                                    <form action="{{ route('logistik.adminlogistik.permintaan.reject', $peminjaman->id) }}" method="POST" class="inline">
                                        @csrf
                                        <button type="submit" class="rounded-md bg-red-600 px-3 py-1 text-xs font-semibold text-white shadow-sm hover:bg-red-500" onclick="return confirm('Anda yakin ingin menolak permintaan ini? Stok material akan dikembalikan.')">Tolak</button>
                                    </form>
                                @else
                                    <span class="text-slate-400">-</span>
                                @endif
                            </td>
                        </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="p-6 text-center text-gray-500 italic">Tidak ada permintaan peminjaman baru.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-card>
@endsection