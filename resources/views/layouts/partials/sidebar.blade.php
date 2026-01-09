<div class="flex h-screen w-64 flex-col bg-blue-900 text-white">
    <!-- Sidebar Header -->
    <div class="flex h-16 flex-shrink-0 items-center border-b border-blue-700 px-4">
        @if(request()->routeIs('logistik.adminlogistik.*'))
            <a href="{{ route('logistik.adminlogistik.dashboard') }}" class="flex items-center gap-2">
        @elseif(request()->routeIs('logistik.userlogistik.*'))
            <a href="{{ route('logistik.userlogistik.dashboard') }}" class="flex items-center gap-2">
        @else
            <a href="/" class="flex items-center gap-2">
        @endif
            <svg class="h-8 w-auto text-yellow-400" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" d="m3.75 13.5 10.5-11.25L12 10.5h8.25L9.75 21.75 12 13.5H3.75Z" />
            </svg>
            <span class="text-xl font-semibold">UPT PLN</span>
        </a>
    </div>

    <!-- Navigation Links -->
    <nav class="flex-1 space-y-1 overflow-y-auto p-2">
        @if(request()->routeIs('logistik.adminlogistik.*'))
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
            <a href="{{ route('logistik.adminlogistik.permintaan') }}"
               class="{{ request()->routeIs('logistik.adminlogistik.permintaan') ? 'bg-blue-800 text-white' : 'text-blue-200 hover:bg-blue-700 hover:text-white' }} group flex items-center rounded-md px-2 py-2 text-sm font-medium">
                <svg class="mr-3 h-6 w-6 flex-shrink-0" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 12h3.75M9 15h3.75M9 18h3.75m3 .75H18a2.25 2.25 0 002.25-2.25V6.108c0-1.135-.845-2.098-1.976-2.192a48.424 48.424 0 00-1.123-.08m-5.801 0c-.065.21-.1.433-.1.664 0 .414.336.75.75.75h4.5a.75.75 0 00.75-.75v-.664m2.553-4.575A48.47 48.47 0 007.5 4.5c-2.18 0-4.205.533-5.976 1.442" />
                </svg>
                Permintaan
            </a>
        @elseif(request()->routeIs('logistik.userlogistik.*'))
            <a href="{{ route('logistik.userlogistik.dashboard') }}"
               class="{{ request()->routeIs('logistik.userlogistik.dashboard') ? 'bg-blue-800 text-white' : 'text-blue-200 hover:bg-blue-700 hover:text-white' }} group flex items-center rounded-md px-2 py-2 text-sm font-medium">
                <svg class="mr-3 h-6 w-6 flex-shrink-0" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6A2.25 2.25 0 016 3.75h2.25A2.25 2.25 0 0110.5 6v2.25a2.25 2.25 0 01-2.25 2.25H6a2.25 2.25 0 01-2.25-2.25V6zM3.75 15.75A2.25 2.25 0 016 13.5h2.25a2.25 2.25 0 012.25 2.25V18a2.25 2.25 0 01-2.25 2.25H6A2.25 2.25 0 013.75 18v-2.25zM13.5 6a2.25 2.25 0 012.25-2.25H18A2.25 2.25 0 0120.25 6v2.25A2.25 2.25 0 0118 10.5h-2.25a2.25 2.25 0 01-2.25-2.25V6zM13.5 15.75a2.25 2.25 0 012.25-2.25H18a2.25 2.25 0 012.25 2.25V18A2.25 2.25 0 0118 20.25h-2.25A2.25 2.25 0 0113.5 18v-2.25z" />
                </svg>
                Dashboard
            </a>
            <a href="{{ route('logistik.userlogistik.peminjaman') }}"
               class="{{ request()->routeIs('logistik.userlogistik.peminjaman') ? 'bg-blue-800 text-white' : 'text-blue-200 hover:bg-blue-700 hover:text-white' }} group flex items-center rounded-md px-2 py-2 text-sm font-medium">
                <svg class="mr-3 h-6 w-6 flex-shrink-0" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 00-3.375-3.375h-1.5A1.125 1.125 0 0113.5 7.125v-1.5a3.375 3.375 0 00-3.375-3.375H8.25m0 12.75h.008v.008H8.25zm0-8.25h.008v.008H8.25zM12 18h.008v.008H12zm-3.75 4.5V16.5a3.75 3.75 0 013.75-3.75h1.5A1.125 1.125 0 0116.5 13.5v1.5a3.75 3.75 0 01-3.75 3.75H12m-3.75-4.5H12m0-3h.008v.008H12z" />
                </svg>
                Peminjaman
            </a>
            <a href="{{ route('logistik.userlogistik.pengembalian') }}"
               class="{{ request()->routeIs('logistik.userlogistik.pengembalian') ? 'bg-blue-800 text-white' : 'text-blue-200 hover:bg-blue-700 hover:text-white' }} group flex items-center rounded-md px-2 py-2 text-sm font-medium">
                <svg class="mr-3 h-6 w-6 flex-shrink-0" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 12h3.75M9 15h3.75M9 18h3.75m3 .75H18a2.25 2.25 0 002.25-2.25V6.108c0-1.135-.845-2.098-1.976-2.192a48.424 48.424 0 00-1.123-.08m-5.801 0c-.065.21-.1.433-.1.664 0 .414.336.75.75.75h4.5a.75.75 0 00.75-.75v-.664m2.553-4.575A48.47 48.47 0 007.5 4.5c-2.18 0-4.205.533-5.976 1.442" />
                </svg>
                Pengembalian
            </a>
        @endif
    </nav>

    <!-- Logout Button -->
    <div class="mt-auto p-2">
        <a href="/ " class="group flex items-center rounded-md px-2 py-2 text-sm font-medium text-blue-200 hover:bg-blue-700 hover:text-white">
            <svg class="mr-3 h-6 w-6 flex-shrink-0" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 9V5.25A2.25 2.25 0 0013.5 3h-6a2.25 2.25 0 00-2.25 2.25v13.5A2.25 2.25 0 007.5 21h6a2.25 2.25 0 002.25-2.25V15M12 9l-3 3m0 0l3 3m-3-3h12.75" />
            </svg>
            Logout
        </a>
    </div>
</div>