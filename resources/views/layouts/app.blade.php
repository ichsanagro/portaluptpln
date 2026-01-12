<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full bg-gray-100">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $title ?? 'Dashboard' }} - Portal UPT PLN</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="h-full font-sans text-gray-900 antialiased">
    <div class="flex h-full">
        {{-- Sidebar --}}
        @include('layouts.partials.sidebar')

        {{-- Main Content Area --}}
        <div class="relative flex flex-1 flex-col overflow-y-auto">
            {{-- Top Bar --}}
            <header class="sticky top-0 z-10 flex h-16 flex-shrink-0 items-center justify-between border-b border-gray-200 bg-white/75 backdrop-blur-lg px-4 sm:px-6 lg:px-8">
                {{-- Page Title (Left) --}}
                <div class="flex items-center">
                    <h1 class="text-xl font-semibold text-blue-800 truncate">
                        @yield('title', 'Dashboard')
                    </h1>
                </div>

                {{-- Right Aligned Items --}}
                <div class="flex items-center gap-x-4 sm:gap-x-6">
                    {{-- Page-specific header items --}}
                    @stack('header-items')

                    {{-- User Profile Dropdown --}}
                    <div class="relative">
                        <button type="button" class="flex items-center gap-2 rounded-full focus:outline-none focus:ring-2 focus:ring-yellow-500 focus:ring-offset-2">
                            <span class="text-sm font-semibold">{{ session('user.name') ?? 'Guest' }}</span>
                            <img class="h-8 w-8 rounded-full" src="https://ui-avatars.com/api/?name={{ urlencode(session('user.name') ?? 'Guest') }}&color=7F9CF5&background=EBF4FF" alt="Avatar">
                        </button>
                        {{-- Dropdown menu can be added here --}}
                    </div>
                </div>
            </header>

            {{-- Page Content --}}
            <main class="flex-1 p-4 sm:p-6 lg:p-8">
                @yield('content')
            </main>

            @yield('modal-content')
        </div>
    </div>
    @stack('scripts')
</body>
</html>
