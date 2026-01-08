<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full bg-slate-50">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Login - Portal UPT PLN</title>
    @vite('resources/css/app.css')
</head>
<body class="h-full font-sans text-slate-900 antialiased">
    <div class="flex min-h-full flex-col items-center justify-center px-6 py-12 lg:px-8">
        <div class="w-full max-w-md space-y-8">
            {{-- Logo and Title --}}
            <div class="flex flex-col items-center text-center">
                <svg class="h-12 w-auto text-blue-600" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="m3.75 13.5 10.5-11.25L12 10.5h8.25L9.75 21.75 12 13.5H3.75Z" />
                </svg>
                <h1 class="mt-4 text-3xl font-bold tracking-tight text-slate-900">
                    Selamat Datang
                </h1>
                <p class="mt-2 text-base text-slate-600">
                    Masuk ke Portal UPT PLN untuk melanjutkan.
                </p>
            </div>

            {{-- Login Card --}}
            <x-card class="p-8">
                <form action="{{ route('login.attempt') }}" method="POST" class="space-y-6">
                    @csrf

                    {{-- General Error Messages --}}
                    @if ($errors->any())
                        <div class="rounded-md bg-red-50 p-4">
                            <div class="flex">
                                <div class="ml-3">
                                    <h3 class="text-sm font-medium text-red-800">Terdapat beberapa kesalahan:</h3>
                                    <div class="mt-2 text-sm text-red-700">
                                        <ul role="list" class="list-disc space-y-1 pl-5">
                                            @foreach ($errors->all() as $error)
                                                <li>{{ $error }}</li>
                                            @endforeach
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif

                    {{-- Email Input --}}
                    <div>
                        <x-input-label for="email" value="Alamat Email" />
                        <div class="mt-2">
                            <x-text-input
                                id="email"
                                name="email"
                                type="email"
                                autocomplete="email"
                                required
                                value="{{ old('email') }}"
                                placeholder="anda@email.com"
                            />
                        </div>
                    </div>

                    {{-- Password Input --}}
                    <div>
                        <x-input-label for="password" value="Kata Sandi" />
                        <div class="mt-2">
                            <x-text-input
                                id="password"
                                name="password"
                                type="password"
                                autocomplete="current-password"
                                required
                                placeholder="••••••••"
                            />
                        </div>
                    </div>

                    {{-- Remember Me & Forgot Password --}}
                    <div class="flex items-center justify-between">
                        <div class="flex items-center">
                            <input id="remember-me" name="remember-me" type="checkbox" class="h-4 w-4 rounded border-slate-300 text-blue-600 focus:ring-blue-600">
                            <label for="remember-me" class="ml-2 block text-sm text-slate-900">Ingat Saya</label>
                        </div>
                        <div class="text-sm">
                            <a href="#" class="font-semibold text-blue-600 hover:text-blue-500">Lupa kata sandi?</a>
                        </div>
                    </div>

                    {{-- Submit Button --}}
                    <div>
                        <x-primary-button>
                            Masuk
                        </x-primary-button>
                    </div>
                </form>

                {{-- Sign up Link --}}
                <p class="mt-8 text-center text-sm text-slate-500">
                    Belum punya akun?
                    <a href="#" class="font-semibold leading-6 text-blue-600 hover:text-blue-500">Daftar sekarang</a>
                </p>
            </x-card>
        </div>
    </div>
</body>
</html>
