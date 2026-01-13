<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>HSE Admin Dashboard</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-100 text-gray-900 min-h-screen flex flex-col font-sans antialiased">
    <div class="flex-grow p-4 sm:p-6 lg:p-8">
        <div class="max-w-7xl mx-auto bg-white rounded-lg shadow-xl p-6 sm:p-8 lg:p-10">
            <h1 class="text-3xl sm:text-4xl font-extrabold mb-8 text-center text-blue-800">HSE Admin Dashboard</h1>

            {{-- Include the HSE Stats Component --}}
            @include('components.hse-stats')

            <div class="bg-gray-50 p-6 sm:p-8 rounded-lg shadow-lg border border-gray-200">
                <h2 class="text-2xl font-bold mb-6 text-blue-800 border-b pb-3">Admin Panel</h2>
                <div class="space-y-6">
                    <!-- Start Date Management -->
                    <div class="flex flex-col sm:flex-row items-center justify-between bg-white p-4 rounded-md shadow-sm border border-gray-100">
                        <label for="startDateInput" class="text-lg font-medium text-gray-700 mb-2 sm:mb-0 sm:mr-4 w-full sm:w-auto">Tanggal Mulai Hari Kerja:</label>
                        <div class="flex items-center space-x-2 w-full sm:w-auto">
                            <input type="date" id="startDateInput" value="{{ $startDate }}" class="form-input w-full sm:w-auto text-center border-gray-300 rounded-md shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50">
                        </div>
                    </div>

                    <!-- Safe Working Days Management -->
                    <div class="flex flex-col sm:flex-row items-center justify-between bg-white p-4 rounded-md shadow-sm border border-gray-100">
                        <label for="safeWorkingDaysInput" class="text-lg font-medium text-gray-700 mb-2 sm:mb-0 sm:mr-4 w-full sm:w-auto">Hari Kerja Aman:</label>
                        <div class="flex items-center space-x-2 w-full sm:w-auto">
                            <button id="safeWorkingDaysSubtract" class="bg-blue-100 hover:bg-blue-200 text-blue-800 font-bold py-2 px-4 rounded-md transition duration-150 ease-in-out text-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-opacity-50">-</button>
                            <input type="number" id="safeWorkingDaysInput" class="form-input w-24 text-center border-gray-300 rounded-md shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50" value="{{ $safeWorkingDays }}">
                            <button id="safeWorkingDaysAdd" class="bg-blue-100 hover:bg-blue-200 text-blue-800 font-bold py-2 px-4 rounded-md transition duration-150 ease-in-out text-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-opacity-50">+</button>
                        </div>
                    </div>

                    <!-- Accident Count Management -->
                    <div class="flex flex-col sm:flex-row items-center justify-between bg-white p-4 rounded-md shadow-sm border border-gray-100">
                        <label for="accidentCountInput" class="text-lg font-medium text-gray-700 mb-2 sm:mb-0 sm:mr-4 w-full sm:w-auto">Jumlah Kecelakaan:</label>
                        <div class="flex items-center space-x-2 w-full sm:w-auto">
                            <button id="accidentCountSubtract" class="bg-red-100 hover:bg-red-200 text-red-800 font-bold py-2 px-4 rounded-md transition duration-150 ease-in-out text-lg focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-opacity-50">-</button>
                            <input type="number" id="accidentCountInput" class="form-input w-24 text-center border-gray-300 rounded-md shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50" value="{{ $accidentCount }}">
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

            async function saveData() {
                const data = {
                    start_date: startDateInput.value,
                    safe_working_days: parseInt(safeWorkingDaysInput.value),
                    accident_count: parseInt(accidentCountInput.value),
                };

                try {
                    const response = await fetch('{{ route("hse.admin_stats_update") }}', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                        },
                        body: JSON.stringify(data)
                    });

                    const result = await response.json();

                    if (result.success) {
                        alert(result.message);
                        window.location.reload();
                    } else {
                        alert('Gagal menyimpan perubahan: ' + (result.message || 'Error tidak diketahui.'));
                    }
                } catch (error) {
                    console.error('Error:', error);
                    alert('Terjadi kesalahan saat menyimpan data.');
                }
            }

            async function resetData() {
                if (confirm('Apakah Anda yakin ingin mereset semua data? Ini tidak dapat dibatalkan.')) {
                    try {
                        const response = await fetch('{{ route("hse.admin_stats_reset") }}', {
                            method: 'POST',
                            headers: {
                                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                            }
                        });

                        const result = await response.json();

                        if (result.success) {
                            alert(result.message);
                            window.location.reload();
                        } else {
                            alert('Gagal mereset data: ' + (result.message || 'Error tidak diketahui.'));
                        }
                    } catch (error) {
                        console.error('Error:', error);
                        alert('Terjadi kesalahan saat mereset data.');
                    }
                }
            }

            // Admin Panel Event Listeners
            if(saveChangesButton) {
                safeWorkingDaysAdd.addEventListener('click', () => {
                    safeWorkingDaysInput.value = parseInt(safeWorkingDaysInput.value) + 1;
                });
                safeWorkingDaysSubtract.addEventListener('click', () => {
                    safeWorkingDaysInput.value = Math.max(0, parseInt(safeWorkingDaysInput.value) - 1);
                });
                accidentCountAdd.addEventListener('click', () => {
                    const currentAccidents = parseInt(accidentCountInput.value);
                    accidentCountInput.value = currentAccidents + 1;
                });
                accidentCountSubtract.addEventListener('click', () => {
                    accidentCountInput.value = Math.max(0, parseInt(accidentCountInput.value) - 1);
                });
                saveChangesButton.addEventListener('click', saveData);
                resetDataButton.addEventListener('click', resetData);
            }
        });
    </script>
</body>
</html>