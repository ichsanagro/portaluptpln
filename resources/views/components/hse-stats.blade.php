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
    <div id="accidentCard" class="bg-white p-1 rounded-lg shadow-md text-center border {{ ($accidentCount ?? 0) > 0 ? 'border-red-500 cursor-pointer hover:bg-red-50' : 'border-gray-200' }}">
        <div class="font-semibold text-gray-600">Jumlah Kecelakaan</div>
        <div id="accidentCount" class="text-xl font-bold text-red-600 mt-1">{{ $accidentCount ?? 0 }}</div>
    </div>
</div>

@if (($accidentCount ?? 0) > 0 && isset($accidentLogs))
<!-- Accident History Modal -->
<div id="accidentModal" class="fixed inset-0 bg-black/50 backdrop-blur-sm z-50 hidden flex justify-center items-center">
    <div class="bg-white rounded-lg shadow-xl w-3/4 md:w-1/3 lg:w-1/4 flex flex-col" style="max-height: 80vh;">
        <div class="flex justify-between items-center border-b p-4">
            <h3 class="text-2xl font-bold text-red-700">Riwayat Kecelakaan</h3>
            <button id="closeModal" class="text-gray-500 hover:text-gray-800 text-3xl font-bold">&times;</button>
        </div>
        <div class="p-6 space-y-4 overflow-y-auto">
            @forelse ($accidentLogs as $log)
                <div class="border-b pb-3 mb-3">
                    <p class="font-semibold text-gray-600">Tanggal Kejadian:</p>
                    <p class="text-lg text-gray-800">{{ \Carbon\Carbon::parse($log->accident_date)->format('d M Y') }}</p>
                    <p class="font-semibold text-gray-600 mt-2">Keterangan:</p>
                    <p class="text-base text-gray-700 bg-gray-50 p-3 rounded-md whitespace-pre-wrap">{{ $log->description }}</p>
                </div>
            @empty
                <p class="text-gray-500">Tidak ada riwayat kecelakaan untuk ditampilkan.</p>
            @endforelse
        </div>
    </div>
</div>
@endif


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

            @if (($accidentCount ?? 0) > 0)
            const accidentCard = document.getElementById('accidentCard');
            const accidentModal = document.getElementById('accidentModal');
            const closeModal = document.getElementById('closeModal');

            if (accidentCard && accidentModal && closeModal) {
                accidentCard.addEventListener('click', () => {
                    accidentModal.classList.remove('hidden');
                });

                closeModal.addEventListener('click', () => {
                    accidentModal.classList.add('hidden');
                });

                // Close modal if clicking outside of it
                window.addEventListener('click', (event) => {
                    if (event.target === accidentModal) {
                        accidentModal.classList.add('hidden');
                    }
                });
            }
            @endif
        });
    }
</script>
