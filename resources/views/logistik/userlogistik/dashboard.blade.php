@extends('layouts.app')

@section('title', '')

@push('header-items')
    @include('components.hse-stats-small')
@endpush

@section('content')
<div class="container mx-auto p-4">
    {{-- Content specific to Logistik User Dashboard --}}
    <h2 class="text-xl font-bold mb-4 text-gray-800 mt-6">Konten Logistik Lainnya</h2>
    <p class="text-gray-700">Ini adalah area untuk konten spesifik logistik Anda.</p>
</div>
@endsection
