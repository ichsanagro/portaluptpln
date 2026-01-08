@extends('layouts.app')

@section('title', 'Edit Material')

@section('content')
<x-card>
    <div class="border-b border-slate-200 p-6">
        <h3 class="text-xl font-semibold text-slate-800">Edit Material</h3>
        <p class="mt-1 text-sm text-slate-600">Perbarui data material di bawah ini.</p>
    </div>
    <form action="{{ route('material.update', $material->id) }}" method="POST" class="p-6">
        @csrf
        @method('PUT')
        <div class="space-y-6">
            <div>
                <x-input-label for="nama_material" value="Nama Material" />
                <div class="mt-2">
                    <x-text-input
                        id="nama_material"
                        name="nama_material"
                        type="text"
                        required
                        value="{{ old('nama_material', $material->nama_material) }}"
                        placeholder="Masukkan nama material"
                    />
                </div>
            </div>
            <div>
                <x-input-label for="satuan" value="Satuan" />
                <div class="mt-2">
                    <x-text-input
                        id="satuan"
                        name="satuan"
                        type="text"
                        required
                        value="{{ old('satuan', $material->satuan) }}"
                        placeholder="Contoh: Meter, Unit, Buah"
                    />
                </div>
            </div>
            <div>
                <x-input-label for="stok" value="Stok" />
                <div class="mt-2">
                    <x-text-input
                        id="stok"
                        name="stok"
                        type="number"
                        required
                        value="{{ old('stok', $material->stok) }}"
                        placeholder="Masukkan jumlah stok"
                    />
                </div>
            </div>
        </div>
        <div class="mt-6 flex items-center justify-end gap-x-6">
            <a href="{{ route('material.index') }}" class="text-sm font-semibold leading-6 text-slate-900">Batal</a>
            <x-primary-button>
                Simpan Perubahan
            </x-primary-button>
        </div>
    </form>
</x-card>
@endsection
