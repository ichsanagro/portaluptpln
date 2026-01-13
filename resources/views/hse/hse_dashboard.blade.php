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

            {{-- Include the HSE Stats Component --}}
            @include('components.hse-stats')

            {{-- Admin Panel is removed from user view --}}

        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', () => {

        });
    </script>
</body>
</html>