@extends('layouts.app')

@section('title', 'Edit Material')

@section('content')
<x-card>
    <div class="border-b border-slate-200 p-6">
        <h3 class="text-xl font-semibold text-slate-800">Edit Material</h3>
        <p class="mt-1 text-sm text-slate-600">Perbarui data material di bawah ini.</p>
    </div>
    <form action="{{ route('logistik.adminlogistik.material.update', $material->id) }}" method="POST" enctype="multipart/form-data" class="p-6">
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
            <div>
                <x-input-label for="spesifikasi" value="Spesifikasi" />
                <div class="mt-2">
                    <textarea
                        id="spesifikasi"
                        name="spesifikasi"
                        rows="3"
                        class="block w-full rounded-md border-0 py-1.5 text-slate-900 shadow-sm ring-1 ring-inset ring-slate-300 placeholder:text-slate-400 focus:ring-2 focus:ring-inset focus:ring-blue-600 sm:text-sm sm:leading-6"
                        placeholder="Masukkan spesifikasi material (opsional)"
                    >{{ old('spesifikasi', $material->spesifikasi) }}</textarea>
                </div>
            </div>
            <div>
                <x-input-label for="foto" value="Foto Material" />
                @if($material->foto)
                    <div class="mt-2 mb-3">
                        <img src="{{ asset('storage/' . $material->foto) }}" alt="Foto Material" class="max-w-xs h-auto rounded-lg shadow-md">
                        <p class="mt-1 text-xs text-slate-500">Foto saat ini</p>
                    </div>
                @endif
                <div class="mt-2">
                    <input
                        id="foto"
                        name="foto"
                        type="file"
                        accept="image/*"
                        class="block w-full text-sm text-slate-500 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100"
                    />
                    <p class="mt-1 text-xs text-slate-500">Format: JPG, PNG, GIF (Max: 2MB) - Kosongkan jika tidak ingin mengubah foto</p>
                </div>
            </div>
        </div>
        <div class="mt-6 flex items-center justify-end gap-x-6">
            <a href="{{ route('logistik.adminlogistik.material.index') }}" class="text-sm font-semibold leading-6 text-slate-900">Batal</a>
            <x-primary-button>
                Simpan Perubahan
            </x-primary-button>
        </div>
    </form>
</x-card>
@endsection
