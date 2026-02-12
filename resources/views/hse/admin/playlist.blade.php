@extends('layouts.app')

@section('title', 'Kelola Playlist Media')

@section('content')
<div class="max-w-7xl mx-auto sm:px-6 lg:px-8 py-8">
    <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
        <div class="p-6 sm:p-8 bg-white border-b border-gray-200">
            <h1 class="text-2xl font-bold text-gray-800 mb-6">Kelola Playlist Media</h1>

            <!-- Media Player -->
            <div id="media-player-container" class="mb-6 bg-black rounded-lg shadow-lg overflow-hidden flex items-center justify-center min-h-[480px]">
                {{-- Player will be dynamically inserted here --}}
            </div>

            <!-- Upload Form -->
            <div class="mb-6">
                <form action="{{ route('hse.admin_playlist.store') }}" method="POST" enctype="multipart/form-data" class="bg-gray-50 p-6 rounded-lg shadow">
                    @csrf
                    <h2 class="text-xl font-semibold text-gray-700 mb-4">Upload Media Baru (Gambar/Video)</h2>
                    <div class="flex items-center space-x-4">
                        <input type="file" name="files[]" multiple accept="video/mp4,video/avi,video/mpeg,image/*" class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100">
                        <button type="submit" class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700">Upload</button>
                    </div>
                    @error('files.*')
                        <p class="text-red-500 text-xs mt-2">{{ $message }}</p>
                    @enderror
                </form>
            </div>

            <!-- Playlist -->
            <div>
                <h2 class="text-xl font-semibold text-gray-700 mb-4">Daftar Putar</h2>
                <div id="playlist-items" class="space-y-3">
                    @forelse ($files as $file)
                        <div data-id="{{ $file->id }}" class="flex items-center justify-between bg-white p-4 rounded-lg shadow cursor-move">
                            <div class="flex items-center flex-grow">
                                <svg class="w-6 h-6 text-gray-400 mr-4 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path></svg>
                                @if($file->type === 'image')
                                    <img src="{{ asset('storage/' . $file->path) }}" class="w-16 h-10 object-cover rounded-md mr-4" alt="thumbnail">
                                @else
                                    {{-- Placeholder for video thumbnail --}}
                                    <div class="w-16 h-10 bg-gray-200 flex items-center justify-center rounded-md mr-4">
                                        <svg class="w-6 h-6 text-gray-500" fill="currentColor" viewBox="0 0 20 20"><path d="M2.667 3h14.666c.92 0 1.667.746 1.667 1.667v10.666c0 .92-.747 1.667-1.667 1.667H2.667A1.667 1.667 0 011 15.333V4.667C1 3.747 1.746 3 2.667 3zM3 5v10h14V5H3zm6 7l4-2.5L9 7v5z"></path></svg>
                                    </div>
                                @endif
                                <span class="font-medium text-gray-800 truncate">{{ $file->original_name }}</span>
                            </div>
                            <div class="flex items-center space-x-3 flex-shrink-0 ml-4">
                                <button class="play-button text-blue-500 hover:text-blue-700"
                                        data-src="{{ asset('storage/' . $file->path) }}"
                                        data-type="{{ $file->type }}">
                                    <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM9.555 7.168A1 1 0 008 8v4a1 1 0 001.555.832l3-2a1 1 0 000-1.664l-3-2z" clip-rule="evenodd"></path></svg>
                                </button>
                                <form action="{{ route('hse.admin_playlist.destroy', $file->id) }}" method="POST">
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
                            Tidak ada media dalam daftar putar.
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
        const playerContainer = document.getElementById('media-player-container');
        const playlistItemsContainer = document.getElementById('playlist-items');
        let player = null; // Can be <video> or <img>
        let imageTimeout = null; // To handle image display duration

        let playlist = @json($files->map(function($file) {
            return [
                'src' => asset('storage/' . $file->path),
                'type' => $file->type,
                'duration' => $file->duration ?? 5 // Default 5s for images
            ];
        }));
        let currentMediaIndex = -1;

        function playNext() {
            currentMediaIndex++;
            if (currentMediaIndex >= playlist.length) {
                currentMediaIndex = 0; // Loop playlist
            }
            playMedia(currentMediaIndex);
        }

        function playMedia(index) {
            if (index < 0 || index >= playlist.length) {
                playerContainer.innerHTML = '<div class="text-white">Playlist Kosong</div>';
                return;
            };

            clearTimeout(imageTimeout); // Clear any existing image timer
            currentMediaIndex = index;
            const media = playlist[index];

            playerContainer.innerHTML = ''; // Clear previous media

            if (media.type === 'video') {
                const video = document.createElement('video');
                video.src = media.src;
                video.controls = true;
                video.autoplay = true;
                video.muted = true; // Important for autoplay in many browsers
                video.className = 'w-full h-auto max-h-[480px]';
                video.addEventListener('ended', playNext);
                player = video;
                playerContainer.appendChild(player);
                player.play().catch(e => console.error("Autoplay was prevented:", e));
            } else if (media.type === 'image') {
                const image = document.createElement('img');
                image.src = media.src;
                image.className = 'w-full h-auto max-h-[480px] object-contain';
                player = image;
                playerContainer.appendChild(player);
                
                // Go to next item after a delay (e.g., 5 seconds)
                const duration = (media.duration || 5) * 1000;
                imageTimeout = setTimeout(playNext, duration);
            }
        }

        // Play button listeners
        document.querySelectorAll('.play-button').forEach(button => {
            button.addEventListener('click', function () {
                const src = this.dataset.src;
                const type = this.dataset.type;
                const index = playlist.findIndex(item => item.src === src && item.type === type);
                if (index !== -1) {
                    playMedia(index);
                }
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
                        // Re-create the playlist array based on the new DOM order
                        const newPlaylist = [];
                        document.querySelectorAll('#playlist-items .play-button').forEach(button => {
                            newPlaylist.push({
                                src: button.dataset.src,
                                type: button.dataset.type,
                                duration: 5 // Default duration, needs to be stored if you want it configurable
                            });
                        });
                        playlist = newPlaylist;
                        console.log('Playlist order updated');
                    }
                });
            }
        });

        // Play the first media item on page load if playlist is not empty
        if (playlist.length > 0) {
            playMedia(0);
        } else {
             playerContainer.innerHTML = '<div class="text-white">Tidak ada media di playlist</div>';
        }
    });

    function confirmDelete(button) {
        const form = button.closest('form');
        Swal.fire({
            title: 'Anda Yakin?',
            text: "File ini akan dihapus dari daftar putar!",
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
