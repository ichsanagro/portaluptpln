@extends('layouts.app')

@section('title', 'Dashboard Monitoring IoT')

@section('content')
<div class="max-w-7xl mx-auto">
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">

        @forelse ($sensorData as $data)
            @php
                // Set default values and retrieve from payload
                $status = strtolower($data->payload['status'] ?? 'normal');
                $rawDeviceId = $data->payload['device_id'] ?? null; // Store raw device_id for lookup

                // Get friendly name from config, fallback to rawDeviceId if not found, then to topic
                $friendlyName = config('sensors.names.' . $rawDeviceId, $rawDeviceId);
                if (empty($friendlyName) || $friendlyName == $rawDeviceId) {
                    $friendlyName = $data->topic; // Fallback to full topic if no specific name for device_id
                }

                $value = $data->payload['value'] ?? 'N/A';
                
                // Get unit from config, fallback to empty string
                $unit = config('sensors.units.' . $rawDeviceId, '');

                $message = $data->payload['message'] ?? $status;

                // Define classes based on status
                $borderColor = 'border-gray-200'; // Default
                $textColor = 'text-gray-900'; // Default
                if ($status == 'alarm') {
                    $borderColor = 'border-red-500';
                    $textColor = 'text-red-600';
                } elseif ($status == 'warning') {
                    $borderColor = 'border-yellow-500';
                    $textColor = 'text-yellow-600';
                }
            @endphp

            <x-card class="border-2 {{ $borderColor }}">
                <div class="p-6">
                    <div class="flex items-center justify-between">
                        <h3 class="text-lg font-semibold text-gray-700">{{ $friendlyName }}</h3>
                        <span class="px-3 py-1 text-xs font-semibold rounded-full capitalize
                            @if($status == 'alarm') bg-red-100 text-red-800 @endif
                            @if($status == 'warning') bg-yellow-100 text-yellow-800 @endif
                            @if($status == 'normal') bg-green-100 text-green-800 @endif
                            @if($status == 'info') bg-blue-100 text-blue-800 @endif
                        ">
                            {{ $status }}
                        </span>
                    </div>

                    <p class="mt-2 text-3xl font-bold {{ $textColor }}">
                        {{ $value }}
                        @if($unit)
                            <span class="text-xl font-medium text-gray-500">{{ $unit }}</span>
                        @endif
                    </p>

                    <p class="mt-1 text-sm text-gray-600 truncate" title="{{ $message }}">
                        {{ $message }}
                    </p>
                    
                    <p class="mt-4 text-xs text-gray-400">
                        {{ $data->created_at->diffForHumans() }} ({{ $data->created_at->format('Y-m-d H:i:s') }})
                    </p>
                </div>
            </x-card>

        @empty
            <div class="col-span-1 md:col-span-2 lg:col-span-3">
                <x-card>
                    <div class="p-6 text-center text-gray-500">
                        <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 12h14M5 12a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v4a2 2 0 01-2 2M5 12a2 2 0 00-2 2v4a2 2 0 002 2h14a2 2 0 002-2v-4a2 2 0 00-2-2" />
                        </svg>
                        <h3 class="mt-2 text-sm font-medium text-gray-900">No Data Received Yet</h3>
                        <p class="mt-1 text-sm text-gray-500">Waiting for data from the MQTT listener...</p>
                    </div>
                </x-card>
            </div>
        @endforelse

    </div>
</div>
@endsection

@push('scripts')
<script>
    // Refresh the page every 30 seconds (30,000 milliseconds)
    setTimeout(function(){
        window.location.reload(1);
    }, 20000);
</script>
@endpush
