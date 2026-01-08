<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Portal UPT PLN</title>
    @vite('resources/css/app.css')
</head>
<body class="bg-slate-50 font-sans text-slate-900 antialiased">

    <!-- Header -->
    <header class="bg-white/80 fixed left-0 top-0 z-50 w-full backdrop-blur-lg">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            <div class="flex h-16 items-center justify-between">
                <div class="flex items-center gap-2">
                    <svg class="h-8 w-auto text-blue-600" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="m3.75 13.5 10.5-11.25L12 10.5h8.25L9.75 21.75 12 13.5H3.75Z" />
                    </svg>
                    <span class="text-xl font-bold tracking-tighter text-slate-900">PORTAL UPT PLN</span>
                </div>
                <div class="flex items-center gap-4">
                    <a href="{{ route('login') }}" class="rounded-md bg-blue-600 px-4 py-2 text-sm font-semibold text-white shadow-sm hover:bg-blue-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-blue-600">
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
                    <h1 class="text-4xl font-bold tracking-tight text-slate-900 sm:text-6xl">
                        Portal Digital Terintegrasi UPT PLN
                    </h1>
                    <p class="mt-6 text-lg leading-8 text-slate-600">
                        Pusat layanan digital untuk mendukung kinerja dan operasional seluruh karyawan UPT PLN secara efisien, modern, dan andal.
                    </p>
                </div>
            </div>
        </section>

        <!-- Features Section -->
        <section class="bg-slate-50 py-20 sm:py-28">
            <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
                <div class="mx-auto max-w-2xl text-center">
                    <h2 class="text-3xl font-bold tracking-tight text-slate-900 sm:text-4xl">Sistem Utama</h2>
                    <p class="mt-4 text-lg text-slate-600">
                        Akses sistem utama yang Anda butuhkan untuk menunjang pekerjaan sehari-hari.
                    </p>
                </div>
                <div class="mx-auto mt-16 grid max-w-lg gap-8 lg:max-w-none lg:grid-cols-2">
                    <!-- Card 1: Sistem Logistik -->
                    <div class="flex flex-col overflow-hidden rounded-xl bg-white shadow-lg transition-all duration-300 hover:-translate-y-1 hover:shadow-2xl">
                        <div class="flex flex-1 flex-col justify-between p-8">
                            <div class="flex-1">
                                <div class="mb-4 flex h-12 w-12 items-center justify-center rounded-lg bg-blue-100 text-blue-600">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="h-7 w-7">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M8.25 7.5l.415-.207a.75.75 0 011.085.67V10.5m0 0h6m-6 0a.75.75 0 00-1.085.67l-.416-.207a.75.75 0 01-1.085-.67V7.5m-4.5 4.5v.75A.75.75 0 005.25 12h13.5a.75.75 0 00.75-.75v-.75m-15 4.5v.75a.75.75 0 00.75.75h13.5a.75.75 0 00.75-.75v-.75" />
                                    </svg>
                                </div>
                                <h3 class="text-xl font-semibold text-slate-900">Sistem Logistik</h3>
                                <p class="mt-3 text-base text-slate-500">
                                    Manajemen stok, pemantauan aset, dan pengelolaan gudang secara efisien dan terpusat.
                                </p>
                            </div>
                            <div class="mt-6">
                                <a href="{{ route('login') }}" class="w-full rounded-md bg-slate-800 px-5 py-3 text-center font-semibold text-white shadow-sm hover:bg-slate-700 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-slate-800">
                                    Masuk Sistem Logistik
                                </a>
                            </div>
                        </div>
                    </div>

                    <!-- Card 2: Sistem HSE -->
                    <div class="flex flex-col overflow-hidden rounded-xl bg-white shadow-lg transition-all duration-300 hover:-translate-y-1 hover:shadow-2xl">
                        <div class="flex flex-1 flex-col justify-between p-8">
                            <div class="flex-1">
                                <div class="mb-4 flex h-12 w-12 items-center justify-center rounded-lg bg-blue-100 text-blue-600">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="h-7 w-7">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0Z" />
                                    </svg>
                                </div>
                                <h3 class="text-xl font-semibold text-slate-900">Sistem HSE</h3>
                                <p class="mt-3 text-base text-slate-500">
                                    Pelaporan insiden, pemantauan K2/K3, dan pemenuhan standar keselamatan kerja.
                                </p>
                            </div>
                            <div class="mt-6">
                                <a href="{{ route('login') }}" class="w-full rounded-md bg-slate-800 px-5 py-3 text-center font-semibold text-white shadow-sm hover:bg-slate-700 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-slate-800">
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
            <p class="text-center text-sm leading-5 text-slate-500">
                &copy; {{ date('Y') }} - PT PLN (Persero). All Rights Reserved.
            </p>
        </div>
    </footer>

</body>
</html>
