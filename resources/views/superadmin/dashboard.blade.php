@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <h1 class="text-3xl font-bold text-gray-800">Super Admin Dashboard</h1>
    <p class="mt-2 text-gray-600">Selamat datang di panel Super Admin. Dari sini Anda dapat mengelola seluruh aspek aplikasi.</p>

    <div class="mt-8 grid grid-cols-1 md:grid-cols-2 gap-6">
        <a href="{{ route('superadmin.users.index') }}" class="block p-6 bg-white border border-gray-200 rounded-lg shadow hover:bg-gray-100">
            <h5 class="mb-2 text-2xl font-bold tracking-tight text-gray-900">Manajemen Pengguna</h5>
            <p class="font-normal text-gray-700">Tambah, edit, hapus, dan atur peran pengguna yang terdaftar di sistem.</p>
        </a>
        
        {{-- Add other cards for other management features here --}}
    </div>
</div>
@endsection
