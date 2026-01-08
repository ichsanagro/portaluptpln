@extends('layouts.app')

@section('title', 'Peminjaman Material')

@section('content')
<x-card>
    {{-- Card Header --}}
    <div class="border-b border-slate-200 p-6">
        <div class="flex flex-wrap items-center justify-between gap-4">
            <div class="w-full md:w-auto">
                <h3 class="text-xl font-semibold text-slate-800">Daftar Material Tersedia</h3>
                <p class="mt-1 text-sm text-slate-600">Klik tombol "Pinjam" untuk menambahkan material ke keranjang peminjaman Anda.</p>
            </div>
            <div class="relative flex w-full flex-col items-stretch gap-3 sm:w-auto sm:flex-row sm:items-center">
                {{-- Search Box --}}
                <input type="text" name="search" id="search" class="block w-full rounded-md border-0 py-2.5 pl-10 text-slate-900 ring-1 ring-inset ring-slate-300 placeholder:text-slate-400 focus:ring-2 focus:ring-inset focus:ring-blue-600 sm:text-sm sm:leading-6" placeholder="Cari material...">
                {{-- Cart Button --}}
                <button type="button" id="open-modal-btn" class="relative flex items-center justify-center gap-2 rounded-md bg-blue-600 px-4 py-2.5 text-sm font-semibold text-white shadow-sm hover:bg-blue-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-blue-600">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-5 h-5">
                        <path d="M1 1.75A.75.75 0 011.75 1h1.628a1.75 1.75 0 011.734 1.51L5.18 3a.75.75 0 01-1.496.088L3.628 2.5H1.75A.75.75 0 011 1.75zM3.12 5.133a1.75 1.75 0 011.75-1.633h10.26l-1.31 5.242a2.75 2.75 0 01-2.705 2.26H6.182a2.75 2.75 0 01-2.705-2.26L3.12 5.133zM8.5 14.25a1.5 1.5 0 100-3 1.5 1.5 0 000 3zM15.5 14.25a1.5 1.5 0 100-3 1.5 1.5 0 000 3z" />
                      </svg>
                      <span>Keranjang Peminjaman</span>
                    <span id="cart-badge" class="absolute -top-2 -right-2 flex h-5 w-5 items-center justify-center rounded-full bg-red-500 text-xs font-bold text-white hidden">0</span>
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
                        @foreach ($all_materials as $material)
                        <tr>
                            <td class="whitespace-nowrap py-4 pl-4 pr-3 text-sm font-medium text-slate-900 sm:pl-6">{{ $material->id }}</td>
                            <td class="whitespace-nowrap px-3 py-4 text-sm text-slate-500">{{ $material->nama_material }}</td>
                            <td class="whitespace-nowrap px-3 py-4 text-sm text-slate-500">{{ $material->satuan }}</td>
                            <td class="whitespace-nowrap px-3 py-4 text-sm text-slate-500">{{ $material->stok }}</td>
                            <td class="relative whitespace-nowrap py-4 pl-3 pr-4 text-right text-sm font-medium sm:pr-6">
                                <button type="button" class="pinjam-btn text-blue-600 hover:text-blue-900"
                                    data-id="{{ $material->id }}"
                                    data-nama="{{ $material->nama_material }}"
                                    data-stok="{{ $material->stok }}"
                                    data-satuan="{{ $material->satuan }}">
                                    Pinjam
                                </button>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-card>
@endsection

@section('modal-content')
{{-- Modal Keranjang Peminjaman --}}
<div id="peminjaman-modal" class="absolute inset-0 z-20 hidden overflow-y-auto bg-black/30 backdrop-blur-sm">
    <div class="flex min-h-full items-center justify-center p-4">
        <div class="w-full max-w-lg rounded-lg bg-white p-6 shadow-xl">
            <div class="flex items-center justify-between border-b border-slate-200 pb-4">
                <h3 class="text-xl font-semibold text-slate-800">Keranjang Peminjaman Material</h3>
                <button type="button" id="close-modal-btn" class="text-gray-400 hover:text-gray-500">
                    <svg class="h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
            <form id="peminjaman-form" action="{{ route('logistik.userlogistik.peminjaman.store') }}" method="POST" class="mt-6">
                @csrf
                <div id="cart-items-container" class="space-y-4 max-h-80 overflow-y-auto pr-2">
                    {{-- Item keranjang akan dirender di sini oleh JavaScript --}}
                    <p class="text-center text-slate-500">Keranjang peminjaman Anda kosong.</p>
                </div>

                {{-- Container untuk hidden inputs --}}
                <div id="hidden-inputs-container"></div>

                <div class="mt-6 flex items-center justify-end gap-x-6">
                    <button type="button" id="cancel-btn" class="text-sm font-semibold leading-6 text-slate-900">Batal</button>
                    <button type="submit" id="submit-peminjaman-btn" class="rounded-md bg-blue-600 px-4 py-2 text-sm font-semibold text-white shadow-sm hover:bg-blue-500 disabled:opacity-50" disabled>
                        Ajukan Peminjaman
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
    // --- STATE ---
    let peminjamanCart = []; // { id, nama, stok, satuan, jumlah }

    // --- DOM ELEMENTS ---
    const searchInput = document.getElementById('search');
    const tableBody = document.getElementById('material-table-body');
    const modal = document.getElementById('peminjaman-modal');
    const openModalBtn = document.getElementById('open-modal-btn');
    const closeModalBtn = document.getElementById('close-modal-btn');
    const cancelBtn = document.getElementById('cancel-btn');
    const cartBadge = document.getElementById('cart-badge');
    const cartItemsContainer = document.getElementById('cart-items-container');
    const peminjamanForm = document.getElementById('peminjaman-form');
    const hiddenInputsContainer = document.getElementById('hidden-inputs-container');
    const submitPeminjamanBtn = document.getElementById('submit-peminjaman-btn');

    const allMaterials = @json($all_materials);

    // --- FUNCTIONS ---

    function updateCartBadge() {
        const count = peminjamanCart.length;
        if (count > 0) {
            cartBadge.textContent = count;
            cartBadge.classList.remove('hidden');
            submitPeminjamanBtn.disabled = false;
        } else {
            cartBadge.classList.add('hidden');
            submitPeminjamanBtn.disabled = true;
        }
    }

    function renderCartItems() {
        cartItemsContainer.innerHTML = ''; // Kosongkan kontainer

        if (peminjamanCart.length === 0) {
            cartItemsContainer.innerHTML = '<p class="text-center text-slate-500">Keranjang peminjaman Anda kosong.</p>';
            return;
        }

        peminjamanCart.forEach(item => {
            const itemElement = document.createElement('div');
            itemElement.classList.add('cart-item', 'flex', 'items-center', 'gap-4', 'border-b', 'pb-4');
            itemElement.dataset.id = item.id;

            itemElement.innerHTML = `
                <div class="flex-1">
                    <p class="font-semibold text-slate-800">${item.nama}</p>
                    <p class="text-sm text-slate-500">Stok tersedia: ${item.stok}</p>
                </div>
                <div class="w-1/4">
                    <label for="jumlah_${item.id}" class="sr-only">Jumlah</label>
                    <input type="number" id="jumlah_${item.id}" value="${item.jumlah}" min="1" max="${item.stok}"
                           class="cart-item-jumlah block w-full rounded-md border-0 py-1.5 text-slate-900 shadow-sm ring-1 ring-inset ring-slate-300 focus:ring-2 focus:ring-inset focus:ring-blue-600 sm:text-sm"
                           required>
                </div>
                <button type="button" class="remove-from-cart-btn rounded-md bg-red-500 px-3 py-2 text-white hover:bg-red-600" data-id="${item.id}">
                    &times;
                </button>
            `;
            cartItemsContainer.appendChild(itemElement);
        });
    }

    function addToCart(materialId) {
        // Cek apakah item sudah ada di keranjang
        if (peminjamanCart.some(item => item.id == materialId)) {
            alert('Material ini sudah ada di keranjang Anda.');
            return;
        }

        const material = allMaterials.find(m => m.id == materialId);
        if (material) {
            if (material.stok <= 0) {
                alert('Stok material ini sudah habis.');
                return;
            }
            peminjamanCart.push({
                id: material.id,
                nama: material.nama_material,
                stok: material.stok,
                satuan: material.satuan,
                jumlah: 1 // Default jumlah pinjam
            });
            alert(`"${material.nama_material}" telah ditambahkan ke keranjang.`);
            updateCartBadge();
        }
    }
    function removeFromCart(materialId) {
        peminjamanCart = peminjamanCart.filter(item => item.id != materialId);
        updateCartBadge();
        renderCartItems(); // Re-render setelah menghapus
    }

    function updateCartItemQuantity(materialId, newQuantity) {
        const item = peminjamanCart.find(item => item.id == materialId);
        if (item) {
            const maxStok = parseInt(item.stok, 10);
            let quantity = parseInt(newQuantity, 10);

            if (isNaN(quantity) || quantity < 1) {
                quantity = 1;
            } else if (quantity > maxStok) {
                quantity = maxStok;
                alert(`Jumlah peminjaman tidak boleh melebihi stok yang tersedia (${maxStok}).`);
            }
            item.jumlah = quantity;
            // Update nilai inputnya juga untuk konsistensi jika user mengetik nilai invalid
            const inputElement = document.getElementById(`jumlah_${materialId}`);
            if(inputElement) inputElement.value = quantity;
        }
    }

    function fetchAndFilterMaterials(searchQuery) {
        const lowerCaseQuery = searchQuery.toLowerCase();
        const filteredMaterials = allMaterials.filter(material =>
            material.nama_material.toLowerCase().includes(lowerCaseQuery)
        );
        updateTable(filteredMaterials);
    }

    function updateTable(materials) {
        tableBody.innerHTML = '';
        if (materials.length > 0) {
            materials.forEach(material => {
                tableBody.innerHTML += `
                    <tr>
                        <td class="whitespace-nowrap py-4 pl-4 pr-3 text-sm font-medium text-slate-900 sm:pl-6">${material.id}</td>
                        <td class="whitespace-nowrap px-3 py-4 text-sm text-slate-500">${material.nama_material}</td>
                        <td class="whitespace-nowrap px-3 py-4 text-sm text-slate-500">${material.satuan}</td>
                        <td class="whitespace-nowrap px-3 py-4 text-sm text-slate-500">${material.stok}</td>
                        <td class="relative whitespace-nowrap py-4 pl-3 pr-4 text-right text-sm font-medium sm:pr-6">
                            <button type="button" class="pinjam-btn text-blue-600 hover:text-blue-900"
                                data-id="${material.id}" data-nama="${material.nama_material}" data-stok="${material.stok}">
                                Pinjam
                            </button>
                        </td>
                    </tr>
                `;
            });
        } else {
            tableBody.innerHTML = `<tr><td colspan="5" class="text-center py-4">Tidak ada material yang cocok.</td></tr>`;
        }
    }


    // --- EVENT LISTENERS ---

    // Buka Modal
    openModalBtn.addEventListener('click', () => {
        renderCartItems();
        modal.classList.remove('hidden');
    });

    // Tutup Modal
    closeModalBtn.addEventListener('click', () => modal.classList.add('hidden'));
    cancelBtn.addEventListener('click', () => modal.classList.add('hidden'));

    // Klik tombol "Pinjam" di tabel
    tableBody.addEventListener('click', function (e) {
        if (e.target.classList.contains('pinjam-btn')) {
            const materialId = e.target.dataset.id;
            addToCart(materialId);
        }
    });
    
    // Live search di tabel utama
    searchInput.addEventListener('keyup', function () {
        fetchAndFilterMaterials(this.value);
    });

    // Interaksi di dalam keranjang (modal)
    cartItemsContainer.addEventListener('change', function(e) {
        if (e.target.classList.contains('cart-item-jumlah')) {
            const materialId = e.target.closest('.cart-item').dataset.id;
            updateCartItemQuantity(materialId, e.target.value);
        }
    });

    cartItemsContainer.addEventListener('click', function(e) {
        if (e.target.classList.contains('remove-from-cart-btn')) {
            const materialId = e.target.dataset.id;
            removeFromCart(materialId);
        }
    });

    // Submit form peminjaman
    peminjamanForm.addEventListener('submit', function(e) {
        e.preventDefault(); // Mencegah submit standar

        hiddenInputsContainer.innerHTML = ''; // Kosongkan dulu
        
        peminjamanCart.forEach((item, index) => {
            hiddenInputsContainer.innerHTML += `
                <input type="hidden" name="materials[${index}][id]" value="${item.id}">
                <input type="hidden" name="materials[${index}][jumlah]" value="${item.jumlah}">
            `;
        });
        
        // Submit form secara programmatic
        this.submit();
    });

    // Initial render
    fetchAndFilterMaterials('');
    updateCartBadge();
});
</script>
@endpush
