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
                    <!-- Start Date Management -->
                    <div class="flex flex-col sm:flex-row items-center justify-between bg-white p-4 rounded-md shadow-sm border border-gray-100">
                        <label for="startDateInput" class="text-lg font-medium text-gray-700 mb-2 sm:mb-0 sm:mr-4 w-full sm:w-auto">Tanggal Mulai Hari Kerja:</label>
                        <div class="flex items-center space-x-2 w-full sm:w-auto">
                            <input type="date" id="startDateInput" class="form-input w-full sm:w-auto text-center border-gray-300 rounded-md shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50">
                        </div>
                    </div>

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

            // Admin Panel Elements
            const startDateInput = document.getElementById('startDateInput');
            const safeWorkingDaysInput = document.getElementById('safeWorkingDaysInput');
            const safeWorkingDaysAdd = document.getElementById('safeWorkingDaysAdd');
            const safeWorkingDaysSubtract = document.getElementById('safeWorkingDaysSubtract');
            const accidentCountInput = document.getElementById('accidentCountInput');
            const accidentCountAdd = document.getElementById('accidentCountAdd');
            const accidentCountSubtract = document.getElementById('accidentCountSubtract');
            const saveChangesButton = document.getElementById('saveChanges');
            const resetDataButton = document.getElementById('resetData');

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
                // Load and set custom start date
                const savedStartDate = localStorage.getItem('hseStartDate');
                if (savedStartDate) {
                    startDateInput.value = savedStartDate;
                }

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

                safeWorkingDaysInput.value = safeWorkingDays;
                accidentCountInput.value = localStorage.getItem('accidentCount') || 0;

                // After loading, recalculate working days based on loaded start date
                calculateWorkingDaysThisYear();
            }

            function saveData() {
                const oldAccidentCount = parseInt(localStorage.getItem('accidentCount')) || 0;
                const newAccidentCount = parseInt(accidentCountInput.value) || 0;
                let newSafeWorkingDays = parseInt(safeWorkingDaysInput.value) || 0;

                if (newAccidentCount > oldAccidentCount) {
                    newSafeWorkingDays = 0;
                    if (safeWorkingDaysInput) safeWorkingDaysInput.value = 0;
                    localStorage.setItem('lastSafeWorkingDayUpdate', new Date().toISOString());
                }
                
                localStorage.setItem('safeWorkingDays', newSafeWorkingDays);
                localStorage.setItem('accidentCount', newAccidentCount);

                // Save the custom start date
                if (startDateInput.value) {
                    localStorage.setItem('hseStartDate', startDateInput.value);
                } else {
                    localStorage.removeItem('hseStartDate');
                }

                loadData(); // Refresh all data and recalculate
                alert('Perubahan disimpan!');
            }

            function resetData() {
                if (confirm('Apakah Anda yakin ingin mereset semua data? Ini tidak dapat dibatalkan.')) {
                    localStorage.removeItem('safeWorkingDays');
                    localStorage.removeItem('accidentCount');
                    localStorage.removeItem('lastSafeWorkingDayUpdate');
                    localStorage.removeItem('hseStartDate'); // Also remove the custom start date
                    
                    // Reset input fields
                    startDateInput.value = '';
                    safeWorkingDaysInput.value = 0;
                    accidentCountInput.value = 0;

                    loadData(); // Refresh displayed data
                    alert('Data telah direset!');
                }
            }

            // --- Event Listeners and Initial Load ---

            setInterval(updateClock, 1000);
            updateClock();

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
                safeWorkingDaysInput.value = 0;
                localStorage.setItem('lastSafeWorkingDayUpdate', new Date().toISOString());
            });
            accidentCountSubtract.addEventListener('click', () => {
                accidentCountInput.value = Math.max(0, parseInt(accidentCountInput.value) - 1);
            });
            saveChangesButton.addEventListener('click', saveData);
            resetDataButton.addEventListener('click', resetData);
        });
    </script>
</body>
</html>