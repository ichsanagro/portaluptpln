@extends('layouts.app')

@section('title', 'Kelola Material')

@section('content')
<x-card>
    {{-- Success Message --}}
    @if (session('success'))
        <div class="rounded-md bg-green-50 p-4 mb-6">
            <div class="flex">
                <div class="flex-shrink-0">
                    <svg class="h-5 w-5 text-green-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                    </svg>
                </div>
                <div class="ml-3">
                    <p class="text-sm font-medium text-green-800">{{ session('success') }}</p>
                </div>
            </div>
        </div>
    @endif
    
    {{-- Error Messages --}}
    @if ($errors->any())
        <div class="rounded-md bg-red-50 p-4 mb-6">
            <div class="flex">
                <div class="flex-shrink-0">
                    <svg class="h-5 w-5 text-red-400" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.28 7.22a.75.75 0 00-1.06 1.06L8.94 10l-1.72 1.72a.75.75 0 101.06 1.06L10 11.06l1.72 1.72a.75.75 0 101.06-1.06L11.06 10l1.72-1.72a.75.75 0 00-1.06-1.06L10 8.94 8.28 7.22z" clip-rule="evenodd" />
                    </svg>
                </div>
                <div class="ml-3">
                    <h3 class="text-sm font-medium text-red-800">Terdapat {{ $errors->count() }} error dengan input Anda</h3>
                    <div class="mt-2 text-sm text-red-700">
                        <ul role="list" class="list-disc space-y-1 pl-5">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    @endif


    {{-- Card Header --}}
    <div class="border-b border-slate-200 p-6">
        <div class="flex flex-wrap items-center justify-between gap-4">
            <div class="w-full md:w-auto">
                <h3 class="text-xl font-semibold text-slate-800">Daftar Material</h3>
                <p class="mt-1 text-sm text-slate-600">Cari, tambah, atau kelola semua material yang terdaftar.</p>
            </div>
            <div class="flex w-full flex-col items-stretch gap-3 sm:w-auto sm:flex-row sm:items-center">
                {{-- Search Box --}}
                <div class="relative w-full sm:w-auto">
                    <svg class="pointer-events-none absolute left-3 top-1/2 -translate-y-1/2 transform text-slate-400" xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" viewBox="0 0 16 16">
                        <path d="M11.742 10.344a6.5 6.5 0 1 0-1.397 1.398h-.001c.03.04.062.078.098.115l3.85 3.85a1 1 0 0 0 1.415-1.414l-3.85-3.85a1.007 1.007 0 0 0-.115-.1zM12 6.5a5.5 5.5 0 1 1-11 0 5.5 5.5 0 0 1 11 0z"/>
                    </svg>
                    <input type="text" name="search" id="search" class="block w-full rounded-md border-0 py-2.5 pl-10 text-slate-900 ring-1 ring-inset ring-slate-300 placeholder:text-slate-400 focus:ring-2 focus:ring-inset focus:ring-blue-600 sm:text-sm sm:leading-6" placeholder="Cari material..." value="{{ $search ?? '' }}">
                </div>

                {{-- Add Button --}}
                <button type="button" id="open-modal-btn" class="flex items-center justify-center gap-2 rounded-md bg-blue-600 px-4 py-2.5 text-sm font-semibold text-white shadow-sm hover:bg-blue-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-blue-600">
                    <svg class="-ml-0.5 h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                        <path d="M10.75 4.75a.75.75 0 00-1.5 0v4.5h-4.5a.75.75 0 000 1.5h4.5v4.5a.75.75 0 001.5 0v-4.5h4.5a.75.75 0 000-1.5h-4.5v-4.5z" />
                    </svg>
                    <span>Tambah Material</span>
                </button>
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
                            <td class="relative whitespace-nowrap py-4 pl-3 pr-4 text-right text-sm font-medium sm:pr-6">
                                <button type="button" onclick="viewMaterial({{ $material->id }})" class="text-green-600 hover:text-green-900">Lihat</button>
                                <a href="{{ route('logistik.adminlogistik.material.edit', $material->id) }}" class="ml-4 text-blue-600 hover:text-blue-900">Edit</a>
                                <form action="{{ route('logistik.adminlogistik.material.destroy', $material->id) }}" method="POST" class="inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="ml-4 text-red-600 hover:text-red-900" onclick="return confirm('Apakah Anda yakin ingin menghapus material ini?')">Hapus</button>
                                </form>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-card>

{{-- Modal Tambah Material --}}
<div id="tambah-material-modal" class="fixed inset-0 z-20 hidden overflow-y-auto bg-black/50 backdrop-blur-sm transition-opacity duration-300 ease-out opacity-0">
    <div class="flex min-h-full items-center justify-center p-4 text-center sm:block sm:p-0">
        <!-- This is here to "trap" focus -->
        <span class="hidden sm:inline-block sm:h-screen sm:align-middle" aria-hidden="true">&#8203;</span>
        <div class="inline-block align-bottom bg-white rounded-lg px-4 pt-5 pb-4 text-left overflow-hidden shadow-2xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full sm:p-6 opacity-0 scale-95 duration-300 ease-out"
            role="dialog" aria-modal="true" aria-labelledby="modal-title">
            <div class="flex items-center justify-between border-b border-slate-300 pb-4">
                <h3 class="text-xl font-bold text-slate-800" id="modal-title">Tambah Material Baru</h3>
                <button type="button" id="close-modal-btn" class="text-gray-500 hover:text-gray-700 rounded-full p-1 hover:bg-gray-100 transition-colors">
                    <svg class="h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
            <form action="{{ route('logistik.adminlogistik.material.store') }}" method="POST" enctype="multipart/form-data" class="mt-6">
                @csrf
                <div class="space-y-6">
                    <div>
                        <x-input-label for="nama_material" value="Nama Material" />
                        <div class="mt-2">
                            <x-text-input
                                id="nama_material"
                                name="nama_material"
                                type="text"
                                required
                                placeholder="Masukkan nama material"
                                value="{{ old('nama_material') }}"
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
                                placeholder="Contoh: Meter, Unit, Buah"
                                value="{{ old('satuan') }}"
                            />
                        </div>
                    </div>
                    <div>
                        <x-input-label for="stok" value="Stok Awal" />
                        <div class="mt-2">
                            <x-text-input
                                id="stok"
                                name="stok"
                                type="number"
                                required
                                placeholder="Masukkan jumlah stok awal"
                                value="{{ old('stok') }}"
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
                            >{{ old('spesifikasi') }}</textarea>
                        </div>
                    </div>
                    <div>
                        <x-input-label for="foto" value="Foto Material" />
                        <div class="mt-2">
                            <input
                                id="foto"
                                name="foto"
                                type="file"
                                accept="image/*"
                                class="block w-full text-sm text-slate-500 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100"
                            />
                            <p class="mt-1 text-xs text-slate-500">Format: JPG, PNG, GIF (Max: 2MB)</p>
                        </div>
                    </div>
                </div>
                <div class="mt-8 flex items-center justify-end gap-x-3">
                    <button type="button" id="cancel-btn" class="rounded-md border border-gray-300 bg-white px-4 py-2 text-sm font-medium text-gray-700 shadow-sm hover:bg-gray-50">Batal</button>
                    <x-primary-button>
                        Simpan
                    </x-primary-button>
                </div>
            </form>
        </div>
    </div>
</div>
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
                    <label class="block text-sm font-medium text-slate-700">Spesifikasi</label>
                    <p id="detail-spesifikasi" class="mt-1 text-sm text-slate-900 whitespace-pre-line"></p>
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
        // --- MODAL ELEMENTS ---
        const modal = document.getElementById('tambah-material-modal');
        const openModalBtn = document.getElementById('open-modal-btn');
        const closeModalBtn = document.getElementById('close-modal-btn');
        const cancelBtn = document.getElementById('cancel-btn');

        // --- DETAIL MODAL ELEMENTS ---
        const detailModal = document.getElementById('detail-material-modal');
        const closeDetailModalBtn = document.getElementById('close-detail-modal-btn');
        const closeDetailBtn = document.getElementById('close-detail-btn');

        // --- SEARCH ELEMENTS ---
        const searchInput = document.getElementById('search');
        const tableBody = document.getElementById('material-table-body');
        const editUrlTemplate = '{{ route('logistik.adminlogistik.material.edit', ['id' => ':id']) }}';
        const deleteUrlTemplate = '{{ route('logistik.adminlogistik.material.destroy', ['id' => ':id']) }}';
        const csrfToken = '{{ csrf_token() }}';

        // --- MODAL FUNCTIONS ---
        const openModal = () => {
            if (!modal) return;
            modal.classList.remove('hidden');
            setTimeout(() => {
                modal.classList.remove('opacity-0');
                modal.querySelector('[role="dialog"]').classList.remove('opacity-0', 'scale-95');
            }, 50);
        };

        const closeModal = () => {
            if (!modal) return;
            modal.classList.add('opacity-0');
            modal.querySelector('[role="dialog"]').classList.add('opacity-0', 'scale-95');
            setTimeout(() => {
                modal.classList.add('hidden');
            }, 300); // Match transition duration
        };

        // --- MODAL EVENT LISTENERS ---
        if (openModalBtn) {
            openModalBtn.addEventListener('click', openModal);
        }
        if (closeModalBtn) {
            closeModalBtn.addEventListener('click', closeModal);
        }
        if (cancelBtn) {
            cancelBtn.addEventListener('click', closeModal);
        }
        // Close modal on escape key press
        document.addEventListener('keydown', (e) => {
            if (e.key === 'Escape' && !modal.classList.contains('hidden')) {
                closeModal();
            }
        });
        // Close modal on outside click
        if (modal) {
            modal.addEventListener('click', (e) => {
                if (e.target === modal) {
                    closeModal();
                }
            });
        }

        // --- DETAIL MODAL FUNCTIONS ---
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

        // --- DETAIL MODAL EVENT LISTENERS ---
        if (closeDetailModalBtn) {
            closeDetailModalBtn.addEventListener('click', closeDetailModal);
        }
        if (closeDetailBtn) {
            closeDetailBtn.addEventListener('click', closeDetailModal);
        }
        // Close detail modal on escape key
        document.addEventListener('keydown', (e) => {
            if (e.key === 'Escape' && !detailModal.classList.contains('hidden')) {
                closeDetailModal();
            }
        });
        // Close detail modal on outside click
        if (detailModal) {
            detailModal.addEventListener('click', (e) => {
                if (e.target === detailModal) {
                    closeDetailModal();
                }
            });
        }

        // --- VIEW MATERIAL FUNCTION ---
        window.viewMaterial = function(materialId) {
            // Use the correct route for show method
            const url = `/logistik/adminlogistik/material/${materialId}`;
            
            fetch(url, {
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'Accept': 'application/json'
                }
            })
            .then(response => {
                if (!response.ok) {
                    throw new Error('Network response was not ok');
                }
                return response.json();
            })
            .then(data => {
                console.log('Material data:', data); // Debug log
                
                // Populate modal with data
                document.getElementById('detail-id').textContent = data.id || '-';
                document.getElementById('detail-nama').textContent = data.nama_material || '-';
                document.getElementById('detail-satuan').textContent = data.satuan || '-';
                document.getElementById('detail-stok').textContent = data.stok || '0';
                document.getElementById('detail-spesifikasi').textContent = data.spesifikasi || 'Tidak ada spesifikasi';
                
                // Handle foto
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
                alert('Gagal memuat detail material: ' + error.message);
            });
        };
        
        // --- Handle form validation errors ---
        // If there are validation errors, the page reloads. We check for this and re-open the modal.
        @if ($errors->any())
            openModal();
        @endif


        // --- SEARCH FUNCTIONS ---
        function fetchMaterials(searchQuery) {
            const url = `{{ route('logistik.adminlogistik.material.index') }}?search=${searchQuery}`;

            fetch(url, {
                headers: {
                    'X-Requested-With': 'XMLHttpRequest'
                }
            })
            .then(response => response.json())
            .then(data => {
                updateTable(data.materials);
            })
            .catch(error => {
                console.error('Error fetching materials:', error);
            });
        }

        function updateTable(materials) {
            if (!tableBody) return;
            tableBody.innerHTML = '';

            if (materials.length > 0) {
                materials.forEach(material => {
                    const editUrl = editUrlTemplate.replace(':id', material.id);
                    const deleteUrl = deleteUrlTemplate.replace(':id', material.id);
                    const row = `
                        <tr>
                            <td class="whitespace-nowrap py-4 pl-4 pr-3 text-sm font-medium text-slate-900 sm:pl-6">${material.id}</td>
                            <td class="whitespace-nowrap px-3 py-4 text-sm text-slate-500">${material.nama_material}</td>
                            <td class="whitespace-nowrap px-3 py-4 text-sm text-slate-500">${material.satuan}</td>
                            <td class="whitespace-nowrap px-3 py-4 text-sm text-slate-500">${material.stok}</td>
                            <td class="relative whitespace-nowrap py-4 pl-3 pr-4 text-right text-sm font-medium sm:pr-6">
                                <a href="${editUrl}" class="text-blue-600 hover:text-blue-900">Edit</a>
                                <form action="${deleteUrl}" method="POST" class="inline">
                                    <input type="hidden" name="_token" value="${csrfToken}">
                                    <input type="hidden" name="_method" value="DELETE">
                                    <button type="submit" class="ml-4 text-red-600 hover:text-red-900" onclick="return confirm('Apakah Anda yakin ingin menghapus material ini?')">Hapus</button>
                                </form>
                            </td>
                        </tr>
                    `;
                    tableBody.innerHTML += row;
                });
            } else {
                const row = `
                    <tr>
                        <td colspan="5" class="whitespace-nowrap px-3 py-4 text-sm text-slate-500 text-center">Tidak ada material yang ditemukan.</td>
                    </tr>
                `;
                tableBody.innerHTML = row;
            }
        }
        
        // --- SEARCH EVENT LISTENER ---
        if (searchInput) {
            let debounceTimer;
            searchInput.addEventListener('keyup', function () {
                const searchQuery = this.value;
                clearTimeout(debounceTimer);
                debounceTimer = setTimeout(() => {
                    fetchMaterials(searchQuery);
                }, 300); // 300ms delay
            });
        }
    });
</script>
@endpush