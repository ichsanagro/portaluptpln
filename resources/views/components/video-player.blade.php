
@props(['type' => 'local', 'src' => ''])

@php
    $videoSrc = $src;
    $videoId = null;

    if ($type === 'url') {
        // Handle youtu.be short links
        if (str_contains($src, 'youtu.be/')) {
            $path = parse_url($src, PHP_URL_PATH);
            $videoId = ltrim($path, '/');
        } 
        // Handle standard youtube.com links
        elseif (str_contains($src, 'youtube.com/watch')) {
            parse_str(parse_url($src, PHP_URL_QUERY), $queryParams);
            if (isset($queryParams['v'])) {
                $videoId = $queryParams['v'];
            }
        }

        // If a YouTube video ID was found, build the embed URL
        if ($videoId) {
            // Extract the 'si' parameter if it exists and append it to the embed URL
            parse_str(parse_url($src, PHP_URL_QUERY), $queryParams);
            $si_param = isset($queryParams['si']) ? '&si=' . $queryParams['si'] : '';
            $videoSrc = 'https://www.youtube.com/embed/' . $videoId . '?autoplay=1&mute=1&loop=1&playlist=' . $videoId . $si_param;
        }
    } 
    // Handle local files
    elseif ($type === 'local') {
        $videoSrc = asset($src);
    }
@endphp

<div class="w-full h-full flex flex-col">
    <div class="w-full flex-grow bg-black rounded-lg shadow-md overflow-hidden">
        @if ($type === 'url' && str_contains($videoSrc, 'embed'))
            {{-- YouTube Iframe --}}
            <iframe
                class="w-full h-full"
                src="{{ $videoSrc }}"
                title="YouTube video player"
                frameborder="0"
                allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
                allowfullscreen>
            </iframe>
        @elseif ($type === 'url')
            {{-- Generic Video URL --}}
            <video
                class="w-full h-full object-cover"
                src="{{ $videoSrc }}"
                autoplay
                loop
                muted
                playsinline
                controls>
                Your browser does not support the video tag.
            </video>
        @elseif ($type === 'local' && $src)
            {{-- Local Video File --}}
            <video
                class="w-full h-full object-cover"
                src="{{ $videoSrc }}"
                autoplay
                loop
                muted
                playsinline
                controls>
                Your browser does not support the video tag.
            </video>
        @else
            <div class="w-full h-full flex items-center justify-center bg-gray-200">
                <p class="text-gray-500 text-sm p-4 text-center">Video tidak tersedia. Atur sumber video di `hse_dashboard.blade.php`.</p>
            </div>
        @endif
    </div>
</div>


