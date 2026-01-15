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

                    <!-- Display Settings Management -->
                    <form action="{{ route('hse.admin_display_update') }}" method="POST" enctype="multipart/form-data" class="bg-white p-4 rounded-md shadow-sm border border-gray-100 space-y-4">
                        @csrf
                        <h3 class="text-lg font-medium text-gray-700 border-b pb-2">Pengaturan Tampilan Dashboard</h3>
                        
                        <!-- Display Mode -->
                        <div class="flex items-center space-x-4">
                            <label class="text-base font-medium text-gray-700">Tampilkan:</label>
                            <div class="flex items-center">
                                <input type="radio" id="displayModeVideo" name="display_mode" value="video" class="h-4 w-4 text-blue-600 border-gray-300 focus:ring-blue-500" {{ ($displayMode ?? 'video') === 'video' ? 'checked' : '' }}>
                                <label for="displayModeVideo" class="ml-2 block text-sm font-medium text-gray-900">Video</label>
                            </div>
                            <div class="flex items-center">
                                <input type="radio" id="displayModeImage" name="display_mode" value="image" class="h-4 w-4 text-blue-600 border-gray-300 focus:ring-blue-500" {{ ($displayMode ?? '') === 'image' ? 'checked' : '' }}>
                                <label for="displayModeImage" class="ml-2 block text-sm font-medium text-gray-900">Gambar</label>
                            </div>
                        </div>

                        <!-- Video URL Input -->
                        <div id="videoInputContainer">
                            <label for="videoUrlInput" class="block text-sm font-medium text-gray-700">URL Video (YouTube):</label>
                            <input type="url" id="videoUrlInput" name="video_url" value="{{ $videoUrl ?? '' }}" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm" placeholder="https://www.youtube.com/watch?v=...">
                        </div>

                        <!-- Image Upload Input -->
                        <div id="imageInputContainer" class="hidden">
                            <label for="dashboardImageInput" class="block text-sm font-medium text-gray-700">Upload Gambar:</label>
                            <input type="file" id="dashboardImageInput" name="dashboard_image" class="mt-1 block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100">
                            @if($imageUrl)
                                <div class="mt-2">
                                    <p class="text-sm text-gray-500">Gambar saat ini:</p>
                                    <img src="{{ $imageUrl }}" alt="Dashboard Image" class="mt-1 h-24 w-auto rounded-md border">
                                </div>
                            @endif
                        </div>

                        <div class="flex justify-end mt-4">
                            <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-6 rounded-md transition duration-150 ease-in-out shadow-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-opacity-50">Update Tampilan</button>
                        </div>
                    </form>



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

            // Display Mode Toggle Logic
            const displayModeVideo = document.getElementById('displayModeVideo');
            const displayModeImage = document.getElementById('displayModeImage');
            const videoInputContainer = document.getElementById('videoInputContainer');
            const imageInputContainer = document.getElementById('imageInputContainer');
            const dashboardImageInput = document.getElementById('dashboardImageInput');
            const videoUrlInput = document.getElementById('videoUrlInput');

            function toggleDisplayInputs() {
                if (displayModeVideo.checked) {
                    videoInputContainer.classList.remove('hidden');
                    imageInputContainer.classList.add('hidden');
                    dashboardImageInput.value = ''; // Clear file input when switching away
                } else if (displayModeImage.checked) {
                    videoInputContainer.classList.add('hidden');
                    imageInputContainer.classList.remove('hidden');
                    videoUrlInput.value = ''; // Clear video URL when switching away
                }
            }

            // Initial state
            toggleDisplayInputs();

            displayModeVideo.addEventListener('change', toggleDisplayInputs);
            displayModeImage.addEventListener('change', toggleDisplayInputs);
        });
    </script>
</body>
</html>