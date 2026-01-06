<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Portal UPT PLN</title>
    
    <!-- Bootstrap 5.3 CSS CDN -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    
    <!-- Bootstrap Icons CDN -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    
    <!-- Google Fonts: Poppins for a modern look -->
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
            background-color: var(--light-gray);
        }

        .navbar-pln {
            background-color: var(--pln-blue);
            box-shadow: 0 2px 4px rgba(0,0,0,.1);
        }

        .navbar-pln .navbar-brand {
            font-weight: 700;
            color: #fff;
        }
        
        .navbar-pln .navbar-brand:hover {
            color: var(--pln-yellow);
        }

        .hero-section {
            padding: 6rem 0;
            background-color: #ffffff;
        }

        .hero-section .display-5 {
            color: var(--pln-blue);
            font-weight: 700;
        }

        .hero-section .lead {
            color: #6c757d;
        }

        .interactive-card {
            border: none;
            border-radius: 0.75rem;
            box-shadow: 0 4px 12px rgba(0,0,0,.08);
            transition: transform 0.3s ease, box-shadow 0.3s ease;
            height: 100%;
        }

        .interactive-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 8px 24px rgba(0,0,0,.12);
        }

        .card-icon {
            font-size: 4rem;
            color: var(--pln-blue);
            margin-bottom: 1rem;
        }
        
        .card-title {
            color: var(--pln-blue);
            font-weight: 600;
        }

        .btn-pln {
            background-color: var(--pln-blue);
            color: #ffffff;
            border-radius: 50px;
            padding: 0.75rem 1.5rem;
            font-weight: 600;
            border: 2px solid var(--pln-blue);
            transition: background-color 0.3s, color 0.3s;
        }

        .btn-pln:hover {
            background-color: #004a89;
            color: #ffffff;
            border-color: #004a89;
        }

        .btn-pln-secondary {
            background-color: var(--pln-yellow);
            color: var(--pln-blue);
            border-radius: 50px;
            padding: 0.75rem 1.5rem;
            font-weight: 600;
            border: 2px solid var(--pln-yellow);
            transition: background-color 0.3s, color 0.3s;
        }

        .btn-pln-secondary:hover {
            background-color: #e6bb00;
            color: var(--pln-blue);
            border-color: #e6bb00;
        }
        
        .footer {
            background-color: #ffffff;
            padding: 2rem 0;
            margin-top: 4rem;
            font-size: 0.9rem;
            color: #6c757d;
        }

    </style>
</head>
<body>

    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-pln navbar-dark">
        <div class="container">
            <a class="navbar-brand" href="#">
                <!-- You can replace this text with an <img> tag for the actual logo -->
                <i class="bi bi-lightning-charge-fill"></i>
                PORTAL UPT PLN
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            {{-- <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link active" aria-current="page" href="#">Beranda</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">Profil</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">Bantuan</a>
                    </li>
                </ul>
            </div> --}}
        </div>
    </nav>

    <!-- Hero Section -->
    <header class="hero-section">
        <div class="container text-center">
            <h1 class="display-5">Portal Digital UPT PLN</h1>
            <p class="lead col-lg-8 mx-auto">Selamat datang di pusat layanan digital terintegrasi untuk mendukung kinerja dan operasional seluruh karyawan UPT PLN.</p>
        </div>
    </header>

    <!-- Main Systems Section -->
    <main class="container mt-5">
        <div class="row g-4 justify-content-center">
            
            <!-- Card 1: Sistem Logistik -->
            <div class="col-lg-5 col-md-6">
                <div class="card interactive-card text-center p-4">
                    <div class="card-body">
                        <i class="bi bi-box-seam card-icon"></i>
                        <h3 class="card-title">Sistem Logistik</h3>
                        <p class="card-text text-muted">Manajemen stok, pemantauan aset, dan pengelolaan gudang secara efisien dan terpusat.</p>
                        <a href="{{ route('login') }}" class="btn btn-pln mt-3">Masuk Sistem</a>
                    </div>
                </div>
            </div>

            <!-- Card 2: Sistem HSE -->
            <div class="col-lg-5 col-md-6">
                <div class="card interactive-card text-center p-4">
                    <div class="card-body">
                        <i class="bi bi-shield-check card-icon"></i>
                        <h3 class="card-title">Sistem HSE</h3>
                        <p class="card-text text-muted">Pelaporan insiden, pemantauan K2/K3, dan pemenuhan standar keselamatan kerja.</p>
                        <a href="{{ route('login') }}" class="btn btn-pln mt-3">Masuk Sistem</a>
                    </div>
                </div>
            </div>

        </div>
    </main>
    
    <!-- Footer -->
    <footer class="footer text-center">
        <div class="container">
            <span>&copy; 2026 - PT PLN (Persero). All Rights Reserved.</span>
        </div>
    </footer>

    <!-- Bootstrap 5.3 JS Bundle CDN -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>
</html>
