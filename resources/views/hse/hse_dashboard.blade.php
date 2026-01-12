<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>HSE Dashboard</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-100 text-gray-900 min-h-screen flex flex-col font-sans antialiased">
    <div class="flex-grow p-4 sm:p-6 lg:p-8">
        <div class="max-w-7xl mx-auto bg-white rounded-lg shadow-xl p-6 sm:p-8 lg:p-10">
            <h1 class="text-3xl sm:text-4xl font-extrabold mb-8 text-center text-blue-800">HSE Dashboard</h1>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-10">
                <div class="bg-gradient-to-br from-blue-700 to-blue-800 text-white p-6 rounded-lg shadow-md flex flex-col justify-between">
                    <div class="text-lg font-semibold mb-2">Tanggal & Waktu</div>
                    <div id="realTimeClock" class="text-3xl font-bold"></div>
                </div>
                <div class="bg-white p-6 rounded-lg shadow-md border border-gray-200">
                    <div class="text-lg font-semibold text-gray-700 mb-2">Hari Kerja Tahun Ini</div>
                    <div id="workingDaysThisYear" class="text-4xl font-bold text-gray-800">0</div>
                </div>
                <div class="bg-white p-6 rounded-lg shadow-md border border-gray-200">
                    <div class="text-lg font-semibold text-gray-700 mb-2">Hari Kerja Aman</div>
                    <div id="safeWorkingDays" class="text-4xl font-bold text-green-600">0</div>
                </div>
                <div class="bg-white p-6 rounded-lg shadow-md border border-gray-200">
                    <div class="text-lg font-semibold text-gray-700 mb-2">Jumlah Kecelakaan</div>
                    <div id="accidentCount" class="text-4xl font-bold text-red-600">0</div>
                </div>
            </div>

            {{-- Admin Panel is removed from user view --}}

        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const realTimeClock = document.getElementById('realTimeClock');
            const workingDaysThisYear = document.getElementById('workingDaysThisYear');
            const safeWorkingDaysElement = document.getElementById('safeWorkingDays');
            const accidentCountElement = document.getElementById('accidentCount');

            // --- Utility Functions ---

            // Check if a date is a working day (Monday-Friday)
            function isWorkingDay(date) {
                const dayOfWeek = date.getDay();
                return dayOfWeek !== 0 && dayOfWeek !== 6; // 0 = Sunday, 6 = Saturday
            }

            function calculateWorkingDaysThisYear() {
                const today = new Date();
                today.setHours(0, 0, 0, 0);

                const startDateString = localStorage.getItem('hseStartDate');
                let startDate;

                if (startDateString) {
                    // new Date('YYYY-MM-DD') can be off by a day due to timezone, so parse manually
                    const parts = startDateString.split('-').map(Number);
                    startDate = new Date(parts[0], parts[1] - 1, parts[2]);
                } else {
                    startDate = new Date(today.getFullYear(), 0, 1); // Default to Jan 1st of current year
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
                const optionsDate = { year: 'numeric', month: 'long', day: 'numeric' };
                const optionsTime = { hour: '2-digit', minute: '2-digit', second: '2-digit' };
                const dateString = now.toLocaleDateString('id-ID', optionsDate);
                const timeString = now.toLocaleTimeString('id-ID', optionsTime);
                realTimeClock.innerHTML = `${dateString}<br><span class="text-2xl font-bold">${timeString}</span>`;
            }

            function loadData() {
                let safeWorkingDays = parseInt(localStorage.getItem('safeWorkingDays')) || 0;
                let lastUpdateDateStr = localStorage.getItem('lastSafeWorkingDayUpdate');
                const today = new Date();
                today.setHours(0, 0, 0, 0); // Normalize today's date to start of day

                if (lastUpdateDateStr) {
                    const lastUpdateDate = new Date(lastUpdateDateStr);
                    lastUpdateDate.setHours(0, 0, 0, 0); // Normalize last update date to start of day

                    // If it's a new day and a working day since the last update
                    if (today.getTime() > lastUpdateDate.getTime()) {
                        let tempDate = new Date(lastUpdateDate);
                        tempDate.setDate(tempDate.getDate() + 1); // Start checking from the day after last update

                        while (tempDate.getTime() <= today.getTime()) {
                            if (isWorkingDay(tempDate)) {
                                safeWorkingDays++;
                            }
                            tempDate.setDate(tempDate.getDate() + 1);
                        }
                    }
                } else {
                    // First load, set current date as last update
                    localStorage.setItem('lastSafeWorkingDayUpdate', today.toISOString());
                }

                safeWorkingDaysElement.textContent = safeWorkingDays;
                accidentCountElement.textContent = localStorage.getItem('accidentCount') || 0;

                localStorage.setItem('safeWorkingDays', safeWorkingDays); // Save potentially incremented value
                localStorage.setItem('lastSafeWorkingDayUpdate', today.toISOString()); // Update last update date
            }

            // --- Event Listeners and Initial Load ---

            // Clock update every second
            setInterval(updateClock, 1000);
            updateClock(); // Initial call to display immediately

            // Calculate working days this year using potentially custom start date
            calculateWorkingDaysThisYear();

            // Load saved data and handle auto-increment
            loadData();
        });
    </script>
</body>
</html>