<div>
    <h2 class="text-lg font-bold text-center mb-2 text-[#28a8e0]">Monitoring Cuaca Real-Time</h2>
    <div id="weather-scroll-container" class="overflow-x-auto pb-2">
        <div id="weather-widgets-container" class="flex gap-4">
            {{-- Weather widgets will be loaded here by JavaScript --}}
        </div>
    </div>
</div>

<style>
    #weather-scroll-container::-webkit-scrollbar {
        height: 8px;
        /* Initially hidden */
        opacity: 0;
        transition: opacity 0.3s ease-in-out;
    }
    #weather-scroll-container:hover::-webkit-scrollbar {
        /* Visible on hover */
        opacity: 1;
    }
    #weather-scroll-container::-webkit-scrollbar-track {
        background: #f1f1f1;
        border-radius: 10px;
        /* Initially hidden */
        opacity: 0;
        transition: opacity 0.3s ease-in-out;
    }
    #weather-scroll-container:hover::-webkit-scrollbar-track {
        /* Visible on hover */
        opacity: 1;
    }
    #weather-scroll-container::-webkit-scrollbar-thumb {
        background: #888;
        border-radius: 10px;
        /* Initially hidden */
        opacity: 0;
        transition: opacity 0.3s ease-in-out;
    }
    #weather-scroll-container:hover::-webkit-scrollbar-thumb {
        /* Visible on hover */
        background: #555; /* Darker on hover */
        opacity: 1;
    }
    
    /* For Firefox */
    #weather-scroll-container {
        scrollbar-width: thin;
        scrollbar-color: transparent transparent; /* Initially hidden */
        transition: scrollbar-color 0.3s ease-in-out;
    }
    #weather-scroll-container:hover {
        scrollbar-color: #888 #f1f1f1; /* Visible on hover */
    }
</style>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const substations = @json($substations);
    const container = document.getElementById('weather-widgets-container');
    
    if (!container) {
        console.error('Weather widget container not found!');
        return;
    }

    const weatherPromises = substations.map(station => {
        const apiUrl = `https://api.open-meteo.com/v1/forecast?latitude=${station.latitude}&longitude=${station.longitude}&current=temperature_2m,relative_humidity_2m,weather_code,wind_speed_10m`;
        console.log(`Requesting weather data from: ${apiUrl}`); // Log the URL
        return fetch(apiUrl)
            .then(response => {
                console.log(`Response received for ${station.name}:`, response); // Log the raw response
                if (!response.ok) {
                    throw new Error(`HTTP error! status: ${response.status}`);
                }
                return response.json();
            })
            .then(data => {
                console.log(`Data parsed for ${station.name}:`, data); // Log the parsed data
                return { station, weather: data.current };
            })
            .catch(error => {
                console.error(`Failed to fetch weather for ${station.name}:`, error);
                return { station, weather: null }; // Return null on error
            });
    });

    Promise.all(weatherPromises)
        .then(results => {
            container.innerHTML = ''; // Clear previous content
            results.forEach(({ station, weather }) => {
                const widgetHtml = weather
                    ? createWeatherWidget(station, weather)
                    : createErrorWidget(station);
                container.innerHTML += widgetHtml;
            });

            // Start auto-scrolling after widgets are rendered
            const scrollContainer = document.getElementById('weather-scroll-container');
            if (scrollContainer && scrollContainer.scrollWidth > scrollContainer.clientWidth) {
                let scrolling = true;

                function autoScroll() {
                    if (scrolling) {
                        scrollContainer.scrollLeft += 1;
                        if (scrollContainer.scrollLeft >= (scrollContainer.scrollWidth - scrollContainer.clientWidth)) {
                            scrollContainer.scrollLeft = 0;
                        }
                    }
                    requestAnimationFrame(autoScroll);
                }
                
                scrollContainer.addEventListener('mouseenter', () => scrolling = false);
                scrollContainer.addEventListener('mouseleave', () => scrolling = true);

                requestAnimationFrame(autoScroll);
            }
        });

    function createWeatherWidget(station, weather) {
        const weatherIcon = getWeatherIcon(weather.weather_code);
        const temperature = Math.round(weather.temperature_2m);
        const windSpeed = weather.wind_speed_10m;
        const humidity = weather.relative_humidity_2m;
        const url = `/hse/monitoring-iot/${station.id}`;

        return `
            <a href="${url}" class="block bg-white p-2 rounded-lg shadow-md flex flex-col border border-gray-200 hover:shadow-xl hover:border-blue-500 transition" style="min-width: 180px;">
                <h3 class="text-md font-bold text-gray-800 text-center flex items-center justify-center h-10">${station.name}</h3>
                
                {{-- Temperature and Icon --}}
                <div class="flex items-center justify-center my-2">
                    <div class="text-3xl font-bold text-gray-800 leading-none">
                        ${temperature}&deg;
                    </div>
                    <div class="ml-1 text-2xl text-gray-600 leading-none">
                        ${weatherIcon}
                    </div>
                </div>

                {{-- Wind and Humidity Details --}}
                <div class="mt-auto text-xs text-gray-700">
                    <div class="flex justify-between items-center py-1 border-t border-gray-200">
                        <span>Angin:</span>
                        <span class="font-semibold">${windSpeed} km/h</span>
                    </div>
                    <div class="flex justify-between items-center py-1 border-t border-gray-200">
                        <span>Kelembapan:</span>
                        <span class="font-semibold">${humidity}%</span>
                    </div>
                </div>
            </a>
        `;
    }

    function createErrorWidget(station) {
        return `
            <div class="bg-red-100 p-4 rounded-lg shadow-md flex flex-col justify-center items-center border border-red-200">
                <h3 class="text-lg font-bold text-red-800">${station.name}</h3>
                <p class="text-red-600 mt-2">Data cuaca tidak dapat dimuat.</p>
            </div>
        `;
    }

    function getWeatherIcon(weatherCode) {
        const code = Number(weatherCode);
        if (code === 0) return '☀️'; // Cerah
        if (code === 1) return '🌤️'; // Sebagian besar cerah
        if (code === 2) return '⛅'; // Berawan sebagian
        if (code === 3) return '☁️'; // Berawan
        if (code === 45 || code === 48) return '🌫️'; // Kabut
        if (code >= 51 && code <= 57) return '💧'; // Gerimis
        if (code >= 61 && code <= 67) return '🌧️'; // Hujan
        if (code >= 71 && code <= 77) return '❄️'; // Salju
        if (code >= 80 && code <= 82) return '🌦️'; // Hujan ringan
        if (code >= 85 && code <= 86) return '🌨️'; // Hujan salju
        if (code >= 95 && code <= 99) return '⛈️'; // Badai petir
        return '❓'; // Tidak diketahui
    }
});
</script>
