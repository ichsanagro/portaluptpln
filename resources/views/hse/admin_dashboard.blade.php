<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>HSE Admin Dashboard</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-100 text-gray-900 min-h-screen flex flex-col font-sans antialiased">
    <div class="flex-grow p-4 sm:p-6 lg:p-8">
        <div class="max-w-7xl mx-auto bg-white rounded-lg shadow-xl p-6 sm:p-8 lg:p-10">
            <h1 class="text-3xl sm:text-4xl font-extrabold mb-8 text-center text-blue-800">HSE Admin Dashboard</h1>

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

            <div class="bg-gray-50 p-6 sm:p-8 rounded-lg shadow-lg border border-gray-200">
                <h2 class="text-2xl font-bold mb-6 text-blue-800 border-b pb-3">Admin Panel</h2>
                <div class="space-y-6">
                    <!-- Safe Working Days Management -->
                    <div class="flex flex-col sm:flex-row items-center justify-between bg-white p-4 rounded-md shadow-sm border border-gray-100">
                        <label for="safeWorkingDaysInput" class="text-lg font-medium text-gray-700 mb-2 sm:mb-0 sm:mr-4 w-full sm:w-auto">Hari Kerja Aman:</label>
                        <div class="flex items-center space-x-2 w-full sm:w-auto">
                            <button id="safeWorkingDaysSubtract" class="bg-blue-100 hover:bg-blue-200 text-blue-800 font-bold py-2 px-4 rounded-md transition duration-150 ease-in-out text-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-opacity-50">-</button>
                            <input type="number" id="safeWorkingDaysInput" class="form-input w-24 text-center border-gray-300 rounded-md shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50" value="0">
                            <button id="safeWorkingDaysAdd" class="bg-blue-100 hover:bg-blue-200 text-blue-800 font-bold py-2 px-4 rounded-md transition duration-150 ease-in-out text-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-opacity-50">+</button>
                        </div>
                    </div>

                    <!-- Accident Count Management -->
                    <div class="flex flex-col sm:flex-row items-center justify-between bg-white p-4 rounded-md shadow-sm border border-gray-100">
                        <label for="accidentCountInput" class="text-lg font-medium text-gray-700 mb-2 sm:mb-0 sm:mr-4 w-full sm:w-auto">Jumlah Kecelakaan:</label>
                        <div class="flex items-center space-x-2 w-full sm:w-auto">
                            <button id="accidentCountSubtract" class="bg-red-100 hover:bg-red-200 text-red-800 font-bold py-2 px-4 rounded-md transition duration-150 ease-in-out text-lg focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-opacity-50">-</button>
                            <input type="number" id="accidentCountInput" class="form-input w-24 text-center border-gray-300 rounded-md shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50" value="0">
                            <button id="accidentCountAdd" class="bg-red-100 hover:bg-red-200 text-red-800 font-bold py-2 px-4 rounded-md transition duration-150 ease-in-out text-lg focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-opacity-50">+</button>
                        </div>
                    </div>

                    <div class="flex flex-col sm:flex-row justify-end space-y-3 sm:space-y-0 sm:space-x-4 mt-6 border-t pt-4">
                        <button id="saveChanges" class="bg-yellow-500 hover:bg-yellow-600 text-gray-900 font-bold py-2 px-6 rounded-md transition duration-150 ease-in-out shadow-md focus:outline-none focus:ring-2 focus:ring-yellow-500 focus:ring-opacity-50">Simpan Perubahan</button>
                        <button id="resetData" class="bg-red-600 hover:bg-red-700 text-white font-bold py-2 px-6 rounded-md transition duration-150 ease-in-out shadow-md focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-opacity-50">Reset Data</button>
                    </div>
                </div>
            </div>

        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const realTimeClock = document.getElementById('realTimeClock');
            const workingDaysThisYear = document.getElementById('workingDaysThisYear');
            const safeWorkingDaysElement = document.getElementById('safeWorkingDays');
            const accidentCountElement = document.getElementById('accidentCount');

            // Admin Panel Elements are always present in this view
            const safeWorkingDaysInput = document.getElementById('safeWorkingDaysInput');
            const safeWorkingDaysAdd = document.getElementById('safeWorkingDaysAdd');
            const safeWorkingDaysSubtract = document.getElementById('safeWorkingDaysSubtract');
            const accidentCountInput = document.getElementById('accidentCountInput');
            const accidentCountAdd = document.getElementById('accidentCountAdd');
            const accidentCountSubtract = document.getElementById('accidentCountSubtract');
            const saveChangesButton = document.getElementById('saveChanges');
            const resetDataButton = document.getElementById('resetData');

            // --- Utility Functions ---

            // Custom function to get Day of Year (0-indexed)
            function getDayOfYear(date) {
                const start = new Date(date.getFullYear(), 0, 0);
                const diff = date.getTime() - start.getTime();
                const oneDay = 1000 * 60 * 60 * 24;
                return Math.floor(diff / oneDay);
            }

            // Check if a date is a working day (Monday-Friday)
            function isWorkingDay(date) {
                const dayOfWeek = date.getDay();
                return dayOfWeek !== 0 && dayOfWeek !== 6; // 0 = Sunday, 6 = Saturday
            }

            function calculateWorkingDaysThisYear() {
                const today = new Date();
                const currentYear = today.getFullYear();
                let workingDays = 0;
                // Loop from Jan 1st to today (inclusive)
                for (let i = 0; i <= getDayOfYear(today); i++) {
                    const date = new Date(currentYear, 0, i + 1); // i+1 because getDayOfYear is 0-indexed for 0
                    if (isWorkingDay(date)) {
                        workingDays++;
                    }
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

                // Admin Panel elements are always present in admin_dashboard
                safeWorkingDaysInput.value = safeWorkingDays;
                accidentCountInput.value = localStorage.getItem('accidentCount') || 0;
            }

            function saveData() {
                const oldAccidentCount = parseInt(localStorage.getItem('accidentCount')) || 0;
                const newAccidentCount = parseInt(accidentCountInput.value) || 0;
                let newSafeWorkingDays = parseInt(safeWorkingDaysInput.value) || 0;

                if (newAccidentCount > oldAccidentCount) {
                    newSafeWorkingDays = 0;
                    if (safeWorkingDaysInput) safeWorkingDaysInput.value = 0; // Update input field immediately
                    localStorage.setItem('lastSafeWorkingDayUpdate', new Date().toISOString()); // Reset update date
                }
                
                localStorage.setItem('safeWorkingDays', newSafeWorkingDays);
                localStorage.setItem('accidentCount', newAccidentCount);
                loadData(); // Refresh displayed data
                alert('Perubahan disimpan!');
            }

            function resetData() {
                if (confirm('Apakah Anda yakin ingin mereset semua data? Ini tidak dapat dibatalkan.')) {
                    localStorage.setItem('safeWorkingDays', 0);
                    localStorage.setItem('accidentCount', 0);
                    localStorage.setItem('lastSafeWorkingDayUpdate', new Date().toISOString()); // Reset update date
                    loadData(); // Refresh displayed data
                    alert('Data telah direset!');
                }
            }

            // --- Event Listeners and Initial Load ---

            // Clock update every second
            setInterval(updateClock, 1000);
            updateClock(); // Initial call to display immediately

            // Calculate working days this year
            calculateWorkingDaysThisYear();

            // Load saved data and handle auto-increment
            loadData();

            // Admin Panel Event Listeners
            safeWorkingDaysAdd.addEventListener('click', () => {
                safeWorkingDaysInput.value = parseInt(safeWorkingDaysInput.value) + 1;
            });
            safeWorkingDaysSubtract.addEventListener('click', () => {
                safeWorkingDaysInput.value = Math.max(0, parseInt(safeWorkingDaysInput.value) - 1);
            });
            accidentCountAdd.addEventListener('click', () => {
                accidentCountInput.value = parseInt(accidentCountInput.value) + 1;
                // Directly trigger reset of safe working days and update date here
                safeWorkingDaysInput.value = 0;
                localStorage.setItem('lastSafeWorkingDayUpdate', new Date().toISOString());
            });
            accidentCountSubtract.addEventListener('click', () => {
                accidentCountInput.value = Math.max(0, parseInt(accidentCountInput.value) - 1);
                // No reset for safe working days on decrement
            });
            saveChangesButton.addEventListener('click', saveData);
            resetDataButton.addEventListener('click', resetData);
        });
    </script>
</body>
</html>