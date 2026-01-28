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
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 16 16" stroke="currentColor" class="h-6 w-6">
                                      <path stroke-linecap="round" stroke-linejoin="round" d="M8.186 1.113a.5.5 0 0 0-.372 0L1.846 3.5 8 5.961 14.154 3.5zM15 4.239l-6.5 2.6v7.922l6.5-2.6V4.24zM7.5 14.762V6.838L1 4.239v7.923zM7.443.184a1.5 1.5 0 0 1 1.114 0l7.129 2.852A.5.5 0 0 1 16 3.5v8.662a1 1 0 0 1-.629.928l-7.185 2.874a.5.5 0 0 1-.372 0L.63 13.09a1 1 0 0 1-.63-.928V3.5a.5.5 0 0 1 .314-.464z" />
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
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 16 16"  stroke="currentColor" class="h-6 w-6">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M5.338 1.59a61 61 0 0 0-2.837.856.48.48 0 0 0-.328.39c-.554 4.157.726 7.19 2.253 9.188a10.7 10.7 0 0 0 2.287 2.233c.346.244.652.42.893.533q.18.085.293.118a1 1 0 0 0 .101.025 1 1 0 0 0 .1-.025q.114-.034.294-.118c.24-.113.547-.29.893-.533a10.7 10.7 0 0 0 2.287-2.233c1.527-1.997 2.807-5.031 2.253-9.188a.48.48 0 0 0-.328-.39c-.651-.213-1.75-.56-2.837-.855C9.552 1.29 8.531 1.067 8 1.067c-.53 0-1.552.223-2.662.524zM5.072.56C6.157.265 7.31 0 8 0s1.843.265 2.928.56c1.11.3 2.229.655 2.887.87a1.54 1.54 0 0 1 1.044 1.262c.596 4.477-.787 7.795-2.465 9.99a11.8 11.8 0 0 1-2.517 2.453 7 7 0 0 1-1.048.625c-.28.132-.581.24-.829.24s-.548-.108-.829-.24a7 7 0 0 1-1.048-.625 11.8 11.8 0 0 1-2.517-2.453C1.928 10.487.545 7.169 1.141 2.692A1.54 1.54 0 0 1 2.185 1.43 63 63 0 0 1 5.072.56" />
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
