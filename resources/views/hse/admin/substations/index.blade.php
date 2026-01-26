@extends('layouts.app')

@section('title', 'Kelola Gardu Induk')

@section('content')
<div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
        <div class="p-6 bg-white border-b border-gray-200">
            <div class="mb-4">
                <a href="{{ route('hse.admin_substations.create') }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                    Buat Gardu Induk
                </a>
            </div>
            @if ($message = Session::get('success'))
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative" role="alert">
                    <strong class="font-bold">Berhasil!</strong>
                    <span class="block sm:inline">{{ $message }}</span>
                </div>
            @endif
            <table class="min-w-full bg-white">
                <thead>
                    <tr>
                        <th class="py-2">Nama</th>
                        <th class="py-2">Latitude</th>
                        <th class="py-2">Longitude</th>
                        <th class="py-2">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($substations as $substation)
                        <tr class="text-center">
                            <td class="py-2">{{ $substation->name }}</td>
                            <td class="py-2">{{ $substation->latitude }}</td>
                            <td class="py-2">{{ $substation->longitude }}</td>
                            <td class="py-2">
                                <a href="{{ route('hse.admin_substations.edit', $substation->id) }}" class="bg-yellow-500 hover:bg-yellow-700 text-white font-bold py-1 px-3 rounded">Edit</a>
                                <form action="{{ route('hse.admin_substations.destroy', $substation->id) }}" method="POST" class="inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="bg-red-500 hover:bg-red-700 text-white font-bold py-1 px-3 rounded">Hapus</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
