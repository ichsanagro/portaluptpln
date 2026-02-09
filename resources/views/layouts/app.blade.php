<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full bg-gray-100">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ $title ?? 'Dashboard' }} - Portal UPT PLN</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.1/dist/chart.umd.min.js"></script>
</head>
<body class="h-full font-sans text-gray-900 antialiased">
    <div class="flex h-full">
        @unless(isset($hideSidebar) && $hideSidebar)
            <!-- Sidebar -->
            @include('layouts.partials.sidebar')
            <!-- Sidebar Overlay -->
            <div id="sidebar-overlay" class="fixed inset-0 z-20 bg-black/50 hidden md:hidden"></div>
        @endunless

        <!-- Main Content Area -->
        <div class="relative flex flex-1 flex-col overflow-y-auto @if(isset($hideSidebar) && $hideSidebar) w-full @endif">
            <!-- Top Bar -->
            <header class="sticky top-0 z-10 flex h-16 flex-shrink-0 items-center justify-between border-b border-gray-200 bg-white/75 backdrop-blur-lg px-4 sm:px-6 lg:px-8">
                <!-- Mobile Hamburger Button and Page Title -->
                <div class="flex items-center gap-4">
                    @unless(isset($hideSidebar) && $hideSidebar)
                    <button id="sidebar-open-btn" class="md:hidden rounded-md p-1 text-gray-700 hover:bg-gray-100">
                        <svg class="h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25h16.5" />
                        </svg>
                    </button>
                    @endunless
                    <h1 class="text-xl font-semibold text-blue-800 truncate">
                        @yield('title', 'Dashboard')
                    </h1>
                </div>

                <!-- Right Aligned Items -->
                <div class="flex items-center gap-x-4 sm:gap-x-6">
                    {{-- Page-specific header items --}}
                    @stack('header-items')

                    {{-- User Profile Dropdown --}}
                    <div class="relative">
                        <button type="button" class="flex items-center gap-2 rounded-full focus:outline-none focus:ring-2 focus:ring-yellow-500 focus:ring-offset-2">
                            <span class="text-sm font-semibold">
                                @if(Auth::check())
                                    @if(Auth::user()->hasRole('admin logistik'))
                                        Admin
                                    @else
                                        {{ Auth::user()->name }}
                                    @endif
                                @else
                                    Guest
                                @endif
                            </span>
                            <svg class="h-8 w-8 rounded-full text-gray-400" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M17.982 18.725A7.488 7.488 0 0012 15.75a7.488 7.488 0 00-5.982 2.975m11.963 0a9 9 0 10-11.963 0m11.963 0A8.966 8.966 0 0112 21a8.966 8.966 0 01-5.982-2.275M15 9.75a3 3 0 11-6 0 3 3 0 016 0z" />
                            </svg>
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
    @unless(isset($hideSidebar) && $hideSidebar)
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const sidebar = document.getElementById('sidebar');
            const openBtn = document.getElementById('sidebar-open-btn');
            const closeBtn = document.getElementById('sidebar-close-btn');
            const overlay = document.getElementById('sidebar-overlay');

            function openSidebar() {
                if (sidebar && overlay) {
                    sidebar.classList.remove('-translate-x-full');
                    sidebar.classList.add('translate-x-0');
                    overlay.classList.remove('hidden');
                }
            }

            function closeSidebar() {
                if (sidebar && overlay) {
                    sidebar.classList.remove('translate-x-0');
                    sidebar.classList.add('-translate-x-full');
                    overlay.classList.add('hidden');
                }
            }

            if (openBtn) {
                openBtn.addEventListener('click', openSidebar);
            }
            if (closeBtn) {
                closeBtn.addEventListener('click', closeSidebar);
            }
            if (overlay) {
                overlay.addEventListener('click', closeSidebar);
            }
        });
    </script>
    @endunless
</body>
</html>
