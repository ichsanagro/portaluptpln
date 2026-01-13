@extends('layouts.app')

@section('title', 'Permintaan Material')

@section('content')
<x-card>
    {{-- Success Message --}}
    @if (session('success'))
        <div id="success-message" class="rounded-md bg-green-50 p-4 mb-6">
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

    {{-- Card Header --}}
    <div class="border-b border-slate-200 p-6">
        <div class="flex flex-wrap items-center justify-between gap-4">
            <div class="w-full md:w-auto">
                <h3 class="text-xl font-semibold text-slate-800">Daftar Material Permintaan</h3>
                <p class="mt-1 text-sm text-slate-600">Klik tombol "Lihat" untuk melihat detail material atau "Pesan" untuk menambahkan ke keranjang.</p>
            </div>
            <div class="relative flex w-full flex-col items-stretch gap-3 sm:w-auto sm:flex-row sm:items-center">
                {{-- Search Box --}}
                <input type="text" name="search" id="search" class="block w-full rounded-md border-0 py-2.5 pl-10 text-slate-900 ring-1 ring-inset ring-slate-300 placeholder:text-slate-400 focus:ring-2 focus:ring-inset focus:ring-blue-600 sm:text-sm sm:leading-6" placeholder="Cari material...">
                {{-- Cart Button --}}
                <button type="button" id="open-modal-btn" class="relative flex items-center justify-center gap-2 rounded-md bg-blue-600 px-4 py-2.5 text-sm font-semibold text-white shadow-sm hover:bg-blue-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-blue-600">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-5 h-5">
                        <path d="M1 1.75A.75.75 0 011.75 1h1.628a1.75 1.75 0 011.734 1.51L5.18 3a.75.75 0 01-1.496.088L3.628 2.5H1.75A.75.75 0 011 1.75zM3.12 5.133a1.75 1.75 0 011.75-1.633h10.26l-1.31 5.242a2.75 2.75 0 01-2.705 2.26H6.182a2.75 2.75 0 01-2.705-2.26L3.12 5.133zM8.5 14.25a1.5 1.5 0 100-3 1.5 1.5 0 000 3zM15.5 14.25a1.5 1.5 0 100-3 1.5 1.5 0 000 3z" />
                      </svg>
                      <span>Keranjang</span>
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
                        @foreach ($materials_permintaan as $material)
                        <tr>
                            <td class="whitespace-nowrap py-4 pl-4 pr-3 text-sm font-medium text-slate-900 sm:pl-6">{{ $material->id }}</td>
                            <td class="whitespace-nowrap px-3 py-4 text-sm text-slate-500">{{ $material->nama_material }}</td>
                            <td class="whitespace-nowrap px-3 py-4 text-sm text-slate-500">{{ $material->satuan }}</td>
                            <td class="whitespace-nowrap px-3 py-4 text-sm text-slate-500">{{ $material->stok }}</td>
                            <td class="relative whitespace-nowrap py-4 pl-3 pr-4 text-right text-sm font-medium sm:pr-6">
                                <button type="button" class="lihat-btn text-green-600 hover:text-green-900 mr-4"
                                    data-id="{{ $material->id }}"
                                    data-nama="{{ $material->nama_material }}"
                                    data-satuan="{{ $material->satuan }}"
                                    data-stok="{{ $material->stok }}"
                                    data-spesifikasi="{{ $material->spesifikasi }}"
                                    data-foto="{{ $material->foto }}">
                                    Lihat
                                </button>
                                <button type="button" class="pesan-btn text-blue-600 hover:text-blue-900"
                                    data-id="{{ $material->id }}"
                                    data-nama="{{ $material->nama_material }}"
                                    data-stok="{{ $material->stok }}"
                                    data-satuan="{{ $material->satuan }}">
                                    Pesan
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
{{-- Modal Keranjang Pesanan --}}
<div id="permintaan-modal" class="fixed inset-0 z-20 hidden overflow-y-auto bg-black/50 backdrop-blur-sm transition-opacity duration-300 ease-out opacity-0">
    <div class="flex min-h-full items-center justify-center p-4 text-center sm:block sm:p-0">
        <!-- This is here to "trap" focus -->
        <span class="hidden sm:inline-block sm:h-screen sm:align-middle" aria-hidden="true">&#8203;</span>
        <div class="inline-block align-bottom bg-white rounded-lg px-4 pt-5 pb-4 text-left overflow-hidden shadow-2xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full sm:p-6 opacity-0 scale-95 duration-300 ease-out"
            role="dialog" aria-modal="true" aria-labelledby="modal-title">
            <div class="flex items-center justify-between border-b border-slate-300 px-4 py-3">
                <h3 class="text-xl font-bold text-slate-800" id="modal-title">Keranjang Permintaan</h3>
                <button type="button" id="close-modal-btn" class="text-gray-500 hover:text-gray-700 rounded-full p-1 hover:bg-gray-100 transition-colors">
                    <svg class="h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
            <form id="permintaan-form" action="{{ route('logistik.userlogistik.permintaan.store') }}" method="POST" class="mt-6">
                @csrf
                <div id="cart-items-container" class="space-y-6 max-h-80 overflow-y-auto pt-4 pb-2">
                    {{-- Item keranjang akan dirender di sini oleh JavaScript --}}
                    <div class="text-center p-6 text-gray-500 italic">
                        <p class="mb-2">Keranjang permintaan Anda kosong.</p>
                        <p class="text-sm">Silakan tambahkan material dari daftar yang tersedia.</p>
                    </div>
                </div>

                {{-- Container untuk hidden inputs --}}
                <div id="hidden-inputs-container"></div>

                <div class="mt-6 flex items-center justify-end gap-x-3">
                    <button type="button" id="cancel-btn" class="rounded-md border border-gray-300 bg-white px-4 py-2 text-sm font-medium text-gray-700 shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2">Batal</button>
                    <button type="submit" id="submit-permintaan-btn" class="rounded-md bg-blue-600 px-4 py-2 text-sm font-semibold text-white shadow-sm hover:bg-blue-500 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 disabled:opacity-50" disabled>
                        Ajukan Permintaan
                    </button>
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
    // --- STATE ---
    let userlogistikCart = loadCart();

    // --- CART FUNCTIONS ---
    function loadCart() {
        const cart = localStorage.getItem('userlogistikCart');
        return cart ? JSON.parse(cart) : [];
    }

    function saveCart() {
        localStorage.setItem('userlogistikCart', JSON.stringify(userlogistikCart));
    }

    // --- DOM ELEMENTS ---
    const searchInput = document.getElementById('search');
    const tableBody = document.getElementById('material-table-body');
    const modal = document.getElementById('permintaan-modal');
    const openModalBtn = document.getElementById('open-modal-btn');
    const closeModalBtn = document.getElementById('close-modal-btn');
    const cancelBtn = document.getElementById('cancel-btn');
    const cartBadge = document.getElementById('cart-badge');
    const cartItemsContainer = document.getElementById('cart-items-container');
    const permintaanForm = document.getElementById('permintaan-form');
    const hiddenInputsContainer = document.getElementById('hidden-inputs-container');
    const submitPermintaanBtn = document.getElementById('submit-permintaan-btn');

    // --- DETAIL MODAL ELEMENTS ---
    const detailModal = document.getElementById('detail-material-modal');
    const closeDetailModalBtn = document.getElementById('close-detail-modal-btn');
    const closeDetailBtn = document.getElementById('close-detail-btn');

    const allMaterials = @json($materials_permintaan);

    // --- FUNCTIONS ---

    function updateCartBadge() {
        const count = userlogistikCart.length;
        if (count > 0) {
            cartBadge.textContent = count;
            cartBadge.classList.remove('hidden');
            submitPermintaanBtn.disabled = false;
        } else {
            cartBadge.classList.add('hidden');
            submitPermintaanBtn.disabled = true;
        }
    }

    function renderCartItems() {
        cartItemsContainer.innerHTML = ''; // Kosongkan kontainer

        if (userlogistikCart.length === 0) {
            cartItemsContainer.innerHTML = '<p class="text-center text-slate-500">Keranjang permintaan Anda kosong.</p>';
            return;
        }

        userlogistikCart.forEach((item, index) => {
            const itemElement = document.createElement('div');
            itemElement.classList.add('cart-item', 'space-y-4', 'py-4', 'border-b', 'border-gray-100', 'last:border-b-0');
            itemElement.dataset.id = item.id;

            itemElement.innerHTML = `
                <div class="flex items-center gap-x-4">
                    <div class="flex-1">
                        <p class="font-medium text-gray-800">${item.nama}</p>
                        <p class="text-sm text-gray-500">Stok: ${item.stok} ${item.satuan}</p>
                    </div>
                    <div class="flex items-center w-28">
                        <button type="button" class="quantity-minus-btn p-1 rounded-l-md border border-gray-300 bg-gray-50 hover:bg-gray-100 transition-colors disabled:opacity-50" data-id="${item.id}" ${item.jumlah <= 1 ? 'disabled' : ''}>
                            <svg class="h-4 w-4 text-gray-700" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 12H4" />
                            </svg>
                        </button>
                        <label for="jumlah_${item.id}" class="sr-only">Jumlah</label>
                        <input type="number" id="jumlah_${item.id}" value="${item.jumlah}" min="1" max="${item.stok}"
                               class="cart-item-jumlah block w-full border-t border-b border-gray-300 p-2 text-center text-sm focus:ring-blue-500 focus:border-blue-500"
                               required>
                        <button type="button" class="quantity-plus-btn p-1 rounded-r-md border border-gray-300 bg-gray-50 hover:bg-gray-100 transition-colors disabled:opacity-50" data-id="${item.id}" ${item.jumlah >= item.stok ? 'disabled' : ''}>
                            <svg class="h-4 w-4 text-gray-700" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                            </svg>
                        </button>
                    </div>
                    <button type="button" class="remove-from-cart-btn text-gray-400 hover:text-red-500 p-2 rounded-full transition-colors" data-id="${item.id}">
                        <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>
                <div>
                    <label for="catatan_${item.id}" class="sr-only">Catatan Kebutuhan</label>
                    <textarea id="catatan_${item.id}" name="materials[${index}][catatan]" rows="2"
                              class="cart-item-catatan block w-full rounded-md border-0 py-1.5 text-slate-900 shadow-sm ring-1 ring-inset ring-slate-300 placeholder:text-slate-400 focus:ring-2 focus:ring-inset focus:ring-blue-600 sm:text-sm sm:leading-6"
                              placeholder="Contoh: Digunakan untuk perbaikan gardu A...">${item.catatan || ''}</textarea>
                </div>
            `;
            cartItemsContainer.appendChild(itemElement);
        });
    }

    function addToCart(materialId) {
        // Cek apakah item sudah ada di keranjang
        if (userlogistikCart.some(item => item.id == materialId)) {
            alert('Material ini sudah ada di keranjang Anda.');
            return;
        }

        const material = allMaterials.find(m => m.id == materialId);
        if (material) {
            if (material.stok <= 0) {
                alert('Stok material ini sudah habis.');
                return;
            }
            userlogistikCart.push({
                id: material.id,
                nama: material.nama_material,
                stok: material.stok,
                satuan: material.satuan,
                jumlah: 1, // Default jumlah
                catatan: '' // Default catatan kosong
            });
            saveCart();
            alert(`"${material.nama_material}" telah ditambahkan ke keranjang.`);
            updateCartBadge();
        }
    }

    function removeFromCart(materialId) {
        userlogistikCart = userlogistikCart.filter(item => item.id != materialId);
        saveCart();
        updateCartBadge();
        renderCartItems(); // Re-render setelah menghapus
    }

    function updateCartItemQuantity(materialId, newQuantity) {
        const item = userlogistikCart.find(item => item.id == materialId);
        if (item) {
            const maxStok = parseInt(item.stok, 10);
            let quantity = parseInt(newQuantity, 10);

            if (isNaN(quantity) || quantity < 1) {
                quantity = 1;
            } else if (quantity > maxStok) {
                quantity = maxStok;
                alert(`Jumlah permintaan tidak boleh melebihi stok yang tersedia (${maxStok}).`);
            }
            item.jumlah = quantity;
            saveCart();

            const inputElement = document.getElementById(`jumlah_${materialId}`);
            if(inputElement) inputElement.value = quantity;

            const cartItemElement = inputElement.closest('.cart-item');
            const minusBtn = cartItemElement.querySelector('.quantity-minus-btn');
            const plusBtn = cartItemElement.querySelector('.quantity-plus-btn');

            if (minusBtn) minusBtn.disabled = (quantity <= 1);
            if (plusBtn) plusBtn.disabled = (quantity >= maxStok);
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
                                <button type="button" class="lihat-btn text-green-600 hover:text-green-900 mr-4"
                                    data-id="${material.id}" data-nama="${material.nama_material}" data-satuan="${material.satuan}"
                                    data-stok="${material.stok}" data-spesifikasi="${material.spesifikasi || ''}" data-foto="${material.foto || ''}">
                                    Lihat
                                </button>
                                <button type="button" class="pesan-btn text-blue-600 hover:text-blue-900"
                                    data-id="${material.id}" data-nama="${material.nama_material}" data-stok="${material.stok}" data-satuan="${material.satuan}">
                                    Pesan
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
        setTimeout(() => {
            modal.classList.remove('opacity-0'); // Remove backdrop initial opacity
            modal.classList.add('opacity-100'); // Add backdrop final opacity
            modal.querySelector('.inline-block').classList.remove('opacity-0', 'scale-95'); // Actual modal content transition
            modal.querySelector('.inline-block').classList.add('opacity-100', 'scale-100');
        }, 50); // Small delay to allow 'hidden' removal to register
    });

    // Tutup Modal
    const closeModal = () => {
        modal.classList.remove('opacity-100'); // Remove backdrop final opacity
        modal.classList.add('opacity-0'); // Add backdrop initial opacity
        modal.querySelector('.inline-block').classList.remove('opacity-100', 'scale-100'); // Actual modal content transition
        modal.querySelector('.inline-block').classList.add('opacity-0', 'scale-95');
        setTimeout(() => {
            modal.classList.add('hidden');
        }, 300); // Match transition duration
    };

    closeModalBtn.addEventListener('click', closeModal);
    cancelBtn.addEventListener('click', closeModal);

    // Klik tombol "Lihat" atau "Pesan" di tabel
    tableBody.addEventListener('click', function (e) {
        if (e.target.classList.contains('lihat-btn')) {
            viewMaterial(e.target);
        }
        if (e.target.classList.contains('pesan-btn')) {
            const materialId = e.target.dataset.id;
            addToCart(materialId);
        }
    });

    searchInput.addEventListener('keyup', function () { fetchAndFilterMaterials(this.value); });
    
    cartItemsContainer.addEventListener('input', function(e) {
        if (e.target.classList.contains('cart-item-jumlah')) {
            const materialId = e.target.closest('.cart-item').dataset.id;
            updateCartItemQuantity(materialId, parseInt(e.target.value, 10));
        }
        if (e.target.classList.contains('cart-item-catatan')) {
            const materialId = e.target.closest('.cart-item').dataset.id;
            const item = userlogistikCart.find(item => item.id == materialId);
            if(item) {
                item.catatan = e.target.value;
                saveCart();
            }
        }
    });

    cartItemsContainer.addEventListener('click', function(e) {
        if (e.target.closest('.remove-from-cart-btn')) {
            removeFromCart(e.target.closest('.remove-from-cart-btn').dataset.id);
        }
        if (e.target.closest('.quantity-minus-btn')) {
            const materialId = e.target.closest('.quantity-minus-btn').dataset.id;
            const input = document.getElementById(`jumlah_${materialId}`);
            if (parseInt(input.value) > 1) updateCartItemQuantity(materialId, parseInt(input.value) - 1);
        }
        if (e.target.closest('.quantity-plus-btn')) {
            const materialId = e.target.closest('.quantity-plus-btn').dataset.id;
            const input = document.getElementById(`jumlah_${materialId}`);
            updateCartItemQuantity(materialId, parseInt(input.value) + 1);
        }
    });

    permintaanForm.addEventListener('submit', function(e) {
        e.preventDefault();
        hiddenInputsContainer.innerHTML = '';
        userlogistikCart.forEach((item, index) => {
            const catatanTextarea = document.getElementById(`catatan_${item.id}`);
            const catatanValue = catatanTextarea ? catatanTextarea.value : '';
            hiddenInputsContainer.innerHTML += `
                <input type="hidden" name="materials[${index}][id]" value="${item.id}">
                <input type="hidden" name="materials[${index}][jumlah]" value="${item.jumlah}">
                <input type="hidden" name="materials[${index}][catatan]" value="${catatanValue}">
            `;
        });
        this.submit();
    });

    // Initial render
    fetchAndFilterMaterials('');
    updateCartBadge();

    // Check for success message and clear cart
    if (document.getElementById('success-message')) {
        localStorage.removeItem('userlogistikCart');
        userlogistikCart = []; // Clear the in-memory cart as well
        updateCartBadge();
    }
});
</script>
@endpush