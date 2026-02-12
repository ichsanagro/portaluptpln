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

    <script src="https://www.youtube.com/iframe_api"></script>
    <script>
    document.addEventListener('DOMContentLoaded', function () {
        const playerContainer = document.getElementById('media-player-container');
        let localPlayer = null; // HTML5 <video> or <img>
        let ytPlayer = null; // YouTube Player object
        let imageTimeout = null;
        let currentMediaIndex = 0;

        const playlist = {!! json_encode($playlistItems->map(function($item) {
            $src = $item->type === 'youtube' ? $item->path : asset('storage/' . $item->path);
            return [
                'src' => $src,
                'type' => $item->type,
                'duration' => $item->duration, 
            ];
        })->all()) !!};

        // This function will be called automatically by the YouTube API script
        window.onYouTubeIframeAPIReady = function() {
            // Start playback if the first item is a YouTube video
            if (playlist.length > 0 && playlist[0].type === 'youtube') {
                playMedia(0);
            }
        };

        function destroyPlayers() {
            // Destroy YouTube player if it exists
            if (ytPlayer && typeof ytPlayer.destroy === 'function') {
                ytPlayer.destroy();
            }
            ytPlayer = null;
            
            // Clear local player
            clearTimeout(imageTimeout);
            playerContainer.innerHTML = '';
            localPlayer = null;
        }

        function playNext() {
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

            destroyPlayers();
            currentMediaIndex = index;
            const media = playlist[index];

            if (media.type === 'video') {
                const video = document.createElement('video');
                video.src = media.src;
                video.autoplay = true;
                video.muted = true;
                video.className = 'w-full h-full object-contain rounded-lg';
                video.addEventListener('ended', playNext);
                video.addEventListener('error', () => { console.error('Error playing video:', media.src); playNext(); });
                localPlayer = video;
                playerContainer.appendChild(localPlayer);
                localPlayer.play().catch(e => console.error("Autoplay was prevented:", e));

            } else if (media.type === 'image') {
                const image = document.createElement('img');
                image.src = media.src;
                image.className = 'w-full h-full object-contain rounded-lg';
                localPlayer = image;
                playerContainer.appendChild(localPlayer);
                
                if (playlist.length > 1) {
                    const duration = (media.duration || 5) * 1000; // Default 5s for images
                    imageTimeout = setTimeout(playNext, duration);
                }
            } else if (media.type === 'youtube') {
                // The container div for the YouTube player
                const ytContainer = document.createElement('div');
                ytContainer.id = 'youtube-player-div';
                playerContainer.appendChild(ytContainer);

                ytPlayer = new YT.Player('youtube-player-div', {
                    height: '100%',
                    width: '100%',
                    videoId: media.src,
                    playerVars: {
                        'autoplay': 1,
                        'mute': 1,
                        'controls': 1,
                        'showinfo': 0,
                        'rel': 0,
                        'iv_load_policy': 3,
                        'modestbranding': 1,
                        'loop': 0, // Loop is handled by our playlist logic
                    },
                    events: {
                        'onReady': (event) => event.target.playVideo(),
                        'onStateChange': (event) => {
                            // If video has ended
                            if (event.data === YT.PlayerState.ENDED) {
                                playNext();
                            }
                        }
                    }
                });
            }
        }

        // Initial playback trigger
        if (playlist.length > 0) {
            // If the first item is not a YouTube video, play it directly.
            // If it IS a youtube video, onYouTubeIframeAPIReady will handle it.
            if (playlist[0].type !== 'youtube') {
                playMedia(0);
            }
        } else {
            playerContainer.innerHTML = '<div class="text-gray-500">Tidak ada media yang dikonfigurasi.</div>';
        }
    });
    </script>
</body>
</html>