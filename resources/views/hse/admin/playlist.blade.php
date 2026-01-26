@extends('layouts.app')

@section('title', 'Kelola Playlist Video')

@section('content')
<div class="max-w-7xl mx-auto sm:px-6 lg:px-8 py-8">
    <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
        <div class="p-6 sm:p-8 bg-white border-b border-gray-200">
            <h1 class="text-2xl font-bold text-gray-800 mb-6">Kelola Playlist Video</h1>

            <!-- Video Player -->
            <div class="mb-6 bg-black rounded-lg shadow-lg overflow-hidden">
                <video id="playlist-player" class="w-full h-auto" controls autoplay>
                    <source src="" type="video/mp4">
                    Browser Anda tidak mendukung tag video.
                </video>
            </div>

            <!-- Upload Form -->
            <div class="mb-6">
                <form action="{{ route('hse.admin_playlist.store') }}" method="POST" enctype="multipart/form-data" class="bg-gray-50 p-6 rounded-lg shadow">
                    @csrf
                    <h2 class="text-xl font-semibold text-gray-700 mb-4">Upload Video Baru</h2>
                    <div class="flex items-center space-x-4">
                        <input type="file" name="videos[]" multiple accept="video/mp4,video/avi,video/mpeg" class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100">
                        <button type="submit" class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700">Upload</button>
                    </div>
                    @error('videos.*')
                        <p class="text-red-500 text-xs mt-2">{{ $message }}</p>
                    @enderror
                </form>
            </div>

            <!-- Playlist -->
            <div>
                <h2 class="text-xl font-semibold text-gray-700 mb-4">Daftar Putar</h2>
                <div id="playlist-items" class="space-y-3">
                    @forelse ($videos as $video)
                        <div data-id="{{ $video->id }}" class="flex items-center justify-between bg-white p-4 rounded-lg shadow cursor-move">
                            <div class="flex items-center">
                                <svg class="w-6 h-6 text-gray-400 mr-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path></svg>
                                <span class="font-medium text-gray-800">{{ $video->original_name }}</span>
                            </div>
                            <div class="flex items-center space-x-3">
                                <button class="play-button text-blue-500 hover:text-blue-700" data-src="{{ asset('storage/' . $video->path) }}">
                                    <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM9.555 7.168A1 1 0 008 8v4a1 1 0 001.555.832l3-2a1 1 0 000-1.664l-3-2z" clip-rule="evenodd"></path></svg>
                                </button>
                                <form action="{{ route('hse.admin_playlist.destroy', $video->id) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button type="button" onclick="confirmDelete(this)" class="text-red-500 hover:text-red-700">
                                        <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm4 0a1 1 0 012 0v6a1 1 0 11-2 0V8z" clip-rule="evenodd"></path></svg>
                                    </button>
                                </form>
                            </div>
                        </div>
                    @empty
                        <div class="text-center text-gray-500 py-4">
                            Tidak ada video dalam daftar putar.
                        </div>
                    @endforelse
                </div>
            </div>

        </div>
    </div>
</div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/sortablejs@1.15.0/Sortable.min.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const player = document.getElementById('playlist-player');
        const playlistItemsContainer = document.getElementById('playlist-items');
        let playlist = @json($videos->map(function($video) {
            return asset('storage/' . $video->path);
        }));
        let currentVideoIndex = 0;

        function playVideo(index) {
            if (index >= 0 && index < playlist.length) {
                player.src = playlist[index];
                player.load();
                player.play();
                currentVideoIndex = index;
            }
        }

        player.addEventListener('ended', function () {
            // Play next video
            currentVideoIndex++;
            if (currentVideoIndex >= playlist.length) {
                currentVideoIndex = 0; // Loop playlist
            }
            playVideo(currentVideoIndex);
        });

        // Play button listeners
        document.querySelectorAll('.play-button').forEach((button, index) => {
            button.addEventListener('click', function () {
                playVideo(index);
            });
        });

        // Initialize SortableJS
        new Sortable(playlistItemsContainer, {
            animation: 150,
            ghostClass: 'bg-blue-100',
            onEnd: function (evt) {
                let order = Array.from(playlistItemsContainer.children).map(child => child.dataset.id);
                
                fetch('{{ route("hse.admin_playlist.update_order") }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    },
                    body: JSON.stringify({ order: order })
                }).then(response => response.json())
                .then(data => {
                    if(data.status === 'success') {
                        // Re-fetch playlist order for player
                        playlist = Array.from(playlistItemsContainer.children).map(child => {
                            return child.querySelector('.play-button').dataset.src;
                        });
                        console.log('Playlist order updated');
                    }
                });
            }
        });

        // Play the first video on page load if playlist is not empty
        if (playlist.length > 0) {
            playVideo(0);
        }
    });

    function confirmDelete(button) {
        const form = button.closest('form');
        Swal.fire({
            title: 'Anda Yakin?',
            text: "Video ini akan dihapus dari daftar putar!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'Ya, hapus!',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                form.submit();
            }
        });
    }
</script>
@endpush
