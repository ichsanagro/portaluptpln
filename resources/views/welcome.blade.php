<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Portal UPT PLN</title>
    @vite('resources/css/app.css')
</head>
<body class="bg-gray-100 font-sans text-gray-900 antialiased">

    <!-- Header -->
    <header class="bg-white/80 fixed left-0 top-0 z-50 w-full backdrop-blur-lg">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            <div class="flex h-16 items-center justify-between">
                <div class="flex items-center gap-2">
                    <svg class="h-8 w-auto text-blue-800" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="m3.75 13.5 10.5-11.25L12 10.5h8.25L9.75 21.75 12 13.5H3.75Z" />
                    </svg>
                    <span class="text-xl font-bold tracking-tighter text-blue-800">PORTAL UPT PLN</span>
                </div>
                <div class="flex items-center gap-4">
                    <a href="{{ route('login') }}" class="rounded-md bg-blue-800 px-4 py-2 text-sm font-semibold text-white shadow-sm hover:bg-blue-700 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-yellow-500">
                        Masuk
                    </a>
                </div>
            </div>
        </div>
    </header>

    <main>
        <!-- Hero Section -->
        <section class="relative bg-white pt-32 pb-20 lg:pt-40 lg:pb-28">
            <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
                <div class="mx-auto max-w-3xl text-center">
                    <h1 class="text-4xl font-bold tracking-tight text-blue-800 sm:text-6xl">
                        Portal Digital Terintegrasi UPT PLN
                    </h1>
                    <p class="mt-6 text-lg leading-8 text-gray-700">
                        Pusat layanan digital untuk mendukung kinerja dan operasional seluruh karyawan UPT PLN secara efisien, modern, dan Andal.
                    </p>
                </div>
            </div>
        </section>

        <!-- Features Section -->
        <section class="bg-gray-100 py-20 sm:py-28">
            <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
                <div class="mx-auto max-w-2xl text-center">
                    <h2 class="text-3xl font-bold tracking-tight text-blue-800 sm:text-4xl">Sistem Utama</h2>
                    <p class="mt-4 text-lg text-gray-700">
                        Akses sistem utama yang Anda butuhkan untuk menunjang pekerjaan sehari-hari.
                    </p>
                </div>
                <div class="mx-auto mt-16 grid max-w-lg gap-8 lg:max-w-none lg:grid-cols-2">
                    <!-- Card 1: Sistem Logistik -->
                    <div class="flex flex-col overflow-hidden rounded-xl bg-white shadow-lg transition-all duration-300 hover:-translate-y-1 hover:shadow-2xl">
                        <div class="flex flex-1 flex-col justify-between p-8">
                            <div class="flex-1">
                                <div class="mb-4 flex h-12 w-12 items-center justify-center rounded-lg bg-blue-100 text-blue-800">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" fill="currentColor" class="bi bi-box" viewBox="0 0 16 16">
                                    <path d="M8.186 1.113a.5.5 0 0 0-.372 0L1.846 3.5 8 5.961 14.154 3.5zM15 4.239l-6.5 2.6v7.922l6.5-2.6V4.24zM7.5 14.762V6.838L1 4.239v7.923zM7.443.184a1.5 1.5 0 0 1 1.114 0l7.129 2.852A.5.5 0 0 1 16 3.5v8.662a1 1 0 0 1-.629.928l-7.185 2.874a.5.5 0 0 1-.372 0L.63 13.09a1 1 0 0 1-.63-.928V3.5a.5.5 0 0 1 .314-.464z"/>
                                    </svg>
                                </div>
                                <h3 class="text-xl font-semibold text-blue-800">Sistem Logistik</h3>
                                <p class="mt-3 text-base text-gray-700">
                                    Manajemen stok, pemantauan aset, dan pengelolaan gudang secara efisien dan terpusat.
                                </p>
                            </div>
                            <div class="mt-6">
                                <a href="{{ route('login') }}" class="w-full rounded-md bg-blue-800 px-5 py-3 text-center font-semibold text-white shadow-sm hover:bg-blue-700 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-yellow-500">
                                    Masuk Sistem Logistik
                                </a>
                            </div>
                        </div>
                    </div>

                    <!-- Card 2: Sistem HSE -->
                    <div class="flex flex-col overflow-hidden rounded-xl bg-white shadow-lg transition-all duration-300 hover:-translate-y-1 hover:shadow-2xl">
                        <div class="flex flex-1 flex-col justify-between p-8">
                            <div class="flex-1">
                                <div class="mb-4 flex h-12 w-12 items-center justify-center rounded-lg bg-blue-100 text-blue-800">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" fill="currentColor" class="bi bi-gear-wide" viewBox="0 0 16 16">
                                    <path d="M8.932.727c-.243-.97-1.62-.97-1.864 0l-.071.286a.96.96 0 0 1-1.622.434l-.205-.211c-.695-.719-1.888-.03-1.613.931l.08.284a.96.96 0 0 1-1.186 1.187l-.284-.081c-.96-.275-1.65.918-.931 1.613l.211.205a.96.96 0 0 1-.434 1.622l-.286.071c-.97.243-.97 1.62 0 1.864l.286.071a.96.96 0 0 1 .434 1.622l-.211.205c-.719.695-.03 1.888.931 1.613l.284-.08a.96.96 0 0 1 1.187 1.187l-.081.283c-.275.96.918 1.65 1.613.931l.205-.211a.96.96 0 0 1 1.622.434l.071.286c.243.97 1.62.97 1.864 0l.071-.286a.96.96 0 0 1 1.622-.434l.205.211c.695.719 1.888.03 1.613-.931l-.08-.284a.96.96 0 0 1 1.187-1.187l.283.081c.96.275 1.65-.918.931-1.613l-.211-.205a.96.96 0 0 1 .434-1.622l.286-.071c.97-.243.97-1.62 0-1.864l-.286-.071a.96.96 0 0 1-.434-1.622l.211-.205c.719-.695.03-1.888-.931-1.613l-.284.08a.96.96 0 0 1-1.187-1.186l.081-.284c.275-.96-.918-1.65-1.613-.931l-.205.211a.96.96 0 0 1-1.622-.434zM8 12.997a4.998 4.998 0 1 1 0-9.995 4.998 4.998 0 0 1 0 9.996z"/>
                                    </svg>
                                </div>
                                <h3 class="text-xl font-semibold text-blue-800">Sistem HSE</h3>
                                <p class="mt-3 text-base text-gray-700">
                                    Pelaporan insiden, pemantauan K2/K3, dan pemenuhan standar keselamatan kerja.
                                </p>
                            </div>
                            <div class="mt-6">
                                <a href="{{ route('login') }}" class="w-full rounded-md bg-blue-800 px-5 py-3 text-center font-semibold text-white shadow-sm hover:bg-blue-700 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-yellow-500">
                                    Masuk Sistem HSE
                                </a>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </section>
    </main>

    <!-- Footer -->
    <footer class="bg-white">
        <div class="mx-auto max-w-7xl px-4 py-6 sm:px-6 lg:px-8">
            <p class="text-center text-sm leading-5 text-gray-700">
                &copy; {{ date('Y') }} - PT PLN (Persero). All Rights Reserved.
            </p>
        </div>
    </footer>

</body>
</html>
