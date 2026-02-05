@extends('layouts.app')

@section('title', 'Monitoring IOT - ' . $substation->name)

@section('content')
<div class="max-w-7xl mx-auto">
    <h2 class="text-2xl font-bold text-blue-800 mb-6">Monitoring IOT: {{ $substation->name }}</h2>
    
    <div id="iot-device-grid" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        @forelse ($substation->iotDevices as $device)
            <x-card id="device-card-{{ $device->id }}">
                <div class="p-6">
                    <div class="flex items-center justify-between">
                        <h3 class="text-lg font-semibold text-gray-900">{{ $device->name }}</h3>
                        <span class="text-sm text-gray-500">{{ $device->room }}</span>
                    </div>
                    
                    <p class="mt-2 text-5xl font-bold text-blue-800" id="device-value-{{ $device->id }}">
                        {{ $device->latestData->payload['value'] ?? '-' }}
                        <span class="text-3xl text-gray-500">{{ $device->latestData->payload['unit'] ?? '' }}</span>
                    </p>
                    <p class="mt-1 text-sm text-gray-500" id="device-timestamp-{{ $device->id }}">
                        Diperbarui: {{ $device->latestData ? $device->latestData->created_at->diffForHumans() : 'Belum ada data' }}
                    </p>
                </div>
            </x-card>
        @empty
            <div class="md:col-span-3 text-center py-12">
                <p class="text-gray-500">Belum ada perangkat IoT yang dikonfigurasi untuk gardu induk ini.</p>
                @if(Auth::user()->hasRole('admin hse'))
                <a href="{{ route('hse.admin_substations.edit', $substation) }}" class="mt-4 inline-block rounded-md bg-blue-800 px-4 py-2 text-sm font-semibold text-white shadow-sm hover:bg-blue-700">
                    Konfigurasi Sekarang
                </a>
                @endif
            </div>
        @endforelse
    </div>
</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
    const substationId = {{ $substation->id }};
    const apiUrl = `{{ route('hse.api.monitoring_data', ['substation' => $substation->id]) }}`;

    function fetchData() {
        fetch(apiUrl)
            .then(response => {
                if (!response.ok) {
                    throw new Error('Network response was not ok');
                }
                return response.json();
            })
            .then(data => {
                updateCards(data);
            })
            .catch(error => {
                console.error('Error fetching IoT data:', error);
            });
    }

    function updateCards(data) {
        if (!Array.isArray(data)) return;

        data.forEach(deviceData => {
            const valueEl = document.getElementById(`device-value-${deviceData.id}`);
            const timestampEl = document.getElementById(`device-timestamp-${deviceData.id}`);

            if (valueEl) {
                const value = deviceData.value !== null ? deviceData.value : '-';
                const unit = deviceData.unit || '';
                valueEl.innerHTML = `${value} <span class="text-3xl text-gray-500">${unit}</span>`;
            }

            if (timestampEl) {
                timestampEl.textContent = `Diperbarui: ${deviceData.timestamp_human}`;
            }
        });
    }

    // Fetch data every 5 seconds
    setInterval(fetchData, 5000);
});
</script>
@endpush
