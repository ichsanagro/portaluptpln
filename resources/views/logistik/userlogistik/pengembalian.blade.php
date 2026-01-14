@extends('layouts.app')

@section('title', 'Pengembalian Material')

@section('content')
<x-card>
    <div class="border-b border-slate-200 p-6">
        <h3 class="text-xl font-semibold text-slate-800">Pengembalian Material</h3>
        <p class="mt-1 text-sm text-slate-600">Pilih material yang ingin Anda kembalikan dan tentukan jumlahnya.</p>
    </div>

    @if (session('success'))
        <div class="rounded-md bg-green-50 p-4 mb-4">
            <div class="flex">
                <div class="flex-shrink-0">
                    <svg class="h-5 w-5 text-green-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                    </svg>
                </div>
                <div class="ml-3">
                    <p class="text-sm font-medium text-green-800">{{ session('success') }}</p>
                </div>
            </div>
        </div>
    @endif

    @if ($errors->any())
        <div class="rounded-md bg-red-50 p-4 mb-4">
            <div class="flex">
                <div class="flex-shrink-0">
                    <svg class="h-5 w-5 text-red-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.28 7.22a.75.75 0 00-1.06 1.06L8.94 10l-1.72 1.72a.75.75 0 101.06 1.06L10 11.06l1.72 1.72a.75.75 0 101.06-1.06L11.06 10l1.72-1.72a.75.75 0 00-1.06-1.06L10 8.94l-1.72-1.72z" clip-rule="evenodd" />
                    </svg>
                </div>
                <div class="ml-3">
                    <h3 class="text-sm font-medium text-red-800">Terdapat kesalahan:</h3>
                    <ul class="mt-1.5 list-disc list-inside text-sm text-red-700">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
    @endif

    @if ($peminjamanToReturn->isEmpty())
        <div class="p-6 text-center text-gray-500 italic">
            <p>Tidak ada material yang perlu dikembalikan saat ini.</p>
            <p class="text-sm">Pastikan Anda memiliki peminjaman yang disetujui.</p>
        </div>
    @else
        @foreach ($peminjamanToReturn as $peminjaman)
            <form action="{{ route('logistik.userlogistik.pengembalian.store') }}" method="POST" class="mb-8 border border-slate-200 rounded-lg shadow-sm">
                @csrf
                <input type="hidden" name="peminjaman_id" value="{{ $peminjaman->id }}">
                <div class="bg-slate-50 px-4 py-3 sm:px-6">
                    <h4 class="text-lg font-semibold text-slate-800">
                        Peminjaman #{{ $peminjaman->id }}
                        <span class="font-normal text-slate-500">({{ \Carbon\Carbon::parse($peminjaman->created_at)->format('d M Y H:i') }})</span>
                    </h4>
                </div>
                <div class="flow-root">
                    <div class="-my-2 -mx-4 overflow-x-auto sm:-mx-6 lg:-mx-8">
                        <div class="inline-block min-w-full py-2 align-middle sm:px-6 lg:px-8">
                            <table class="min-w-full divide-y divide-slate-200">
                                <thead class="bg-slate-50">
                                    <tr>
                                        <th scope="col" class="py-3.5 pl-4 pr-3 text-left text-sm font-semibold text-slate-900 sm:pl-6">Material</th>
                                        <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-slate-900">Dipinjam (Jumlah)</th>
                                        <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-slate-900">Sudah Kembali</th>
                                        <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-slate-900">Jumlah Kembali</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white">
                                    @foreach ($peminjaman->details as $item)
                                        <tr>
                                            <td class="whitespace-nowrap py-4 pl-4 pr-3 text-sm font-medium text-slate-900 sm:pl-6">
                                                {{ $item->material->nama_material }}
                                                @if ($item->material->jenis_kebutuhan === 'permintaan')
                                                    <span class="block text-xs italic text-orange-600">(Permintaan - Tidak perlu dikembalikan)</span>
                                                @endif
                                            </td>
                                            <td class="whitespace-nowrap px-3 py-4 text-sm text-slate-500">{{ $item->jumlah }} {{ $item->material->satuan }}</td>
                                            @if ($item->material->jenis_kebutuhan === 'peminjaman')
                                                <td class="whitespace-nowrap px-3 py-4 text-sm text-slate-500">{{ $item->returned_jumlah }} {{ $item->material->satuan }}</td>
                                                <td class="whitespace-nowrap px-3 py-4 text-sm text-slate-500">
                                                    <input type="number" name="returns[{{ $item->id }}][quantity]"
                                                           min="0"
                                                           max="{{ $item->jumlah - $item->returned_jumlah }}"
                                                           value="0"
                                                           class="block w-24 rounded-md border-0 py-1.5 text-slate-900 shadow-sm ring-1 ring-inset ring-slate-300 focus:ring-2 focus:ring-inset focus:ring-blue-600 sm:text-sm" />
                                                    <input type="hidden" name="returns[{{ $item->id }}][peminjaman_detail_id]" value="{{ $item->id }}" />
                                                </td>
                                            @else
                                                <td class="whitespace-nowrap px-3 py-4 text-sm text-slate-500">-</td>
                                                <td class="whitespace-nowrap px-3 py-4 text-sm text-slate-500">-</td>
                                            @endif
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="mt-6 flex items-center justify-end gap-x-6 px-6 pb-4">
                    <x-primary-button type="submit">
                        Proses Pengembalian
                    </x-primary-button>
                </div>
            </form>
        @endforeach
    @endif
</x-card>
@endsection