@extends('layouts.app')

@section('title', '')

@push('header-items')
    @include('components.hse-stats-small')
@endpush

@section('content')
    <div class="space-y-8">
        {{-- Welcome Header --}}
        <x-card class="p-6">
            <h2 class="text-2xl font-bold text-blue-800">Selamat Datang, Admin Logistik!</h2>
            <p class="mt-1 text-gray-700">Berikut adalah ringkasan aktivitas logistik terkini di sistem Anda.</p>
        </x-card>

        {{-- Stats Cards --}}
        <div class="grid grid-cols-1 gap-5 sm:grid-cols-2 lg:grid-cols-4">
            <x-stat-card title="Total Material" value="1,250" icon_bg_color="bg-blue-100" icon_text_color="text-blue-800">
                <x-slot name="icon">
                    <svg class="h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M20.25 7.5l-.625 10.632a2.25 2.25 0 01-2.247 2.118H6.622a2.25 2.25 0 01-2.247-2.118L3.75 7.5M10 11.25h4M3.375 7.5h17.25c.621 0 1.125-.504 1.125-1.125v-1.5c0-.621-.504-1.125-1.125-1.125H3.375c-.621 0-1.125.504-1.125 1.125v1.5c0 .621.504 1.125 1.125 1.125z" />
                    </svg>
                </x-slot>
            </x-stat-card>
            <x-stat-card title="Permintaan Pending" value="12" icon_bg_color="bg-yellow-100" icon_text_color="text-yellow-800">
                <x-slot name="icon">
                     <svg class="h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </x-slot>
            </x-stat-card>
            <x-stat-card title="Permintaan Disetujui" value="35" icon_bg_color="bg-green-100" icon_text_color="text-green-600">
                <x-slot name="icon">
                    <svg class="h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </x-slot>
            </x-stat-card>
            <x-stat-card title="Stok Hampir Habis" value="8" icon_bg_color="bg-red-100" icon_text_color="text-red-600">
                <x-slot name="icon">
                    <svg class="h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 18L9 11.25l4.306 4.307a11.95 11.95 0 015.814-5.519l2.74-1.22m0 0l-3.75-3.75M14.25 12l-3.75-3.75" />
                    </svg>
                </x-slot>
            </x-stat-card>
        </div>
    </div>
@endsection
