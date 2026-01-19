@extends('layouts.app')

@section('title', 'Dashboard User Logistik')

@push('header-items')
    @include('components.hse-stats-small')
@endpush

@section('content')
<div class="space-y-6">
    {{-- Welcome Header --}}
    <x-card class="p-6">
        <h2 class="text-2xl font-bold text-blue-800">Selamat Datang, {{ Auth::user()->name }}!</h2>
        <p class="mt-1 text-gray-700">Ini adalah dashboard logistik Anda. Ajukan peminjaman atau pengembalian material dengan mudah.</p>
    </x-card>

    {{-- Quick Actions --}}
    <div class="grid grid-cols-1 gap-4 sm:grid-cols-2 lg:grid-cols-4">
        <a href="{{ route('logistik.userlogistik.peminjaman') }}" class="group block rounded-lg bg-blue-600 p-6 text-white shadow-lg transition hover:bg-blue-700">
            <h3 class="text-lg font-semibold">Buat Peminjaman</h3>
            <p class="mt-1 text-sm text-blue-200">Pinjam material atau peralatan untuk kebutuhan Anda.</p>
        </a>
        <a href="{{ route('logistik.userlogistik.permintaan') }}" class="group block rounded-lg bg-indigo-600 p-6 text-white shadow-lg transition hover:bg-indigo-700">
            <h3 class="text-lg font-semibold">Buat Permintaan</h3>
            <p class="mt-1 text-sm text-indigo-200">Minta material habis pakai untuk pekerjaan.</p>
        </a>
        <a href="{{ route('logistik.userlogistik.pengembalian') }}" class="group block rounded-lg bg-green-600 p-6 text-white shadow-lg transition hover:bg-green-700">
            <h3 class="text-lg font-semibold">Kembalikan Material</h3>
            <p class="mt-1 text-sm text-green-200">Kembalikan material yang sudah selesai dipinjam.</p>
        </a>
         <a href="{{ route('logistik.userlogistik.kerusakan') }}" class="group block rounded-lg bg-red-600 p-6 text-white shadow-lg transition hover:bg-red-700">
            <h3 class="text-lg font-semibold">Laporkan Kerusakan</h3>
            <p class="mt-1 text-sm text-red-200">Laporkan jika ada material yang rusak saat peminjaman.</p>
        </a>
    </div>

    {{-- Stats and Recent Activities --}}
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        {{-- User Stats --}}
        <div class="lg:col-span-1 space-y-6">
            <x-card class="p-6">
                <h3 class="text-lg font-semibold text-slate-800">Status Saya</h3>
                <div class="mt-4 space-y-4">
                    <div class="flex items-center justify-between rounded-md border border-yellow-200 bg-yellow-50 p-4">
                        <div>
                            <p class="text-sm font-medium text-yellow-800">Permintaan Pending</p>
                            <p class="text-2xl font-bold text-yellow-900">{{ $myPendingRequests }}</p>
                        </div>
                        <span class="rounded-full bg-yellow-200 p-2 text-yellow-800">
                            <svg class="h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                        </span>
                    </div>
                    <div class="flex items-center justify-between rounded-md border border-green-200 bg-green-50 p-4">
                        <div>
                            <p class="text-sm font-medium text-green-800">Permintaan Disetujui</p>
                            <p class="text-2xl font-bold text-green-900">{{ $myApprovedRequests }}</p>
                        </div>
                        <span class="rounded-full bg-green-200 p-2 text-green-800">
                           <svg class="h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                        </span>
                    </div>
                     <div class="flex items-center justify-between rounded-md border border-blue-200 bg-blue-50 p-4">
                        <div>
                            <p class="text-sm font-medium text-blue-800">Total Item Dipinjam</p>
                            <p class="text-2xl font-bold text-blue-900">{{ $myBorrowedItems }}</p>
                        </div>
                        <span class="rounded-full bg-blue-200 p-2 text-blue-800">
                           <svg class="h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M20.25 7.5l-.625 10.632a2.25 2.25 0 01-2.247 2.118H6.622a2.25 2.25 0 01-2.247-2.118L3.75 7.5M10 11.25h4M3.375 7.5h17.25c.621 0 1.125-.504 1.125-1.125v-1.5c0-.621-.504-1.125-1.125-1.125H3.375c-.621 0-1.125.504-1.125 1.125v1.5c0 .621.504 1.125 1.125 1.125z" /></svg>
                        </span>
                    </div>
                </div>
            </x-card>
        </div>

        {{-- Recent Activities --}}
        <x-card class="lg:col-span-2">
            <div class="p-6">
                <h3 class="text-lg font-semibold text-slate-800">Aktivitas Peminjaman Terkini Saya</h3>
                <div class="mt-4 flow-root">
                    <ul class="-mb-8">
                        @forelse ($recentActivities as $index => $activity)
                            <li>
                                <div class="relative pb-8">
                                    @if (!$loop->last)
                                        <span class="absolute left-4 top-4 -ml-px h-full w-0.5 bg-slate-200" aria-hidden="true"></span>
                                    @endif
                                    <div class="relative flex space-x-3">
                                        <div>
                                            <span class="h-8 w-8 rounded-full flex items-center justify-center ring-8 ring-white {{ $activity->status === 'approved' ? 'bg-green-500' : ($activity->status === 'pending' ? 'bg-yellow-500' : 'bg-red-500') }}">
                                                <svg class="h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm.75-13a.75.75 0 00-1.5 0v5c0 .414.336.75.75.75h4a.75.75 0 000-1.5h-3.25V5z" clip-rule="evenodd" />
                                                </svg>
                                            </span>
                                        </div>
                                        <div class="flex min-w-0 flex-1 justify-between space-x-4 pt-1.5">
                                            <div>
                                                <p class="text-sm text-slate-500">
                                                    Mengajukan {{ $activity->jenis_peminjaman }} untuk
                                                    <span class="font-medium text-slate-900">{{ $activity->details->count() }} jenis material</span>
                                                </p>
                                            </div>
                                            <div class="whitespace-nowrap text-right text-sm text-slate-500">
                                                <time datetime="{{ $activity->created_at->toDateTimeString() }}">{{ $activity->created_at->diffForHumans() }}</time>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </li>
                        @empty
                            <li class="text-sm text-center text-slate-500">Tidak ada aktivitas terkini.</li>
                        @endforelse
                    </ul>
                </div>
            </div>
        </x-card>
    </div>
</div>
@endsection