@extends('layouts.app')

@section('title', 'HSE Admin Dashboard')

@section('content')
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
                        <a href="{{ route('hse.admin_playlist.index') }}" class="bg-purple-600 hover:bg-purple-700 text-white font-bold py-2 px-6 rounded-md transition duration-150 ease-in-out shadow-md focus:outline-none focus:ring-2 focus:ring-purple-500 focus:ring-opacity-50 text-center">Kelola Playlist</a>
                        <a href="{{ route('hse.admin_accidents.index') }}" class="bg-green-600 hover:bg-green-700 text-white font-bold py-2 px-6 rounded-md transition duration-150 ease-in-out shadow-md focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-opacity-50 text-center">Kelola Kecelakaan</a>
                        <button id="saveChanges" class="bg-yellow-500 hover:bg-yellow-600 text-gray-900 font-bold py-2 px-6 rounded-md transition duration-150 ease-in-out shadow-md focus:outline-none focus:ring-2 focus:ring-yellow-500 focus:ring-opacity-50">Simpan Perubahan</button>
                        <button id="resetData" class="bg-red-600 hover:bg-red-700 text-white font-bold py-2 px-6 rounded-md transition duration-150 ease-in-out shadow-md focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-opacity-50">Reset Data</button>

                    </div>
                </div>
            </div>

            {{-- Modal Tambah Detail Kecelakaan --}}
            <div id="accident-details-modal" class="fixed inset-0 z-20 hidden overflow-y-auto bg-black/50 backdrop-blur-sm transition-opacity duration-300 ease-out opacity-0">
                <div class="flex min-h-full items-center justify-center p-4 text-center sm:p-0">
                    <div class="inline-block align-bottom bg-white rounded-lg px-4 pt-5 pb-4 text-left overflow-hidden shadow-2xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full sm:p-6 opacity-0 scale-95 duration-300 ease-out"
                        role="dialog" aria-modal="true" aria-labelledby="modal-title">
                        <div class="flex items-center justify-between border-b border-slate-300 pb-4">
                            <h3 class="text-xl font-bold text-slate-800" id="modal-title">Tambah Detail Kecelakaan</h3>
                            <button type="button" id="close-accident-modal-btn" class="text-gray-500 hover:text-gray-700 rounded-full p-1 hover:bg-gray-100 transition-colors">
                                <svg class="h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                </svg>
                            </button>
                        </div>
                        <div class="mt-6 space-y-6">
                            <div>
                                <label for="last_accident_date_modal" class="block text-sm font-medium text-gray-700">Tanggal Kecelakaan</label>
                                <div class="mt-2">
                                    <input type="date" id="last_accident_date_modal" class="form-input w-full border-gray-300 rounded-md shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50">
                                </div>
                            </div>
                            <div>
                                <label for="accident_description_modal" class="block text-sm font-medium text-gray-700">Keterangan Singkat</label>
                                <div class="mt-2">
                                    <textarea id="accident_description_modal" rows="4" class="block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50" placeholder="Jelaskan secara singkat apa yang terjadi..."></textarea>
                                </div>
                            </div>
                        </div>
                        <div class="mt-8 flex items-center justify-end gap-x-3">
                            <button type="button" id="cancel-accident-btn" class="rounded-md border border-gray-300 bg-white px-4 py-2 text-sm font-medium text-gray-700 shadow-sm hover:bg-gray-50">Batal</button>
                            <button type="button" id="saveAccidentDetails" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded-md shadow-sm">Simpan Detail</button>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
@endsection

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            // JS variables to hold the new accident details
            let lastAccidentDateToSave = null;
            let accidentDescriptionToSave = null;

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

            // Accident Details Modal Elements
            const accidentModal = document.getElementById('accident-details-modal');
            const openAccidentModalBtn = document.getElementById('accidentCountAdd');
            const closeAccidentModalBtn = document.getElementById('close-accident-modal-btn');
            const cancelAccidentBtn = document.getElementById('cancel-accident-btn');
            const saveAccidentDetailsBtn = document.getElementById('saveAccidentDetails');
            const lastAccidentDateModalInput = document.getElementById('last_accident_date_modal');
            const accidentDescriptionModalInput = document.getElementById('accident_description_modal');
            
            // --- MAIN SAVE FUNCTION ---
            async function saveData() {
                const data = {
                    start_date: startDateInput.value,
                    safe_working_days: parseInt(safeWorkingDaysInput.value),
                    accident_count: parseInt(accidentCountInput.value),
                    last_accident_date: lastAccidentDateToSave,
                    accident_description: accidentDescriptionToSave,
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
                        Swal.fire({
                            title: 'Berhasil!',
                            text: result.message,
                            icon: 'success',
                            confirmButtonColor: '#3085d6',
                            confirmButtonText: 'OK'
                        }).then(() => {
                            window.location.reload();
                        });
                    } else {
                        let errorMessage = result.message || 'Error tidak diketahui.';
                        if (result.errors) {
                            errorMessage = '<div class="text-left"><strong>Detail Error:</strong><ul class="list-disc list-inside">';
                            for (const key in result.errors) {
                                errorMessage += `<li>${result.errors[key].join(', ')}</li>`;
                            }
                            errorMessage += '</ul></div>';
                        }
                        Swal.fire({
                            title: 'Gagal Menyimpan Perubahan',
                            html: errorMessage,
                            icon: 'error',
                            confirmButtonColor: '#d33',
                            confirmButtonText: 'Tutup'
                        });
                    }
                } catch (error) {
                    console.error('Error:', error);
                    Swal.fire({
                        title: 'Terjadi Kesalahan',
                        text: 'Tidak dapat terhubung ke server. Silakan coba lagi nanti.',
                        icon: 'error',
                        confirmButtonColor: '#d33',
                        confirmButtonText: 'Tutup'
                    });
                }
            }
            
            // --- RESET DATA FUNCTION ---
            function resetData() {
                Swal.fire({
                    title: 'Apakah Anda yakin?',
                    text: "Anda akan mereset semua data statistik. Ini tidak dapat dibatalkan!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#d33',
                    cancelButtonColor: '#3085d6',
                    confirmButtonText: 'Ya, reset!',
                    cancelButtonText: 'Batal'
                }).then((result) => {
                    if (result.isConfirmed) {
                        performReset();
                    }
                });
            }

            async function performReset() {
                try {
                    const response = await fetch('{{ route("hse.admin_stats_reset") }}', {
                        method: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                        }
                    });
                    const result = await response.json();
                    if (result.success) {
                        Swal.fire({
                            title: 'Berhasil!',
                            text: result.message,
                            icon: 'success',
                            confirmButtonColor: '#3085d6',
                            confirmButtonText: 'OK'
                        }).then(() => {
                            window.location.reload();
                        });
                    } else {
                        Swal.fire({
                            title: 'Gagal Mereset Data',
                            text: result.message || 'Error tidak diketahui.',
                            icon: 'error',
                            confirmButtonColor: '#d33',
                            confirmButtonText: 'Tutup'
                        });
                    }
                } catch (error) {
                    console.error('Error:', error);
                    Swal.fire({
                        title: 'Terjadi Kesalahan',
                        text: 'Tidak dapat terhubung ke server saat mereset data.',
                        icon: 'error',
                        confirmButtonColor: '#d33',
                        confirmButtonText: 'Tutup'
                    });
                }
            }

            // --- ACCIDENT MODAL FUNCTIONS ---
            const openAccidentModal = () => {
                if (!accidentModal) return;
                lastAccidentDateModalInput.value = new Date().toISOString().slice(0,10);
                accidentDescriptionModalInput.value = '';
                accidentModal.classList.remove('hidden');
                setTimeout(() => {
                    accidentModal.classList.remove('opacity-0');
                    accidentModal.querySelector('[role="dialog"]').classList.remove('opacity-0', 'scale-95');
                }, 50);
            };

            const closeAccidentModal = () => {
                if (!accidentModal) return;
                accidentModal.classList.add('opacity-0');
                accidentModal.querySelector('[role="dialog"]').classList.add('opacity-0', 'scale-95');
                setTimeout(() => {
                    accidentModal.classList.add('hidden');
                }, 300);
            };
            
            // --- EVENT LISTENERS ---
            if(saveChangesButton) {
                // Safe Days buttons
                safeWorkingDaysAdd.addEventListener('click', () => {
                    safeWorkingDaysInput.value = parseInt(safeWorkingDaysInput.value) + 1;
                });
                safeWorkingDaysSubtract.addEventListener('click', () => {
                    safeWorkingDaysInput.value = Math.max(0, parseInt(safeWorkingDaysInput.value) - 1);
                });

                // Accident Count buttons
                openAccidentModalBtn.addEventListener('click', openAccidentModal);
                
                accidentCountSubtract.addEventListener('click', () => {
                    accidentCountInput.value = Math.max(0, parseInt(accidentCountInput.value) - 1);
                });

                // Main Save/Reset buttons
                saveChangesButton.addEventListener('click', saveData);
                resetDataButton.addEventListener('click', resetData);

                // Modal buttons
                closeAccidentModalBtn.addEventListener('click', closeAccidentModal);
                cancelAccidentBtn.addEventListener('click', closeAccidentModal);
                saveAccidentDetailsBtn.addEventListener('click', () => {
                    if (!lastAccidentDateModalInput.value) {
                        Swal.fire({
                            title: 'Input Tidak Valid',
                            text: 'Tanggal kecelakaan tidak boleh kosong.',
                            icon: 'warning',
                            confirmButtonColor: '#f8bb86',
                            confirmButtonText: 'OK'
                        });
                        return;
                    }
                    // Populate the JS variables
                    lastAccidentDateToSave = lastAccidentDateModalInput.value;
                    accidentDescriptionToSave = accidentDescriptionModalInput.value;
                    
                    // Increment the counter
                    accidentCountInput.value = parseInt(accidentCountInput.value) + 1;
                    
                    closeAccidentModal();
                    
                    Swal.fire({
                        toast: true,
                        position: 'top-end',
                        icon: 'info',
                        title: 'Detail kecelakaan dicatat.',
                        text: 'Klik "Simpan Perubahan" untuk menyimpan data ke server.',
                        showConfirmButton: false,
                        timer: 4000,
                        timerProgressBar: true
                    });
                });

                // Modal close on escape/outside click
                document.addEventListener('keydown', (e) => {
                    if (e.key === 'Escape' && !accidentModal.classList.contains('hidden')) {
                        closeAccidentModal();
                    }
                });
                accidentModal.addEventListener('click', (e) => {
                    if (e.target === accidentModal) {
                        closeAccidentModal();
                    }
                });
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
                    dashboardImageInput.value = '';
                } else if (displayModeImage.checked) {
                    videoInputContainer.classList.add('hidden');
                    imageInputContainer.classList.remove('hidden');
                    videoUrlInput.value = '';
                }
            }

            toggleDisplayInputs();
            displayModeVideo.addEventListener('change', toggleDisplayInputs);
            displayModeImage.addEventListener('change', toggleDisplayInputs);
        });
    </script>
@endpush
