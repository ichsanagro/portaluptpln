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

    {{-- Card Header --}}
    <div class="border-b border-slate-200 p-6">
        <div class="flex flex-wrap items-center justify-between gap-4">
            <div class="w-full md:w-auto">
                <h3 class="text-xl font-semibold text-slate-800">Daftar Material</h3>
                <p class="mt-1 text-sm text-slate-600">Cari, tambah, atau kelola semua material yang terdaftar.</p>
            </div>
            <div class="flex w-full flex-col items-stretch gap-3 sm:w-auto sm:flex-row sm:items-center">
                {{-- Search Box --}}
                    <input type="text" name="search" id="search" class="block w-full rounded-md border-0 py-2.5 pl-10 text-slate-900 ring-1 ring-inset ring-slate-300 placeholder:text-slate-400 focus:ring-2 focus:ring-inset focus:ring-blue-600 sm:text-sm sm:leading-6" placeholder="Cari material..." value="{{ $search ?? '' }}">
                </div>
                {{-- Add Button --}}
                <a href="{{ route('material.create') }}" class="flex items-center justify-center gap-2 rounded-md bg-blue-600 px-4 py-2.5 text-sm font-semibold text-white shadow-sm hover:bg-blue-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-blue-600">
                    <svg class="-ml-0.5 h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                        <path d="M10.75 4.75a.75.75 0 00-1.5 0v4.5h-4.5a.75.75 0 000 1.5h4.5v4.5a.75.75 0 001.5 0v-4.5h4.5a.75.75 0 000-1.5h-4.5v-4.5z" />
                    </svg>
                    <span>Tambah Material</span>
                </a>
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
                                <a href="{{ route('material.edit', $material->id) }}" class="text-blue-600 hover:text-blue-900">Edit</a>
                                <form action="{{ route('material.destroy', $material->id) }}" method="POST" class="inline">
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

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const searchInput = document.getElementById('search');
        const tableBody = document.getElementById('material-table-body');
        const editUrlTemplate = '{{ route('material.edit', ['id' => ':id']) }}';
        const deleteUrlTemplate = '{{ route('material.destroy', ['id' => ':id']) }}';
        const csrfToken = '{{ csrf_token() }}';

        function fetchMaterials(searchQuery) {
            const url = `{{ route('material.index') }}?search=${searchQuery}`;

            fetch(url, {
                headers: {
                    'X-Requested-With': 'XMLHttpRequest'
                }
            })
            .then(response => response.json())
            .then(data => {
                updateTable(data);
            })
            .catch(error => {
                console.error('Error fetching materials:', error);
            });
        }

        function updateTable(materials) {
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

        searchInput.addEventListener('keyup', function () {
            const searchQuery = this.value;
            fetchMaterials(searchQuery);
        });
    });
</script>
@endpush
@endsection