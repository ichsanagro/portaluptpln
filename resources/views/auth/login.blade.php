<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Portal UPT PLN</title>
    
    <!-- Bootstrap 5.3 CSS CDN -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    
    <!-- Bootstrap Icons CDN -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    
    <!-- Google Fonts: Poppins -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&display=swap" rel="stylesheet">

    <style>
        /* Custom CSS for PLN Corporate Branding */
        :root {
            --pln-blue: #00549B;
            --pln-yellow: #FFD200;
            --light-gray: #f8f9fa;
        }

        body {
            font-family: 'Poppins', sans-serif;
            background-color: var(--pln-blue); /* Background biru PLN */
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            margin: 0;
        }

        .login-card {
            background-color: #ffffff;
            border-radius: 0.75rem;
            box-shadow: 0 8px 24px rgba(0,0,0,.15);
            padding: 2.5rem;
            width: 100%;
            max-width: 450px;
            text-align: center;
        }

        .login-card .card-title {
            color: var(--pln-blue);
            font-weight: 700;
            margin-bottom: 2rem;
            font-size: 1.8rem;
        }

        .form-control:focus {
            border-color: var(--pln-blue);
            box-shadow: 0 0 0 0.25rem rgba(0, 84, 155, 0.25); /* PLN Blue with opacity */
        }

        .btn-pln {
            background-color: var(--pln-blue);
            color: #ffffff;
            border-radius: 50px;
            padding: 0.75rem 1.5rem;
            font-weight: 600;
            border: 2px solid var(--pln-blue);
            transition: background-color 0.3s, color 0.3s;
            width: 100%;
        }

        .btn-pln:hover {
            background-color: #004a89;
            color: #ffffff;
            border-color: #004a89;
        }
        
        .text-pln-blue {
            color: var(--pln-blue);
        }

        .link-pln {
            color: var(--pln-blue);
            text-decoration: none;
            font-weight: 600;
        }

        .link-pln:hover {
            color: var(--pln-yellow);
            text-decoration: underline;
        }

        .logo-pln {
            font-size: 3rem;
            color: var(--pln-blue);
            margin-bottom: 1rem;
        }
    </style>
</head>
<body>

    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-10">
                <div class="login-card">
                    <i class="bi bi-lightning-charge-fill logo-pln"></i>
                    <h1 class="card-title">Selamat Datang di Portal UPT PLN</h1>
                    <p class="text-muted mb-4">Silakan masuk untuk melanjutkan.</p>

                    <form action="{{ route('login.attempt') }}" method="POST">
                        @csrf
                        @if ($errors->any())
                            <div class="alert alert-danger mb-4">
                                <ul>
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif
                        <div class="mb-3">
                            <input type="email" class="form-control form-control-lg @error('email') is-invalid @enderror" id="email" name="email" placeholder="Email atau Username" required autofocus value="{{ old('email') }}">
                            @error('email')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class="mb-4">
                            <input type="password" class="form-control form-control-lg @error('password') is-invalid @enderror" id="password" name="password" placeholder="Kata Sandi" required>
                            @error('password')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class="d-grid gap-2 mb-4">
                            <button type="submit" class="btn btn-pln btn-lg">Masuk</button>
                        </div>
                        <div class="d-flex justify-content-between align-items-center mb-4">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" value="" id="rememberMe">
                                <label class="form-check-label" for="rememberMe">
                                    Ingat Saya
                                </label>
                            </div>
                            <a href="#" class="link-pln">Lupa Kata Sandi?</a>
                        </div>
                        <hr class="my-4">
                        <p class="mb-0">Belum punya akun? <a href="#" class="link-pln">Daftar Sekarang</a></p>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap 5.3 JS Bundle CDN -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>
</html>
