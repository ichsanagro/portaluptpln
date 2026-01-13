<div class="grid grid-cols-4 gap-1">
    <div class="bg-gradient-to-br from-blue-700 to-blue-800 text-white p-1 rounded-md shadow-sm flex flex-col justify-center text-center">
        <div class="text-xs font-semibold">Hari</div>
        <div id="realTimeClock" class="text-xs font-bold"></div>
    </div>
    <div class="bg-white p-1 rounded-md shadow-sm border border-gray-200 text-center">
        <div class="text-xs font-semibold text-gray-700">Hari Kerja</div>
        <div id="workingDaysThisYear" class="text-sm font-bold text-gray-800">{{ $workingDaysThisYear ?? 0 }}</div>
    </div>
    <div class="bg-white p-1 rounded-md shadow-sm border border-gray-200 text-center">
        <div class="text-xs font-semibold text-gray-700">Hari Aman</div>
        <div id="safeWorkingDays" class="text-sm font-bold text-green-600">{{ $safeWorkingDays ?? 0 }}</div>
    </div>
    <div class="bg-white p-1 rounded-md shadow-sm border border-gray-200 text-center">
        <div class="text-xs font-semibold text-gray-700">Kecelakaan</div>
        <div id="accidentCount" class="text-sm font-bold text-red-600">{{ $accidentCount ?? 0 }}</div>
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
                    const optionsDate = { day: '2-digit', month: '2-digit', year: 'numeric' }; // DD-MM-YYYY
                    const optionsTime = { hour: '2-digit', minute: '2-digit', second: '2-digit' }; // HH:MM:SS
                    
                    const dayString = now.toLocaleDateString('id-ID', optionsDay);
                    const dateString = now.toLocaleDateString('id-ID', optionsDate);
                    const timeString = now.toLocaleTimeString('id-ID', optionsTime);
                    
                    realTimeClock.innerHTML = `${dayString}, ${dateString}<br>${timeString}`; // Day, DD-MM-YYYY on top, HH:MM:SS below
                }
                setInterval(updateClock, 1000);
                updateClock();
            }
        });
    }
</script>
