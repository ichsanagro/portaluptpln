<div class="flex h-screen w-64 flex-col bg-blue-900 text-white">
    <!-- Sidebar Header -->
    <div class="flex h-16 flex-shrink-0 items-center border-b border-blue-700 px-4">
        @php
            $dashboardRoute = '/';
            if (Auth::check()) {
                $role = Auth::user()->role;
                if ($role == 'admin logistik') {
                    $dashboardRoute = route('logistik.adminlogistik.dashboard');
                } elseif ($role == 'user logistik') {
                    $dashboardRoute = route('logistik.userlogistik.dashboard');
                } elseif ($role == 'admin hse') {
                    $dashboardRoute = route('hse.admin_dashboard');
                } elseif ($role == 'user hse') {
                    $dashboardRoute = route('hse.dashboard');
                }
            }
        @endphp
        <a href="{{ $dashboardRoute }}" class="flex items-center gap-2">
            <svg class="h-8 w-auto text-yellow-400" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" d="m3.75 13.5 10.5-11.25L12 10.5h8.25L9.75 21.75 12 13.5H3.75Z" />
            </svg>
            <span class="text-xl font-bold">PLN UPT BENGKULU</span>
        </a>
    </div>

    <!-- Navigation Links -->
    <nav class="flex-1 space-y-1 overflow-y-auto p-2">
        @if(Auth::check())
            @if(Auth::user()->role == 'super admin')
                <a href="{{ route('superadmin.dashboard') }}"
                   class="{{ request()->routeIs('superadmin.dashboard') ? 'bg-blue-800 text-white' : 'text-blue-200 hover:bg-blue-700 hover:text-white' }} group flex items-center rounded-md px-2 py-2 text-sm font-medium">
                    <svg class="mr-3 h-6 w-6 flex-shrink-0" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6A2.25 2.25 0 016 3.75h2.25A2.25 2.25 0 0110.5 6v2.25a2.25 2.25 0 01-2.25 2.25H6a2.25 2.25 0 01-2.25-2.25V6zM3.75 15.75A2.25 2.25 0 016 13.5h2.25a2.25 2.25 0 012.25 2.25V18a2.25 2.25 0 01-2.25 2.25H6A2.25 2.25 0 013.75 18v-2.25zM13.5 6a2.25 2.25 0 012.25-2.25H18A2.25 2.25 0 0120.25 6v2.25A2.25 2.25 0 0118 10.5h-2.25a2.25 2.25 0 01-2.25-2.25V6zM13.5 15.75a2.25 2.25 0 012.25-2.25H18a2.25 2.25 0 012.25 2.25V18A2.25 2.25 0 0118 20.25h-2.25A2.25 2.25 0 0113.5 18v-2.25z" />
                    </svg>
                    Dashboard
                </a>
                <a href="{{ route('superadmin.users.index') }}"
                   class="{{ request()->routeIs('superadmin.users.*') ? 'bg-blue-800 text-white' : 'text-blue-200 hover:bg-blue-700 hover:text-white' }} group flex items-center rounded-md px-2 py-2 text-sm font-medium">
                    <svg class="mr-3 h-6 w-6 flex-shrink-0" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M18 18.72a9.094 9.094 0 003.741-.479 3 3 0 00-4.682-2.72m-7.5-2.952a4.5 4.5 0 014.5 0m-4.5 0a4.5 4.5 0 00-4.5 0m12.002 9.052a4.5 4.5 0 01-8.498-2.052M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                    </svg>
                    Manajemen User
                </a>
                <a href="{{ route('superadmin.monitoring.material.index') }}"
                   class="{{ request()->routeIs('superadmin.monitoring.material.index') ? 'bg-blue-800 text-white' : 'text-blue-200 hover:bg-blue-700 hover:text-white' }} group flex items-center rounded-md px-2 py-2 text-sm font-medium">
                    <svg class="mr-3 h-6 w-6 flex-shrink-0" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M21 7.5l-9-5.25L3 7.5m18 0l-9 5.25m9-5.25v9l-9 5.25M3 7.5l9 5.25M3 7.5v9l9 5.25m0-9v9" />
                    </svg>
                    Monitoring Material
                </a>
                <a href="{{ route('superadmin.monitoring.riwayat.index') }}"
                   class="{{ request()->routeIs('superadmin.monitoring.riwayat.index') ? 'bg-blue-800 text-white' : 'text-blue-200 hover:bg-blue-700 hover:text-white' }} group flex items-center rounded-md px-2 py-2 text-sm font-medium">
                    <svg class="mr-3 h-6 w-6 flex-shrink-0" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    Monitoring Riwayat
                </a>
                <a href="{{ route('superadmin.monitoring.kerusakan.index') }}"
                   class="{{ request()->routeIs('superadmin.monitoring.kerusakan.index') ? 'bg-blue-800 text-white' : 'text-blue-200 hover:bg-blue-700 hover:text-white' }} group flex items-center rounded-md px-2 py-2 text-sm font-medium">
                    <svg class="mr-3 h-6 w-6 flex-shrink-0" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126zM12 15.75h.007v.008H12v-.008z" />
                    </svg>
                    Monitoring Kerusakan
                </a>
                <a href="{{ route('superadmin.monitoring.kecelakaan.index') }}"
                   class="{{ request()->routeIs('superadmin.monitoring.kecelakaan.index') ? 'bg-blue-800 text-white' : 'text-blue-200 hover:bg-blue-700 hover:text-white' }} group flex items-center rounded-md px-2 py-2 text-sm font-medium">
                    <svg class="mr-3 h-6 w-6 flex-shrink-0" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M11.25 11.25l.25.25m0 0l-2.5-2.5M11.5 11.5l2.5-2.5M11.5 11.5l2.5 2.5m-2.5-2.5l-2.5 2.5M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25h16.5" />
                    </svg>
                    Monitoring Kecelakaan
                </a>
            @elseif(Auth::user()->role == 'admin logistik')
                <a href="{{ route('logistik.adminlogistik.dashboard') }}"
                   class="{{ request()->routeIs('logistik.adminlogistik.dashboard') ? 'bg-blue-800 text-white' : 'text-blue-200 hover:bg-blue-700 hover:text-white' }} group flex items-center rounded-md px-2 py-2 text-sm font-medium">
                    <svg class="mr-3 h-6 w-6 flex-shrink-0" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6A2.25 2.25 0 016 3.75h2.25A2.25 2.25 0 0110.5 6v2.25a2.25 2.25 0 01-2.25 2.25H6a2.25 2.25 0 01-2.25-2.25V6zM3.75 15.75A2.25 2.25 0 016 13.5h2.25a2.25 2.25 0 012.25 2.25V18a2.25 2.25 0 01-2.25 2.25H6A2.25 2.25 0 013.75 18v-2.25zM13.5 6a2.25 2.25 0 012.25-2.25H18A2.25 2.25 0 0120.25 6v2.25A2.25 2.25 0 0118 10.5h-2.25a2.25 2.25 0 01-2.25-2.25V6zM13.5 15.75a2.25 2.25 0 012.25-2.25H18a2.25 2.25 0 012.25 2.25V18A2.25 2.25 0 0118 20.25h-2.25A2.25 2.25 0 0113.5 18v-2.25z" />
                    </svg>
                    Dashboard
                </a>
                <a href="{{ route('logistik.adminlogistik.material.index') }}"
                   class="{{ request()->routeIs('logistik.adminlogistik.material.index') ? 'bg-blue-800 text-white' : 'text-blue-200 hover:bg-blue-700 hover:text-white' }} group flex items-center rounded-md px-2 py-2 text-sm font-medium">
                    <svg class="mr-3 h-6 w-6 flex-shrink-0" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M21 7.5l-9-5.25L3 7.5m18 0l-9 5.25m9-5.25v9l-9 5.25M3 7.5l9 5.25M3 7.5v9l9 5.25m0-9v9" />
                    </svg>
                    Kelola Material
                </a>
                <a href="{{ route('logistik.adminlogistik.riwayat') }}"
                   class="{{ request()->routeIs('logistik.adminlogistik.riwayat') ? 'bg-blue-800 text-white' : 'text-blue-200 hover:bg-blue-700 hover:text-white' }} group flex items-center rounded-md px-2 py-2 text-sm font-medium">
                    <svg class="mr-3 h-6 w-6 flex-shrink-0" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    Riwayat
                </a>
                <a href="{{ route('logistik.adminlogistik.uji_kerusakan') }}"
                   class="{{ request()->routeIs('logistik.adminlogistik.uji_kerusakan') ? 'bg-blue-800 text-white' : 'text-blue-200 hover:bg-blue-700 hover:text-white' }} group flex items-center rounded-md px-2 py-2 text-sm font-medium">
                    <svg class="mr-3 h-6 w-6 flex-shrink-0" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126zM12 15.75h.007v.008H12v-.008z" />
                    </svg>
                    Uji Kerusakan
                </a>
            @elseif(Auth::user()->role == 'user logistik')
                <a href="{{ route('logistik.userlogistik.dashboard') }}"
                   class="{{ request()->routeIs('logistik.userlogistik.dashboard') ? 'bg-blue-800 text-white' : 'text-blue-200 hover:bg-blue-700 hover:text-white' }} group flex items-center rounded-md px-2 py-2 text-sm font-medium">
                    <svg class="mr-3 h-6 w-6 flex-shrink-0" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6A2.25 2.25 0 016 3.75h2.25A2.25 2.25 0 0110.5 6v2.25a2.25 2.25 0 01-2.25 2.25H6a2.25 2.25 0 01-2.25-2.25V6zM3.75 15.75A2.25 2.25 0 016 13.5h2.25a2.25 2.25 0 012.25 2.25V18a2.25 2.25 0 01-2.25 2.25H6A2.25 2.25 0 013.75 18v-2.25zM13.5 6a2.25 2.25 0 012.25-2.25H18A2.25 2.25 0 0120.25 6v2.25A2.25 2.25 0 0118 10.5h-2.25a2.25 2.25 0 01-2.25-2.25V6zM13.5 15.75a2.25 2.25 0 012.25-2.25H18a2.25 2.25 0 012.25 2.25V18A2.25 2.25 0 0118 20.25h-2.25A2.25 2.25 0 0113.5 18v-2.25z" />
                    </svg>
                    Dashboard
                </a>
                <div class="relative">
                    <button id="peminjaman-toggle"
                       class="{{ request()->routeIs(['logistik.userlogistik.peminjaman', 'logistik.userlogistik.permintaan']) ? 'bg-blue-800 text-white' : 'text-blue-200 hover:bg-blue-700 hover:text-white' }} group flex items-center rounded-md px-2 py-2 text-sm font-medium w-full text-left">
                        <svg class="mr-3 h-6 w-6 flex-shrink-0" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 10.5V6a3.75 3.75 0 10-7.5 0v4.5m11.356-1.993l1.263 12c.07.658-.463 1.243-1.119 1.243H4.25a1.125 1.125 0 01-1.12-1.243l1.264-12A1.125 1.125 0 015.513 7.5h12.974c.576 0 1.059.435 1.119 1.007zM8.625 10.5a.375.375 0 11-.75 0 .375.375 0 01.75 0zm7.5 0a.375.375 0 11-.75 0 .375.375 0 01.75 0z" />
                        </svg>
                        Pemesanan
                        <svg class="ml-auto h-4 w-4 transition-transform duration-200" id="peminjaman-arrow" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 8.25l-7.5 7.5-7.5-7.5" />
                        </svg>
                    </button>
                    <div id="peminjaman-submenu" class="hidden ml-6 mt-1 space-y-1">
                        <a href="{{ route('logistik.userlogistik.permintaan') }}"
                           class="{{ request()->routeIs('logistik.userlogistik.permintaan') ? 'bg-blue-800 text-white' : 'text-blue-200 hover:bg-blue-700 hover:text-white' }} group flex items-center rounded-md px-2 py-2 text-sm font-medium">
                            <svg class="mr-3 h-5 w-5 flex-shrink-0" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v6m3-3H9m12 0a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            Permintaan
                        </a>
                        <a href="{{ route('logistik.userlogistik.peminjaman') }}"
                           class="{{ request()->routeIs('logistik.userlogistik.peminjaman') ? 'bg-blue-800 text-white' : 'text-blue-200 hover:bg-blue-700 hover:text-white' }} group flex items-center rounded-md px-2 py-2 text-sm font-medium">
                            <svg class="mr-3 h-5 w-5 flex-shrink-0" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M9 8.25H7.5a2.25 2.25 0 00-2.25 2.25v9a2.25 2.25 0 002.25 2.25h9a2.25 2.25 0 002.25-2.25v-9a2.25 2.25 0 00-2.25-2.25H15m0-3l-3-3m0 0l-3 3m3-3v12" />
                            </svg>
                            Peminjaman
                        </a>
                    </div>
                </div>
                <a href="{{ route('logistik.userlogistik.pengembalian') }}"
                   class="{{ request()->routeIs('logistik.userlogistik.pengembalian') ? 'bg-blue-800 text-white' : 'text-blue-200 hover:bg-blue-700 hover:text-white' }} group flex items-center rounded-md px-2 py-2 text-sm font-medium">
                    <svg class="mr-3 h-6 w-6 flex-shrink-0" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75l3 3m0 0l3-3m-3 3v-7.5M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    Pengembalian
                </a>
                <a href="{{ route('logistik.userlogistik.kerusakan') }}"
                    class="{{ request()->routeIs('logistik.userlogistik.kerusakan') ? 'bg-blue-800 text-white' : 'text-blue-200 hover:bg-blue-700 hover:text-white' }} group flex items-center rounded-md px-2 py-2 text-sm font-medium">
                    <svg class="mr-3 h-6 w-6 flex-shrink-0" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126zM12 15.75h.007v.008H12v-.008z" />
                    </svg>
                    Kerusakan
                </a>
                <a href="{{ route('logistik.userlogistik.riwayat') }}"
                   class="{{ request()->routeIs('logistik.userlogistik.riwayat') ? 'bg-blue-800 text-white' : 'text-blue-200 hover:bg-blue-700 hover:text-white' }} group flex items-center rounded-md px-2 py-2 text-sm font-medium">
                    <svg class="mr-3 h-6 w-6 flex-shrink-0" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    Riwayat
                </a>
            @elseif(Auth::user()->role == 'admin hse')
                <a href="{{ route('hse.admin_dashboard') }}"
                    class="{{ request()->routeIs('hse.admin_dashboard') ? 'bg-blue-800 text-white' : 'text-blue-200 hover:bg-blue-700 hover:text-white' }} group flex items-center rounded-md px-2 py-2 text-sm font-medium">
                    <svg class="mr-3 h-6 w-6 flex-shrink-0" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6A2.25 2.25 0 016 3.75h2.25A2.25 2.25 0 0110.5 6v2.25a2.25 2.25 0 01-2.25 2.25H6a2.25 2.25 0 01-2.25-2.25V6zM3.75 15.75A2.25 2.25 0 016 13.5h2.25a2.25 2.25 0 012.25 2.25V18a2.25 2.25 0 01-2.25 2.25H6A2.25 2.25 0 013.75 18v-2.25zM13.5 6a2.25 2.25 0 012.25-2.25H18A2.25 2.25 0 0120.25 6v2.25A2.25 2.25 0 0118 10.5h-2.25a2.25 2.25 0 01-2.25-2.25V6zM13.5 15.75a2.25 2.25 0 012.25-2.25H18a2.25 2.25 0 012.25 2.25V18A2.25 2.25 0 0118 20.25h-2.25A2.25 2.25 0 0113.5 18v-2.25z" />
                    </svg>
                    Dashboard
                </a>
                <a href="{{ route('hse.admin_accidents.index') }}"
                    class="{{ request()->routeIs('hse.admin_accidents.index') ? 'bg-blue-800 text-white' : 'text-blue-200 hover:bg-blue-700 hover:text-white' }} group flex items-center rounded-md px-2 py-2 text-sm font-medium">
                    <svg class="mr-3 h-6 w-6 flex-shrink-0" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126zM12 15.75h.007v.008H12v-.008z" />
                    </svg>
                    Kelola Kecelakaan
                </a>
                <a href="{{ route('hse.admin_playlist.index') }}"
                    class="{{ request()->routeIs('hse.admin_playlist.index') ? 'bg-blue-800 text-white' : 'text-blue-200 hover:bg-blue-700 hover:text-white' }} group flex items-center rounded-md px-2 py-2 text-sm font-medium">
                    <svg class="mr-3 h-6 w-6 flex-shrink-0" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6.75h4.5a3 3 0 013 3v4.5a3 3 0 01-3 3h-4.5a3 3 0 01-3-3v-4.5a3 3 0 013-3z" />
                        <path stroke-linecap="round" stroke-linejoin="round" d="M4.5 6.75h4.5a3 3 0 013 3v4.5a3 3 0 01-3 3h-4.5a3 3 0 01-3-3v-4.5a3 3 0 013-3z" />
                    </svg>
                    Kelola Playlist
                </a>
                <a href="{{ route('hse.admin_substations.index') }}"
                    class="{{ request()->routeIs('hse.admin_substations.index') ? 'bg-blue-800 text-white' : 'text-blue-200 hover:bg-blue-700 hover:text-white' }} group flex items-center rounded-md px-2 py-2 text-sm font-medium">
                    <svg class="mr-3 h-6 w-6 flex-shrink-0" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 10.5a3 3 0 11-6 0 3 3 0 016 0z" />
                        <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 10.5c0 7.142-7.5 11.25-7.5 11.25S4.5 17.642 4.5 10.5a7.5 7.5 0 1115 0z" />
                    </svg>
                    Kelola Gardu Induk
                </a>
            @elseif(Auth::user()->role == 'user hse')
                <a href="{{ route('hse.dashboard') }}"
                    class="{{ request()->routeIs('hse.dashboard') ? 'bg-blue-800 text-white' : 'text-blue-200 hover:bg-blue-700 hover:text-white' }} group flex items-center rounded-md px-2 py-2 text-sm font-medium">
                    <svg class="mr-3 h-6 w-6 flex-shrink-0" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6A2.25 2.25 0 016 3.75h2.25A2.25 2.25 0 0110.5 6v2.25a2.25 2.25 0 01-2.25 2.25H6a2.25 2.25 0 01-2.25-2.25V6zM3.75 15.75A2.25 2.25 0 016 13.5h2.25a2.25 2.25 0 012.25 2.25V18a2.25 2.25 0 01-2.25 2.25H6A2.25 2.25 0 013.75 18v-2.25zM13.5 6a2.25 2.25 0 012.25-2.25H18A2.25 2.25 0 0120.25 6v2.25A2.25 2.25 0 0118 10.5h-2.25a2.25 2.25 0 01-2.25-2.25V6zM13.5 15.75a2.25 2.25 0 012.25-2.25H18a2.25 2.25 0 012.25 2.25V18A2.25 2.25 0 0118 20.25h-2.25A2.25 2.25 0 0113.5 18v-2.25z" />
                    </svg>
                    Dashboard
                </a>
            @endif
        @endif
    </nav>

    <!-- Logout Button -->
    <div class="mt-auto p-2">
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" class="group flex items-center rounded-md px-2 py-2 text-sm font-medium text-blue-200 hover:bg-blue-700 hover:text-white w-full">
                <svg class="mr-3 h-6 w-6 flex-shrink-0" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 9V5.25A2.25 2.25 0 0013.5 3h-6a2.25 2.25 0 00-2.25 2.25v13.5A2.25 2.25 0 007.5 21h6a2.25 2.25 0 002.25-2.25V15M12 9l-3 3m0 0l3 3m-3-3h12.75" />
                </svg>
                Logout
            </button>
        </form>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const toggleBtn = document.getElementById('peminjaman-toggle');
        const submenu = document.getElementById('peminjaman-submenu');
        const arrow = document.getElementById('peminjaman-arrow');
        const isPemesananActive = {{ request()->routeIs(['logistik.userlogistik.peminjaman', 'logistik.userlogistik.permintaan']) ? 'true' : 'false' }};

        if (isPemesananActive) {
            if(submenu) {
                submenu.classList.remove('hidden');
            }
            if(arrow) {
                arrow.classList.add('rotate-180');
            }
        }

        if (toggleBtn) {
            toggleBtn.addEventListener('click', function() {
                submenu.classList.toggle('hidden');
                arrow.classList.toggle('rotate-180');
            });
        }
    });
</script>
