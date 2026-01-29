@extends('layouts.app')

@section('title', 'Monitoring Riwayat')

@section('content')
<x-card>
    {{-- Card Header --}}
    <div class="border-b border-slate-200 p-6">
        <div class="flex flex-wrap items-center justify-between gap-4">
            <div class="w-full md:w-auto">
                <h3 class="text-xl font-semibold text-slate-800">Monitoring Daftar Riwayat</h3>
                <p class="mt-1 text-sm text-slate-600">Melihat daftar riwayat peminjaman dan permintaan dalam mode read-only.</p>
            </div>
            <div class="w-full sm:w-auto">
                {{-- Search Box --}}
                <div class="relative">
                    <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3">
                         <svg class="h-5 w-5 text-slate-400" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-5.197-5.197m0 0A7.5 7.5 0 105.196 5.196a7.5 7.5 0 0010.607 10.607z" />
                        </svg>
                    </div>
                    <input type="text" name="search" id="search" class="block w-full rounded-md border-0 py-2.5 pl-10 text-slate-900 ring-1 ring-inset ring-slate-300 placeholder:text-slate-400 focus:ring-2 focus:ring-inset focus:ring-blue-600 sm:text-sm sm:leading-6" placeholder="Cari pesanan...">
                </div>
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
                            <th scope="col" class="py-3.5 pl-4 pr-3 text-left text-sm font-semibold text-slate-900 sm:pl-6">Tanggal</th>
                            <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-slate-900">User</th>
                            <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-slate-900">Material</th>
                            <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-slate-900">Status</th>
                            <th scope="col" class="relative py-3.5 pl-3 pr-4 sm:pr-6">
                                <span class="sr-only">Aksi</span>
                            </th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-200 bg-white">
                        @forelse ($peminjamans as $peminjaman)
                        <tr>
                            <td class="whitespace-nowrap py-4 pl-4 pr-3 text-sm text-slate-500 sm:pl-6">
                                {{ \Carbon\Carbon::parse($peminjaman->created_at)->format('d M Y H:i') }}
                            </td>
                            <td class="whitespace-nowrap px-3 py-4 text-sm font-medium text-slate-900">
                                {{ $peminjaman->user->name ?? 'N/A' }}
                            </td>
                            <td class="px-3 py-4 text-sm text-slate-500">
                                <ul class="list-disc pl-5 space-y-1">
                                    @foreach ($peminjaman->details as $detail)
                                        <li>
                                            {{ $detail->material->nama_material }} ({{ $detail->jumlah }} {{ $detail->material->satuan }})
                                            @if($detail->catatan)
                                                <br><span class="text-xs italic text-gray-500">Catatan: {{ \Illuminate\Support\Str::limit($detail->catatan, 30) }}</span>
                                            @endif
                                        </li>
                                    @endforeach
                                </ul>
                            </td>
                            <td class="whitespace-nowrap px-3 py-4 text-sm text-slate-500">
                                <span class="inline-flex items-center rounded-full px-2.5 py-0.5 text-xs font-medium {{
                                    $peminjaman->status === 'pending' ? 'bg-yellow-100 text-yellow-800' :
                                    ($peminjaman->status === 'approved' ? 'bg-green-100 text-green-800' :
                                    ($peminjaman->status === 'rejected' ? 'bg-red-100 text-red-800' :
                                    'bg-gray-100 text-gray-800'))
                                }}">
                                    {{ ucfirst($peminjaman->status) }}
                                </span>
                            </td>
                            <td class="relative space-x-2 whitespace-nowrap py-4 pl-3 pr-4 text-right text-sm font-medium sm:pr-6">
                                <button type="button" onclick="viewPeminjaman({{ $peminjaman->id }})" class="text-blue-600 hover:text-blue-900">Lihat</button>
                            </td>
                        </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="p-6 text-center text-gray-500 italic">Tidak ada riwayat.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-card>

{{-- Modal Lihat Detail Pesanan --}}
<div id="detail-pesanan-modal" class="fixed inset-0 z-20 hidden overflow-y-auto bg-black/50 backdrop-blur-sm transition-opacity duration-300 ease-out opacity-0">
    <div class="flex min-h-full items-center justify-center p-4 text-center sm:block sm:p-0">
        <span class="hidden sm:inline-block sm:h-screen sm:align-middle" aria-hidden="true">&#8203;</span>
        <div class="inline-block align-bottom bg-white rounded-lg px-4 pt-5 pb-4 text-left overflow-hidden shadow-2xl transform transition-all sm:my-8 sm:align-middle sm:max-w-2xl sm:w-full sm:p-6 opacity-0 scale-95 duration-300 ease-out"
            role="dialog" aria-modal="true" aria-labelledby="detail-modal-title">
            <div class="flex items-center justify-between border-b border-slate-300 pb-4">
                <h3 class="text-xl font-bold text-slate-800" id="detail-modal-title">Detail Pesanan</h3>
                <button type="button" id="close-detail-modal-btn" class="text-gray-500 hover:text-gray-700 rounded-full p-1 hover:bg-gray-100 transition-colors">
                    <svg class="h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
            <div id="detail-modal-content" class="mt-6 space-y-4">
                {{-- Content will be loaded here by JavaScript --}}
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
        const detailModal = document.getElementById('detail-pesanan-modal');
        const closeDetailModalBtn = document.getElementById('close-detail-modal-btn');
        const closeDetailBtn = document.getElementById('close-detail-btn');
        const detailModalContent = document.getElementById('detail-modal-content');

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

        window.viewPeminjaman = function(peminjamanId) {
            const url = `{{ url('superadmin/monitoring/riwayat') }}/${peminjamanId}`;
            
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
                let materialsHtml = '<ul class="list-disc pl-5 space-y-2">';
                data.details.forEach(detail => {
                    const isPeminjaman = detail.material.jenis_kebutuhan === 'peminjaman';
                    const typeText = isPeminjaman ? 'Peminjaman' : 'Permintaan';
                    const typeColorClass = isPeminjaman ? 'text-blue-600' : 'text-blue-600';

                    materialsHtml += `
                        <li>
                            <span class="font-semibold">${detail.material.nama_material}</span> (${detail.jumlah} ${detail.material.satuan}) - <span class="font-bold ${typeColorClass}">${typeText}</span>
                            <div class="text-xs pl-4">
                                ${detail.catatan ? `<p class="italic text-gray-600">Catatan: ${detail.catatan}</p>` : ''}
                                ${detail.material.lokasi ? `<p>Lokasi: ${detail.material.lokasi}</p>` : ''}
                                ${detail.material.tempat ? `<p>Tempat: ${detail.material.tempat}</p>` : ''}
                            </div>
                        </li>
                    `;
                });
                materialsHtml += '</ul>';

                detailModalContent.innerHTML = `
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-slate-700">Tanggal</label>
                            <p class="mt-1 text-sm text-slate-900">${new Date(data.created_at).toLocaleString('id-ID', { dateStyle: 'long', timeStyle: 'short' })}</p>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-slate-700">User</label>
                            <p class="mt-1 text-sm text-slate-900">${data.user.name}</p>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-slate-700">Status</label>
                            <p class="mt-1 text-sm text-slate-900">${data.status.charAt(0).toUpperCase() + data.status.slice(1)}</p>
                        </div>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-slate-700 mt-4">Material</label>
                        <div class="mt-1 text-sm text-slate-900 border rounded-md p-3 bg-gray-50">
                            ${materialsHtml}
                        </div>
                    </div>
                `;
                
                openDetailModal();
            })
            .catch(error => {
                console.error('Error fetching order details:', error);
                alert('Gagal memuat detail pesanan: ' + error.message);
            });
        };
    });
</script>
@endpush
