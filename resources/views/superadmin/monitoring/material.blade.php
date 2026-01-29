@extends('layouts.app')

@section('title', 'Monitoring Material')

@section('content')
<x-card>
    {{-- Card Header --}}
    <div class="border-b border-slate-200 p-6">
        <div class="flex flex-wrap items-center justify-between gap-4">
            <div class="w-full md:w-auto">
                <h3 class="text-xl font-semibold text-slate-800">Monitoring Data Material</h3>
                <p class="mt-1 text-sm text-slate-600">Melihat semua material yang terdaftar dalam mode read-only.</p>
            </div>
            <div class="flex w-full flex-col items-stretch gap-3 sm:w-auto sm:flex-row sm:items-center">
                {{-- Search Box and Sort Controls --}}
                <form action="{{ route('superadmin.monitoring.material.index') }}" method="GET" id="material-filter-form" class="flex w-full flex-col items-stretch gap-3 sm:w-auto sm:flex-row sm:items-center">
                    <div class="relative w-full sm:w-auto">
                        <svg class="pointer-events-none absolute left-3 top-1/2 -translate-y-1/2 transform text-slate-400" xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" viewBox="0 0 16 16">
                            <path d="M11.742 10.344a6.5 6.5 0 1 0-1.397 1.398h-.001c.03.04.062.078.098.115l3.85 3.85a1 1 0 0 0 1.415-1.414l-3.85-3.85a1.007 1.007 0 0 0-.115-.1zM12 6.5a5.5 5.5 0 1 1-11 0 5.5 5.5 0 0 1 11 0z"/>
                        </svg>
                        <input type="text" name="search" id="search" class="block w-full rounded-md border-0 py-2.5 pl-10 text-slate-900 ring-1 ring-inset ring-slate-300 placeholder:text-slate-400 focus:ring-2 focus:ring-inset focus:ring-blue-600 sm:text-sm sm:leading-6" placeholder="Cari material..." value="{{ $search ?? '' }}">
                    </div>

                    <div class="flex flex-col sm:flex-row items-stretch sm:items-center gap-2 border-l sm:border-t-0 border-t border-slate-200 pl-3 pt-2 sm:py-0 sm:pl-0 sm:pt-0">
                        <span class="text-sm font-semibold text-slate-800 whitespace-nowrap">Urutkan:</span>
                        <div class="flex items-center gap-2">
                            <label for="sort_by" class="sr-only">Sort By:</label>
                            <div class="relative w-full sm:w-auto">
                                <select name="sort_by" id="sort_by" class="block w-full rounded-md border-0 py-2.5 pl-3 pr-10 text-slate-900 ring-1 ring-inset ring-slate-300 focus:ring-2 focus:ring-inset focus:ring-blue-600 sm:text-sm sm:leading-6 appearance-none">
                                    <option value="nama_material" {{ $sortBy == 'nama_material' ? 'selected' : '' }}>Nama Material</option>
                                    <option value="stok" {{ $sortBy == 'stok' ? 'selected' : '' }}>Stok</option>
                                    <option value="satuan" {{ $sortBy == 'satuan' ? 'selected' : '' }}>Satuan</option>
                                    <option value="jenis_kebutuhan" {{ $sortBy == 'jenis_kebutuhan' ? 'selected' : '' }}>Jenis Kebutuhan</option>
                                    <option value="lokasi" {{ $sortBy == 'lokasi' ? 'selected' : '' }}>Lokasi</option>
                                </select>
                                <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2 text-slate-700">
                                    <svg class="h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                        <path fill-rule="evenodd" d="M5.23 7.21a.75.75 0 011.06.02L10 11.168l3.71-3.938a.75.75 0 111.08 1.04l-4.25 4.5a.75.75 0 01-1.08 0l-4.25-4.5a.75.75 0 01.02-1.06z" clip-rule="evenodd" />
                                    </svg>
                                </div>
                            </div>
                        </div>

                        <div class="flex items-center gap-2">
                            <label for="sort_direction" class="sr-only">Order:</label>
                            <div class="relative w-full sm:w-auto">
                                <select name="sort_direction" id="sort_direction" class="block w-full rounded-md border-0 py-2.5 pl-3 pr-10 text-slate-900 ring-1 ring-inset ring-slate-300 focus:ring-2 focus:ring-inset focus:ring-blue-600 sm:text-sm sm:leading-6 appearance-none">
                                    <option value="asc" {{ $sortDirection == 'asc' ? 'selected' : '' }}>Ascending</option>
                                    <option value="desc" {{ $sortDirection == 'desc' ? 'selected' : '' }}>Descending</option>
                                </select>
                                <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2 text-slate-700">
                                    <svg class="h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                        <path fill-rule="evenodd" d="M5.23 7.21a.75.75 0 011.06.02L10 11.168l3.71-3.938a.75.75 0 111.08 1.04l-4.25 4.5a.75.75 0 01-1.08 0l-4.25-4.5a.75.75 0 01.02-1.06z" clip-rule="evenodd" />
                                    </svg>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    {{-- Table --}}
    <div class="flow-root">
        <div class="-my-2 -mx-4 overflow-x-auto sm:-mx-6 lg:-mx-8">
            <div class="inline-block min-w-full py-2 align-middle sm:px-6 lg:px-8">
                <table class="min-w-full divide-y divide-slate-200">
                    <thead class="bg-slate-50">
                        <tr>
                            <th scope="col" class="py-3.5 pl-4 pr-3 text-left text-sm font-semibold text-slate-900 sm:pl-6">ID</th>
                            <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-slate-900">Nama Material</th>
                            <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-slate-900">Satuan</th>
                            <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-slate-900">Stok</th>
                            <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-slate-900">Lokasi</th>
                            <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-slate-900">Tempat</th>
                            <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-slate-900">Jenis Kebutuhan</th>
                            <th scope="col" class="relative py-3.5 pl-3 pr-4 sm:pr-6">
                                <span class="sr-only">Aksi</span>
                            </th>
                        </tr>
                    </thead>
                    <tbody id="material-table-body" class="divide-y divide-slate-200 bg-white">
                        @foreach ($materials as $material)
                        <tr>
                            <td class="whitespace-nowrap py-4 pl-4 pr-3 text-sm font-medium text-slate-900 sm:pl-6">{{ $material->id }}</td>
                            <td class="whitespace-nowrap px-3 py-4 text-sm text-slate-500">{{ $material->nama_material }}</td>
                            <td class="whitespace-nowrap px-3 py-4 text-sm text-slate-500">{{ $material->satuan }}</td>
                            <td class="whitespace-nowrap px-3 py-4 text-sm text-slate-500">{{ $material->stok }}</td>
                            <td class="whitespace-nowrap px-3 py-4 text-sm text-slate-500">{{ $material->lokasi ?? '-' }}</td>
                            <td class="whitespace-nowrap px-3 py-4 text-sm text-slate-500">{{ $material->tempat ?? '-' }}</td>
                            <td class="whitespace-nowrap px-3 py-4 text-sm text-slate-500">{{ ucfirst($material->jenis_kebutuhan) }}</td>
                            <td class="relative whitespace-nowrap py-4 pl-3 pr-4 text-right text-sm font-medium sm:pr-6">
                                <button type="button" onclick="viewMaterial({{ $material->id }})" class="text-green-600 hover:text-green-900">Lihat</button>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-card>

{{-- Modal Lihat Detail Material --}}
<div id="detail-material-modal" class="fixed inset-0 z-20 hidden overflow-y-auto bg-black/50 backdrop-blur-sm transition-opacity duration-300 ease-out opacity-0">
    <div class="flex min-h-full items-center justify-center p-4 text-center sm:block sm:p-0">
        <span class="hidden sm:inline-block sm:h-screen sm:align-middle" aria-hidden="true">&#8203;</span>
        <div class="inline-block align-bottom bg-white rounded-lg px-4 pt-5 pb-4 text-left overflow-hidden shadow-2xl transform transition-all sm:my-8 sm:align-middle sm:max-w-2xl sm:w-full sm:p-6 opacity-0 scale-95 duration-300 ease-out"
            role="dialog" aria-modal="true" aria-labelledby="detail-modal-title">
            <div class="flex items-center justify-between border-b border-slate-300 pb-4">
                <h3 class="text-xl font-bold text-slate-800" id="detail-modal-title">Detail Material</h3>
                <button type="button" id="close-detail-modal-btn" class="text-gray-500 hover:text-gray-700 rounded-full p-1 hover:bg-gray-100 transition-colors">
                    <svg class="h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
            <div class="mt-6 space-y-4">
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-slate-700">ID</label>
                        <p id="detail-id" class="mt-1 text-sm text-slate-900"></p>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-slate-700">Stok</label>
                        <p id="detail-stok" class="mt-1 text-sm text-slate-900"></p>
                    </div>
                </div>
                <div>
                    <label class="block text-sm font-medium text-slate-700">Nama Material</label>
                    <p id="detail-nama" class="mt-1 text-sm text-slate-900"></p>
                </div>
                <div>
                    <label class="block text-sm font-medium text-slate-700">Satuan</label>
                    <p id="detail-satuan" class="mt-1 text-sm text-slate-900"></p>
                </div>
                 <div>
                    <label class="block text-sm font-medium text-slate-700">Lokasi</label>
                    <p id="detail-lokasi" class="mt-1 text-sm text-slate-900"></p>
                </div>
                <div>
                    <label class="block text-sm font-medium text-slate-700">Tempat</label>
                    <p id="detail-tempat" class="mt-1 text-sm text-slate-900"></p>
                </div>
                <div>
                    <label class="block text-sm font-medium text-slate-700">Spesifikasi</label>
                    <p id="detail-spesifikasi" class="mt-1 text-sm text-slate-900 whitespace-pre-line"></p>
                </div>
                <div>
                    <label class="block text-sm font-medium text-slate-700">Jenis Kebutuhan</label>
                    <p id="detail-jenis_kebutuhan" class="mt-1 text-sm text-slate-900"></p>
                </div>
                <div>
                    <label class="block text-sm font-medium text-slate-700">Foto Material</label>
                    <div id="detail-foto-container" class="mt-2">
                        <img id="detail-foto" src="" alt="Foto Material" class="max-w-full h-auto rounded-lg shadow-md" style="max-height: 400px;">
                        <p id="detail-no-foto" class="text-sm text-slate-500 italic hidden">Tidak ada foto</p>
                    </div>
                </div>
            </div>
            <div class="mt-6 flex items-center justify-end">
                <button type="button" id="close-detail-btn" class="rounded-md border border-gray-300 bg-white px-4 py-2 text-sm font-medium text-gray-700 shadow-sm hover:bg-gray-50">Tutup</button>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
    const detailModal = document.getElementById('detail-material-modal');
    const closeDetailModalBtn = document.getElementById('close-detail-modal-btn');
    const closeDetailBtn = document.getElementById('close-detail-btn');
    const materialFilterForm = document.getElementById('material-filter-form');
    const searchInput = document.getElementById('search');
    const sortBySelect = document.getElementById('sort_by');
    const sortDirectionSelect = document.getElementById('sort_direction');

    const openDetailModal = () => {
        if (!detailModal) return;
        detailModal.classList.remove('hidden');
        setTimeout(() => {
            detailModal.classList.remove('opacity-0');
            detailModal.querySelector('[role="dialog"]').classList.remove('opacity-0', 'scale-95');
        }, 50);
    };

    const closeDetailModal = () => {
        if (!detailModal) return;
        detailModal.classList.add('opacity-0');
        detailModal.querySelector('[role="dialog"]').classList.add('opacity-0', 'scale-95');
        setTimeout(() => {
            detailModal.classList.add('hidden');
        }, 300);
    };

    if (closeDetailModalBtn) closeDetailModalBtn.addEventListener('click', closeDetailModal);
    if (closeDetailBtn) closeDetailBtn.addEventListener('click', closeDetailModal);
    
    document.addEventListener('keydown', (e) => {
        if (e.key === 'Escape' && !detailModal.classList.contains('hidden')) {
            closeDetailModal();
        }
    });

    if (detailModal) {
        detailModal.addEventListener('click', (e) => {
            if (e.target === detailModal) {
                closeDetailModal();
            }
        });
    }

    window.viewMaterial = function(materialId) {
        const url = `{{ url('/superadmin/monitoring/material') }}/${materialId}`;
        
        fetch(url, {
            headers: {
                'X-Requested-With': 'XMLHttpRequest',
                'Accept': 'application/json'
            }
        })
        .then(response => response.json())
        .then(data => {
            document.getElementById('detail-id').textContent = data.id || '-';
            document.getElementById('detail-nama').textContent = data.nama_material || '-';
            document.getElementById('detail-satuan').textContent = data.satuan || '-';
            document.getElementById('detail-stok').textContent = data.stok || '0';
            document.getElementById('detail-lokasi').textContent = data.lokasi || '-';
            document.getElementById('detail-tempat').textContent = data.tempat || '-';
            document.getElementById('detail-spesifikasi').textContent = data.spesifikasi || 'Tidak ada spesifikasi';
            document.getElementById('detail-jenis_kebutuhan').textContent = data.jenis_kebutuhan ? data.jenis_kebutuhan.charAt(0).toUpperCase() + data.jenis_kebutuhan.slice(1) : '-';
            
            const fotoImg = document.getElementById('detail-foto');
            const noFotoText = document.getElementById('detail-no-foto');
            
            if (data.foto) {
                fotoImg.src = `/storage/${data.foto}`;
                fotoImg.classList.remove('hidden');
                noFotoText.classList.add('hidden');
            } else {
                fotoImg.classList.add('hidden');
                noFotoText.classList.remove('hidden');
            }
            
            openDetailModal();
        })
        .catch(error => {
            console.error('Error fetching material details:', error);
            alert('Gagal memuat detail material.');
        });
    };

    if (materialFilterForm) {
        const urlParams = new URLSearchParams(window.location.search);
        if (urlParams.has('sort_by')) {
            sortBySelect.value = urlParams.get('sort_by');
        }
        if (urlParams.has('sort_direction')) {
            sortDirectionSelect.value = urlParams.get('sort_direction');
        }

        sortBySelect.addEventListener('change', () => materialFilterForm.submit());
        sortDirectionSelect.addEventListener('change', () => materialFilterForm.submit());

        let debounceTimer;
        searchInput.addEventListener('keyup', () => {
            clearTimeout(debounceTimer);
            debounceTimer = setTimeout(() => {
                materialFilterForm.submit();
            }, 300);
        });
    }
});
</script>
@endpush
