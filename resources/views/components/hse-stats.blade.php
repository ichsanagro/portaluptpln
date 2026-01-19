<div class="grid grid-cols-4 gap-2">
    <div class="bg-gradient-to-br from-[#28a8e0] to-blue-500 text-white p-1 rounded-lg shadow-md flex flex-col justify-center text-center">
        <div class="font-semibold">Hari & Waktu</div>
        <div id="realTimeClock" class="text-sm font-bold mt-1"></div>
    </div>
    <div class="bg-white p-1 rounded-lg shadow-md text-center">
        <div class="font-semibold text-gray-600">Total Hari Kerja</div>
        <div id="workingDaysThisYear" class="text-xl font-bold text-gray-800 mt-1">{{ $workingDaysThisYear ?? 0 }}</div>
    </div>
    <div class="bg-white p-1 rounded-lg shadow-md text-center">
        <div class="font-semibold text-gray-600">Hari Kerja Aman</div>
        <div id="safeWorkingDays" class="text-xl font-bold text-green-600 mt-1">{{ $safeWorkingDays ?? 0 }}</div>
    </div>
    <div class="bg-white p-1 rounded-lg shadow-md text-center border {{ ($accidentCount ?? 0) > 0 ? 'border-red-500' : 'border-gray-200' }}">
        <div class="font-semibold text-gray-600">Jumlah Kecelakaan</div>
        <div id="accidentCount" class="text-xl font-bold text-red-600 mt-1">{{ $accidentCount ?? 0 }}</div>
    </div>
</div>

<script>
    // Ensure the script runs only once, even if included multiple times.
    if (typeof hseStatsClockScriptLoaded === 'undefined') {
        const hseStatsClockScriptLoaded = true;

        document.addEventListener('DOMContentLoaded', () => {
            const realTimeClock = document.getElementById('realTimeClock');
            
            if (realTimeClock) {
                function updateClock() {
                    const now = new Date();
                    const optionsDay = { weekday: 'long' }; // e.g., "Senin"
                    const optionsDate = { day: '2-digit', month: 'short', year: 'numeric' }; // DD-MM-YYYY
                    const optionsTime = { hour: '2-digit', minute: '2-digit', second: '2-digit' }; // HH:MM:SS
                    
                    const dayString = now.toLocaleDateString('id-ID', optionsDay);
                    const dateString = now.toLocaleDateString('id-ID', optionsDate);
                    const timeString = now.toLocaleTimeString('id-ID', { hour: '2-digit', minute: '2-digit' });
                    
                    realTimeClock.innerHTML = `${dayString}, ${dateString}<br>${now.toLocaleTimeString('id-ID', {hour: '2-digit', minute: '2-digit', second: '2-digit'})}`;
                }
                setInterval(updateClock, 1000);
                updateClock();
            }
        });
    }
</script>
