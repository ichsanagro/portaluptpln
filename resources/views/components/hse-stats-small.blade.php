<div class="grid grid-cols-4 gap-2">
    <div class="bg-gradient-to-br from-[#28a8e0] to-blue-500 text-white p-1 rounded-lg shadow-md flex flex-col justify-center text-center">
        <div class="text-xs font-semibold">Hari & Waktu</div>
        <div id="realTimeClockSmall" class="text-xs font-bold mt-1 leading-tight"></div>
    </div>
    <div class="bg-white p-1 rounded-lg shadow-md text-center">
        <div class="text-xs font-semibold text-gray-600">Total Hari Kerja</div>
        <div id="workingDaysThisYearSmall" class="text-lg font-bold text-gray-800 mt-1 leading-tight">{{ $workingDaysThisYear ?? 0 }}</div>
    </div>
    <div class="bg-white p-1 rounded-lg shadow-md text-center">
        <div class="text-xs font-semibold text-gray-600">Hari Kerja Aman</div>
        <div id="safeWorkingDaysSmall" class="text-lg font-bold text-green-600 mt-1 leading-tight">{{ $safeWorkingDays ?? 0 }}</div>
    </div>
    <div class="bg-white p-1 rounded-lg shadow-md text-center border {{ ($accidentCount ?? 0) > 0 ? 'border-red-500' : 'border-gray-200' }}">
        <div class="text-xs font-semibold text-gray-600">Jumlah Kecelakaan</div>
        <div id="accidentCountSmall" class="text-lg font-bold text-red-600 mt-1 leading-tight">{{ $accidentCount ?? 0 }}</div>
    </div>
</div>

<script>
    // Ensure the script runs only once, even if included multiple times.
    if (typeof hseStatsSmallClockScriptLoaded === 'undefined') {
        const hseStatsSmallClockScriptLoaded = true;

        document.addEventListener('DOMContentLoaded', () => {
            const realTimeClockSmall = document.getElementById('realTimeClockSmall');
            
            if (realTimeClockSmall) {
                function updateClockSmall() {
                    const now = new Date();
                    const optionsDay = { weekday: 'long' };
                    const optionsDate = { day: '2-digit', month: 'short', year: 'numeric' };
                    
                    const dayString = now.toLocaleDateString('id-ID', optionsDay);
                    const dateString = now.toLocaleDateString('id-ID', optionsDate);
                    
                    realTimeClockSmall.innerHTML = `${dayString}, ${dateString}<br>${now.toLocaleTimeString('id-ID', {hour: '2-digit', minute: '2-digit'})}`;
                }
                setInterval(updateClockSmall, 1000);
                updateClockSmall();
            }
        });
    }
</script>
