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
        <div class="bg-white p-1 rounded-lg shadow-lg flex-grow min-h-0 flex items-center justify-center">
            @if(isset($videos) && $videos->count() > 0)
                <video id="playlist-player" class="w-full h-full object-contain rounded-lg" controls autoplay muted>
                    <source src="" type="video/mp4">
                    Browser Anda tidak mendukung tag video.
                </video>
            @elseif(($displayMode ?? 'video') === 'image' && $imageUrl)
                <img src="{{ $imageUrl }}" alt="Dashboard Display Image" class="w-full h-full object-contain rounded-lg">
            @else
                <x-video-player type="url" src="{{ $videoUrl ?? 'https://youtu.be/HNLm9a5brfQ?si=aozePA9WCMtFF-TV' }}" />
            @endif
        </div>

    </div>

    @if(isset($videos) && $videos->count() > 0)
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const player = document.getElementById('playlist-player');
            const playlist = @json($videos->map(function($video) {
                return asset('storage/' . $video->path);
            }));
            let currentVideoIndex = 0;

            function playVideo(index) {
                if (index >= 0 && index < playlist.length) {
                    player.src = playlist[index];
                    player.load();
                    player.play().catch(e => console.error("Autoplay was prevented:", e));
                    currentVideoIndex = index;
                }
            }

            player.addEventListener('ended', function () {
                currentVideoIndex++;
                if (currentVideoIndex >= playlist.length) {
                    currentVideoIndex = 0; // Loop playlist
                }
                playVideo(currentVideoIndex);
            });

            // Start playback
            if (playlist.length > 0) {
                playVideo(0);
            }
        });
    </script>
    @endif
</body>
</html>