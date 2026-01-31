@extends('layouts.app')

@section('title', 'Monitoring IOT - ' . $substation->name)

@section('content')
<div class="max-w-7xl mx-auto">
    <h2 class="text-2xl font-bold text-blue-800 mb-6">Monitoring IOT: {{ $substation->name }}</h2>
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <x-card>
            <div class="p-6">
                <h3 class="text-lg font-semibold text-gray-900">Asap</h3>
                {{-- Placeholder for sensor value --}}
                <p class="mt-2 text-3xl font-bold text-gray-900">
                    -
                </p>
            </div>
        </x-card>

        <x-card>
            <div class="p-6">
                <h3 class="text-lg font-semibold text-gray-900">Kelembapan</h3>
                {{-- Placeholder for sensor value --}}
                <p class="mt-2 text-3xl font-bold text-gray-900">
                    -
                </p>
            </div>
        </x-card>

        <x-card>
            <div class="p-6">
                <h3 class="text-lg font-semibold text-gray-900">Suhu</h3>
                {{-- Placeholder for sensor value --}}
                <p class="mt-2 text-3xl font-bold text-gray-900">
                    -
                </p>
            </div>
        </x-card>
    </div>
</div>
@endsection
