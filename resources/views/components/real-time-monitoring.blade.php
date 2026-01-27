<div>
    <h2 class="text-lg font-bold text-center mb-2 text-[#28a8e0]">Monitoring Cuaca Real-Time</h2>
    <div id="weather-scroll-container" class="overflow-x-auto scrollbar-hide pb-2">
        <div id="weather-widgets-container" class="flex gap-4">
            {{-- Weather widgets will be loaded here by JavaScript --}}
        </div>
    </div>
</div>

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

        return `
            <div class="bg-white p-4 rounded-lg shadow-md flex flex-col justify-between border border-gray-200" style="min-width: 250px;">
                <div>
                    <h3 class="text-lg font-bold text-gray-800">${station.name}</h3>
                    <div class="flex items-center justify-center mt-4">
                        <div class="text-5xl font-bold text-gray-800">
                            ${temperature}&deg;
                        </div>
                        <div class="ml-4">
                            <div class="text-2xl text-gray-600">
                                ${weatherIcon}
                            </div>
                        </div>
                    </div>
                    <div class="text-center text-gray-600 mt-2">
                        <p>Angin: ${windSpeed} km/h</p>
                        <p>Kelembapan: ${humidity}%</p>
                    </div>
                </div>
            </div>
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

