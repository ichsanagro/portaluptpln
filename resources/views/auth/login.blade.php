<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full bg-gray-100">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Login - Portal UPT PLN</title>
    @vite('resources/css/app.css')
</head>
<body class="h-full font-sans text-gray-900 antialiased">
    <div class="flex min-h-full flex-col items-center justify-center px-6 py-12 lg:px-8">
        <div class="w-full max-w-md space-y-8">
            {{-- Logo and Title --}}
            <div class="flex flex-col items-center text-center">
                <svg class="h-12 w-auto text-blue-800" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="m3.75 13.5 10.5-11.25L12 10.5h8.25L9.75 21.75 12 13.5H3.75Z" />
                </svg>
                <h1 class="mt-4 text-3xl font-bold tracking-tight text-blue-800">
                    Selamat Datang
                </h1>
                <p class="mt-2 text-base text-gray-700">
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
                        <div class="mt-2 relative">
                            <x-text-input
                                id="password"
                                name="password"
                                type="password"
                                autocomplete="current-password"
                                required
                                placeholder="••••••••"
                                class="pr-10" {{-- Add padding to the right for the icon --}}
                            />
                            <div id="toggle-password" class="absolute inset-y-0 right-0 pr-3 flex items-center cursor-pointer">
                                <svg id="icon-eye" class="h-5 w-5 text-gray-400" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                  <path d="M2 12s3-7 10-7 10 7 10 7-3 7-10 7-10-7-10-7Z"/>
                                  <circle cx="12" cy="12" r="3"/>
                                </svg>
                                <svg id="icon-eye-slash" class="h-5 w-5 text-gray-400 hidden" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <path d="M9.88 9.88a3 3 0 1 0 4.24 4.24"/>
                                    <path d="M10.73 5.08A10.43 10.43 0 0 1 12 5c7 0 10 7 10 7a13.16 13.16 0 0 1-1.67 2.68"/>
                                    <path d="M6.61 6.61A13.526 13.526 0 0 0 2 12s3 7 10 7a9.74 9.74 0 0 0 5.39-1.61"/>
                                    <line x1="2" x2="22" y1="2" y2="22"/>
                                </svg>
                            </div>
                        </div>
                    </div>

                    {{-- Remember Me & Forgot Password --}}
                    <div class="flex items-center justify-between">
                        <div class="flex items-center">
                            <input id="remember-me" name="remember-me" type="checkbox" class="h-4 w-4 rounded border-gray-300 text-blue-800 focus:ring-yellow-500">
                            <label for="remember-me" class="ml-2 block text-gray-900">Ingat Saya</label>
                        </div>
                        <div class="text-sm">
                            <p class="font-semibold text-blue-800 hover:text-blue-700">Lupa kata sandi? Hubungi admin</p>
                        </div>
                    </div>

                    {{-- Submit Button --}}
                    <div>
                        <x-primary-button>
                            Masuk
                        </x-primary-button>
                    </div>
                </form>

                
            </x-card>
        </div>
    </div>

<script>
    document.getElementById('toggle-password').addEventListener('click', function() {
        const passwordInput = document.getElementById('password');
        const iconEye = document.getElementById('icon-eye');
        const iconEyeSlash = document.getElementById('icon-eye-slash');

        if (passwordInput.type === 'password') {
            passwordInput.type = 'text';
            iconEye.classList.add('hidden');
            iconEyeSlash.classList.remove('hidden');
        } else {
            passwordInput.type = 'password';
            iconEye.classList.remove('hidden');
            iconEyeSlash.classList.add('hidden');
        }
    });
</script>
</body>
</html>
