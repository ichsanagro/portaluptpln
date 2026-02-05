@extends('layouts.app')

@section('title', 'Edit Gardu Induk & IoT')

@section('content')
<div class="space-y-6">
    
    {{-- Success Message --}}
    @if(session('success'))
        <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 rounded-md" role="alert">
            <p>{{ session('success') }}</p>
        </div>
    @endif

    {{-- Validation Errors --}}
    @if ($errors->any())
        <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 rounded-md" role="alert">
            <p class="font-bold">Terdapat kesalahan:</p>
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    {{-- Edit Substation Form --}}
    <div class="p-4 sm:p-8 bg-white shadow-md rounded-lg">
        <div class="max-w-xl">
            <h3 class="text-lg font-medium text-gray-900">Informasi Gardu Induk</h3>
            <form method="post" action="{{ route('hse.admin_substations.update', $substation) }}" class="mt-6 space-y-6">
                @csrf
                @method('put')

                <div>
                    <x-input-label for="name" :value="__('Nama Gardu Induk')" />
                    <x-text-input id="name" name="name" type="text" class="mt-1 block w-full" :value="old('name', $substation->name)" required autofocus />
                </div>

                <div>
                    <x-input-label for="latitude" :value="__('Latitude')" />
                    <x-text-input id="latitude" name="latitude" type="text" class="mt-1 block w-full" :value="old('latitude', $substation->latitude)" required />
                </div>

                <div>
                    <x-input-label for="longitude" :value="__('Longitude')" />
                    <x-text-input id="longitude" name="longitude" type="text" class="mt-1 block w-full" :value="old('longitude', $substation->longitude)" required />
                </div>

                <div class="flex items-center gap-4">
                    <x-primary-button>{{ __('Simpan Perubahan') }}</x-primary-button>
                </div>
            </form>
        </div>
    </div>

    {{-- IoT Devices List --}}
    <div class="p-4 sm:p-8 bg-white shadow-md rounded-lg">
        <h3 class="text-lg font-medium text-gray-900 mb-4">Perangkat IoT Terdaftar</h3>
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Ruangan</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nama Perangkat</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Topik MQTT</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                        <th scope="col" class="relative px-6 py-3">
                            <span class="sr-only">Aksi</span>
                        </th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse ($substation->iotDevices as $device)
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap">{{ $device->room }}</td>
                            <td class="px-6 py-4 whitespace-nowrap">{{ $device->name }}</td>
                            <td class="px-6 py-4 whitespace-nowrap">{{ $device->topic }}</td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                @if($device->is_active)
                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">Aktif</span>
                                @else
                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800">Nonaktif</span>
                                @endif
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                <form method="post" action="{{ route('hse.admin_substations.devices.destroy', $device) }}" onsubmit="return confirm('Apakah Anda yakin ingin menghapus perangkat ini?');">
                                    @csrf
                                    @method('delete')
                                    <button type="submit" class="text-red-600 hover:text-red-900">Hapus</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-6 py-4 whitespace-nowrap text-center text-gray-500">
                                Belum ada perangkat IoT yang terdaftar.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    {{-- Add IoT Device Form --}}
    <div class="p-4 sm:p-8 bg-white shadow-md rounded-lg">
         <div class="max-w-xl">
            <h3 class="text-lg font-medium text-gray-900">Tambah Perangkat IoT Baru</h3>
            <p class="mt-1 text-sm text-gray-600">
                Pastikan topik MQTT unik dan sesuai dengan yang diatur pada perangkat fisik.
            </p>
            <form method="post" action="{{ route('hse.admin_substations.devices.store', $substation) }}" class="mt-6 space-y-6">
                @csrf
                <div>
                    <x-input-label for="device_room" :value="__('Nama Ruangan')" />
                    <x-text-input id="device_room" name="room" type="text" class="mt-1 block w-full" :value="old('room')" required />
                </div>
                <div>
                    <x-input-label for="device_name" :value="__('Nama Perangkat/Sensor')" />
                    <x-text-input id="device_name" name="name" type="text" class="mt-1 block w-full" :value="old('name')" required />
                </div>
                <div>
                    <x-input-label for="device_topic" :value="__('Topik MQTT')" />
                    <x-text-input id="device_topic" name="topic" type="text" class="mt-1 block w-full" :value="old('topic')" required />
                </div>
                 <div class="flex items-center gap-4">
                    <x-primary-button>{{ __('Tambah Perangkat') }}</x-primary-button>
                </div>
            </form>
        </div>
    </div>

</div>
@endsection