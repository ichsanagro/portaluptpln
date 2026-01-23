@extends('layouts.app')

@section('title', 'Edit Data Kecelakaan')

@section('content')
<x-card>
    <div class="border-b border-slate-200 p-6">
        <h3 class="text-xl font-semibold text-slate-800">Edit Data Kecelakaan</h3>
        <p class="mt-1 text-sm text-slate-600">Perbarui detail kecelakaan di bawah ini.</p>
    </div>
    <form action="{{ route('hse.admin_accidents.update', $accidentLog->id) }}" method="POST" class="p-6">
        @csrf
        @method('PUT')
        <div class="space-y-6">
            <div>
                <x-input-label for="accident_date" value="Tanggal Kecelakaan" />
                <div class="mt-2">
                    <x-text-input
                        id="accident_date"
                        name="accident_date"
                        type="date"
                        required
                        value="{{ old('accident_date', \Carbon\Carbon::parse($accidentLog->accident_date)->format('Y-m-d')) }}"
                    />
                </div>
                 @error('accident_date')
                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>
            <div>
                <x-input-label for="description" value="Keterangan" />
                <div class="mt-2">
                    <textarea
                        id="description"
                        name="description"
                        rows="5"
                        class="block w-full rounded-md border-0 py-1.5 text-slate-900 shadow-sm ring-1 ring-inset ring-slate-300 placeholder:text-slate-400 focus:ring-2 focus:ring-inset focus:ring-blue-600 sm:text-sm sm:leading-6"
                        required
                        placeholder="Masukkan keterangan lengkap mengenai kecelakaan"
                    >{{ old('description', $accidentLog->description) }}</textarea>
                </div>
                 @error('description')
                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>
        </div>
        <div class="mt-6 flex items-center justify-end gap-x-6">
            <a href="{{ route('hse.admin_accidents.index') }}" class="text-sm font-semibold leading-6 text-slate-900">Batal</a>
            <x-primary-button>
                Simpan Perubahan
            </x-primary-button>
        </div>
    </form>
</x-card>
@endsection
