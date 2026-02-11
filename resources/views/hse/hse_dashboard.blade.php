<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>HSE Dashboard</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        html, body {
            overflow: hidden;
            height: 100%;
            background-color: #f3f4f6; /* bg-gray-100 */
        }

        @keyframes pulse-warning {
            0%, 100% {
                transform: scale(1);
                box-shadow: 0 0 0 0 rgba(251, 191, 36, 0.7);
            }
            50% {
                transform: scale(1.02);
                box-shadow: 0 0 5px 5px rgba(251, 191, 36, 0);
            }
        }

        .animate-pulse-warning {
            animation: pulse-warning 2s infinite;
        }

        /* Hide scrollbar for Chrome, Safari and Opera */
        .scrollbar-hide::-webkit-scrollbar {
            display: none;
        }

        /* Hide scrollbar for IE, Edge and Firefox */
        .scrollbar-hide {
            -ms-overflow-style: none;  /* IE and Edge */
            scrollbar-width: none;  /* Firefox */
        }
    </style>
</head>
<body class="font-sans antialiased">

    <div class="w-screen h-screen flex flex-col p-2 gap-2">
        
        <h1 class="text-2xl font-bold text-center text-[#28a8e0] flex-shrink-0">HSE Dashboard</h1>

        {{-- HSE Stats Component (static) --}}
        <div class="bg-white p-2 rounded-lg shadow-lg flex-shrink-0">
            @include('components.hse-stats')
        </div>

        {{-- Real-Time Monitoring (will be made horizontally scrollable internally) --}}
        <div class="bg-white p-2 rounded-lg shadow-lg flex-shrink-0">
            @include('components.real-time-monitoring', ['substations' => $substations])
        </div>

        {{-- Display Content Component --}}
        <div id="media-player-container" class="bg-white p-1 rounded-lg shadow-lg flex-grow min-h-0 flex items-center justify-center">
            {{-- Player will be dynamically inserted here. --}}
        </div>

    </div>

    <script>
    document.addEventListener('DOMContentLoaded', function () {
        const playerContainer = document.getElementById('media-player-container');
        let player = null;
        let imageTimeout = null;
        let currentMediaIndex = -1;

        // Unified playlist from the new playlist feature
        let playlist = {!! json_encode($playlistItems->map(function($item) {
            return [
                'src' => asset('storage/' . $item->path),
                'type' => $item->type,
                'duration' => $item->duration ?? 5, // Default 5s for images
            ];
        })->all()) !!};



        function playNext() {
            // If there's only one item and it's an image, don't loop, just hold.
             if (playlist.length === 1 && playlist[0].type === 'image') {
                playMedia(0); // Display the image and stop.
                return;
            }

            currentMediaIndex++;
            if (currentMediaIndex >= playlist.length) {
                currentMediaIndex = 0; // Loop playlist
            }
            playMedia(currentMediaIndex);
        }

        function playMedia(index) {
            if (index < 0 || index >= playlist.length) {
                playerContainer.innerHTML = '<div class="text-gray-500">Tidak ada media untuk ditampilkan.</div>';
                return;
            }

            clearTimeout(imageTimeout);
            currentMediaIndex = index;
            const media = playlist[index];
            playerContainer.innerHTML = '';

            if (media.type === 'video') {
                const video = document.createElement('video');
                video.src = media.src;
                video.autoplay = true;
                video.muted = true;
                video.className = 'w-full h-full object-contain rounded-lg';
                video.addEventListener('ended', playNext);
                video.addEventListener('error', function() {
                    console.error('Error playing video:', media.src);
                    // Optionally, skip to the next item on error
                    playNext();
                });
                playerContainer.appendChild(video);
                video.play().catch(e => {
                    console.error("Autoplay was prevented:", e);
                    // Autoplay policies may block this. The `muted` attribute helps, but isn't foolproof.
                });
            } else if (media.type === 'image') {
                const image = document.createElement('img');
                image.src = media.src;
                image.className = 'w-full h-full object-contain rounded-lg';
                playerContainer.appendChild(image);
                
                // If there's more than one item, transition after a delay.
                if (playlist.length > 1) {
                    const duration = (media.duration || 5) * 1000;
                    imageTimeout = setTimeout(playNext, duration);
                }
            }
        }

        // Start playback
        if (playlist.length > 0) {
            playMedia(0);
        } else {
            playerContainer.innerHTML = '<div class="text-gray-500">Tidak ada media yang dikonfigurasi.</div>';
        }
    });
    </script>
</body>
</html>