<div class="grid grid-cols-4 gap-1">
    <div class="bg-gradient-to-br from-blue-700 to-blue-800 text-white p-1 rounded-md shadow-sm flex flex-col justify-center text-center">
        <div class="text-xs font-semibold">Waktu</div>
        <div id="realTimeClock" class="text-xs font-bold"></div>
    </div>
    <div class="bg-white p-1 rounded-md shadow-sm border border-gray-200 text-center">
        <div class="text-xs font-semibold text-gray-700">Hari Kerja</div>
        <div id="workingDaysThisYear" class="text-sm font-bold text-gray-800">0</div>
    </div>
    <div class="bg-white p-1 rounded-md shadow-sm border border-gray-200 text-center">
        <div class="text-xs font-semibold text-gray-700">Hari Aman</div>
        <div id="safeWorkingDays" class="text-sm font-bold text-green-600">0</div>
    </div>
    <div class="bg-white p-1 rounded-md shadow-sm border border-gray-200 text-center">
        <div class="text-xs font-semibold text-gray-700">Kecelakaan</div>
        <div id="accidentCount" class="text-sm font-bold text-red-600">0</div>
    </div>
</div>

<script>
    // Ensure the script runs only once, even if included multiple times.
    if (typeof hseStatsScriptLoaded === 'undefined') {
        const hseStatsScriptLoaded = true;

        document.addEventListener('DOMContentLoaded', () => {
            const realTimeClock = document.getElementById('realTimeClock');
            const workingDaysThisYear = document.getElementById('workingDaysThisYear');
            const safeWorkingDaysElement = document.getElementById('safeWorkingDays');
            const accidentCountElement = document.getElementById('accidentCount');

            if (!realTimeClock || !workingDaysThisYear || !safeWorkingDaysElement || !accidentCountElement) {
                return;
            }

            function isWorkingDay(date) {
                const dayOfWeek = date.getDay();
                return dayOfWeek !== 0 && dayOfWeek !== 6;
            }

            function calculateWorkingDaysThisYear() {
                const today = new Date();
                today.setHours(0, 0, 0, 0);

                const startDateString = localStorage.getItem('hseStartDate');
                let startDate;

                if (startDateString) {
                    const parts = startDateString.split('-').map(Number);
                    startDate = new Date(parts[0], parts[1] - 1, parts[2]);
                } else {
                    startDate = new Date(today.getFullYear(), 0, 1);
                }
                
                startDate.setHours(0, 0, 0, 0);

                let workingDays = 0;
                if (today < startDate) {
                    workingDaysThisYear.textContent = 0;
                    return;
                }

                let currentDate = new Date(startDate);
                while (currentDate <= today) {
                    if (isWorkingDay(currentDate)) {
                        workingDays++;
                    }
                    currentDate.setDate(currentDate.getDate() + 1);
                }
                workingDaysThisYear.textContent = workingDays;
            }

            function updateClock() {
                const now = new Date();
                const optionsDate = { day: '2-digit', month: '2-digit' };
                const optionsTime = { hour: '2-digit', minute: '2-digit' };
                const dateString = now.toLocaleDateString('id-ID', optionsDate);
                const timeString = now.toLocaleTimeString('id-ID', optionsTime);
                realTimeClock.textContent = `${dateString} ${timeString}`;
            }

            function loadData() {
                let safeWorkingDays = parseInt(localStorage.getItem('safeWorkingDays')) || 0;
                let lastUpdateDateStr = localStorage.getItem('lastSafeWorkingDayUpdate');
                const today = new Date();
                today.setHours(0, 0, 0, 0);

                if (lastUpdateDateStr) {
                    const lastUpdateDate = new Date(lastUpdateDateStr);
                    lastUpdateDate.setHours(0, 0, 0, 0);

                    if (today.getTime() > lastUpdateDate.getTime()) {
                        let tempDate = new Date(lastUpdateDate);
                        tempDate.setDate(tempDate.getDate() + 1);

                        while (tempDate.getTime() <= today.getTime()) {
                            if (isWorkingDay(tempDate)) {
                                safeWorkingDays++;
                            }
                            tempDate.setDate(tempDate.getDate() + 1);
                        }
                    }
                } else {
                    localStorage.setItem('lastSafeWorkingDayUpdate', today.toISOString());
                }

                safeWorkingDaysElement.textContent = safeWorkingDays;
                accidentCountElement.textContent = localStorage.getItem('accidentCount') || 0;

                localStorage.setItem('safeWorkingDays', safeWorkingDays);
                localStorage.setItem('lastSafeWorkingDayUpdate', today.toISOString());
            }

            setInterval(updateClock, 1000);
            updateClock();
            calculateWorkingDaysThisYear();
            loadData();
        });
    }
</script>
