<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Admin Logistik - Portal UPT PLN</title>

    <!-- Bootstrap 5.3 CSS CDN -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- Bootstrap Icons CDN -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    
    <!-- Google Fonts: Inter -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">

    <style>
        :root {
            --pln-blue: #00549B;
            --pln-yellow: #FFD200;
            --sidebar-width: 280px;
            --light-bg: #f8f9fa; /* Changed to very light gray */
            --text-dark: #212529;
            --text-muted: #6c757d;
        }

        body {
            font-family: 'Inter', sans-serif;
            background-color: var(--light-bg);
            color: var(--text-dark);
        }

        /* Sidebar remains the same */
        .sidebar {
            position: fixed;
            top: 0;
            left: 0;
            height: 100%;
            width: var(--sidebar-width);
            background-color: var(--pln-blue);
            padding: 1.5rem;
            z-index: 1030;
        }
        .sidebar-header {
            text-align: center;
            margin-bottom: 2rem;
        }
        .sidebar-header .logo {
            font-size: 1.5rem;
            font-weight: 700;
            color: #fff;
            text-decoration: none;
        }
        .sidebar-header .logo i {
            color: var(--pln-yellow);
        }
        .sidebar-nav .nav-link {
            color: rgba(255, 255, 255, 0.85);
            padding: 0.85rem 1.25rem;
            border-radius: 0.5rem;
            margin-bottom: 0.5rem;
            display: flex;
            align-items: center;
            font-weight: 500;
            cursor: pointer;
            transition: background-color 0.2s, color 0.2s;
        }
        .sidebar-nav .nav-link i {
            margin-right: 1rem;
            font-size: 1.25rem;
        }
        .sidebar-nav .nav-link:hover {
            background-color: rgba(255, 255, 255, 0.1);
            color: #fff;
        }
        .sidebar-nav .nav-link.active {
            background-color: #fff;
            color: var(--pln-blue);
            font-weight: 600;
        }
        .sidebar-logout {
            position: absolute;
            bottom: 1.5rem;
            width: calc(100% - 3rem);
        }


        /* Main Content Styling */
        .main-content {
            margin-left: var(--sidebar-width);
            padding: 2.5rem;
        }
        
        #page-title {
            font-weight: 700;
            color: var(--text-dark);
        }

        /* Modern Card Design */
        .card-modern {
            background-color: #ffffff;
            border: none;
            border-radius: 15px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.08); /* Soft shadow */
            padding: 2rem; /* Spacious padding */
        }
        .card-modern .card-header-modern {
             padding-bottom: 1.5rem;
             margin-bottom: 1.5rem;
             border-bottom: 1px solid #f0f0f0;
        }

        /* Search Bar & Actions */
        .search-container {
            position: relative;
        }
        .search-container .form-control {
            padding-left: 2.5rem;
            border-radius: 50rem; /* rounded-pill */
            background-color: #f1f3f5;
            border: none;
        }
        .search-container .search-icon {
            position: absolute;
            left: 0.9rem;
            top: 50%;
            transform: translateY(-50%);
            color: var(--text-muted);
        }
        .btn-pln {
            background-color: var(--pln-blue);
            color: #fff;
            border: none;
            font-weight: 600;
            padding: 0.6rem 1.2rem;
            border-radius: .5rem;
        }
        .btn-pln:hover {
            background-color: #004a89;
        }

        /* Modern Table Styling */
        .table-clean {
            border-collapse: collapse;
            width: 100%;
        }
        .table-clean thead th {
            background-color: var(--pln-blue);
            color: #fff;
            font-weight: 600;
            text-align: left;
            padding: 1rem 1.25rem;
            border-bottom: none; /* No border on header */
        }
        /* Round top corners */
        .table-clean thead th:first-child { border-top-left-radius: 10px; }
        .table-clean thead th:last-child { border-top-right-radius: 10px; }

        .table-clean tbody td {
            padding: 1.25rem; /* Extra vertical padding */
            vertical-align: middle;
            border-bottom: 1px solid #f0f0f0; /* Thin border between rows */
        }
        .table-clean tbody tr:last-child td {
            border-bottom: none; /* No border on last row */
        }

        /* Minimalist Action Icons */
        .table-actions button, .table-actions a {
            background: none;
            border: none;
            padding: 0.25rem 0.5rem;
            font-size: 1.1rem;
            text-decoration: none;
            transition: transform 0.2s;
        }
        .table-actions .icon-edit { color: var(--pln-blue); }
        .table-actions .icon-delete { color: var(--text-muted); }
        .table-actions button:hover, .table-actions a:hover {
            transform: scale(1.2);
        }
        .table-actions .icon-delete:hover {
            color: #dc3545;
        }

        /* Pill Badges with transparent BG */
        .badge.pill-status {
            border-radius: 50rem;
            font-weight: 600;
            padding: 0.4em 0.8em;
            font-size: 0.8rem;
        }
        .pill-status.status-waiting {
            background-color: rgba(0, 84, 155, 0.1); /* Light Blue */
            color: var(--pln-blue);
        }
        .pill-status.status-approved {
            background-color: rgba(25, 135, 84, 0.1); /* Light Green */
            color: #198754;
        }

        /* JS Navigation Helpers */
        .dashboard-section { display: none; }
        .dashboard-section.active { display: block; }

        @media (max-width: 991.98px) {
            .sidebar { left: calc(-1 * var(--sidebar-width)); }
            .main-content { margin-left: 0; padding: 1.5rem; }
            .sidebar.active { left: 0; }
        }
    </style>
</head>
<body>
    <!-- Sidebar -->
    <div class="sidebar" id="sidebar">
        <!-- Sidebar content remains same -->
        <div class="sidebar-header">
            <a href="#" class="logo"><i class="bi bi-lightning-charge-fill"></i> UPT PLN</a>
        </div>
        <nav class="sidebar-nav">
            <ul class="nav flex-column">
                <li class="nav-item">
                    <a class="nav-link active" data-target="dashboard">
                        <i class="bi bi-grid-fill"></i> Dashboard
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" data-target="kelola-material">
                        <i class="bi bi-box-seam-fill"></i> Kelola Material
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" data-target="permintaan">
                        <i class="bi bi-card-checklist"></i> Permintaan
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" data-target="manajemen-user">
                        <i class="bi bi-people-fill"></i> Manajemen User
                    </a>
                </li>
            </ul>
        </nav>
        <div class="sidebar-logout">
             <a class="nav-link" href="#">
                <i class="bi bi-box-arrow-left"></i> Logout
            </a>
        </div>
    </div>
    
    <!-- Main Content -->
    <div class="main-content">
        <header class="d-flex justify-content-between align-items-center mb-4">
            <h1 class="h2" id="page-title">Dashboard</h1>
            <button class="btn d-lg-none" id="sidebar-toggler"><i class="bi bi-list fs-2"></i></button>
        </header>

        <!-- === Main Dashboard Section (Placeholder) === -->
        <div id="dashboard" class="dashboard-section active">
            <div class="card-modern">
                <h5 class="fw-bold">Selamat Datang, Admin Logistik!</h5>
                <p class="text-muted">Ini adalah halaman utama dashboard Anda. Pilih menu di samping untuk memulai.</p>
            </div>
        </div>

        <!-- === Kelola Material Section === -->
        <div id="kelola-material" class="dashboard-section">
            <div class="card-modern">
                <div class="card-header-modern d-flex flex-wrap justify-content-between align-items-center gap-3">
                    <div class="search-container col-12 col-md-4">
                        <i class="bi bi-search search-icon"></i>
                        <input type="text" class="form-control" placeholder="Cari material...">
                    </div>
                    <button class="btn btn-pln"><i class="bi bi-plus-circle me-2"></i>Tambah Material</button>
                </div>
                <div class="table-responsive">
                    <table class="table-clean">
                        <thead>
                            <tr>
                                <th>Kode</th>
                                <th>Nama Material</th>
                                <th>Kategori</th>
                                <th>Stok</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td><strong>KBL-001</strong></td>
                                <td>Kabel NYY 4x16mm</td>
                                <td>Kabel</td>
                                <td>1500 Meter</td>
                                <td class="table-actions">
                                    <button class="icon-edit"><i class="bi bi-pencil-square"></i></button>
                                    <button class="icon-delete"><i class="bi bi-trash-fill"></i></button>
                                </td>
                            </tr>
                            <tr>
                                <td><strong>TRF-003</strong></td>
                                <td>Trafo 250 kVA</td>
                                <td>Transformator</td>
                                <td>8 Unit</td>
                                <td class="table-actions">
                                    <button class="icon-edit"><i class="bi bi-pencil-square"></i></button>
                                    <button class="icon-delete"><i class="bi bi-trash-fill"></i></button>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- === Permintaan Material Section === -->
        <div id="permintaan" class="dashboard-section">
            <div class="card-modern">
                 <div class="card-header-modern d-flex flex-wrap justify-content-between align-items-center gap-3">
                    <div class="search-container col-12 col-md-4">
                        <i class="bi bi-search search-icon"></i>
                        <input type="text" class="form-control" placeholder="Cari permintaan...">
                    </div>
                 </div>
                <div class="table-responsive">
                    <table class="table-clean">
                        <thead>
                            <tr>
                                <th>Tanggal</th>
                                <th>User</th>
                                <th>Material</th>
                                <th>Jumlah</th>
                                <th>Status</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>2024-07-28</td>
                                <td>User Logistik</td>
                                <td>Kabel NYY 4x16mm</td>
                                <td>200 Meter</td>
                                <td><span class="badge pill-status status-waiting">Menunggu</span></td>
                                <td class="table-actions">
                                    <button class="btn btn-sm btn-outline-success">Setuju</button>
                                    <button class="btn btn-sm btn-outline-danger">Tolak</button>
                                </td>
                            </tr>
                             <tr>
                                <td>2024-07-27</td>
                                <td>Budi (Teknisi)</td>
                                <td>Trafo 250 kVA</td>
                                <td>1 Unit</td>
                                <td><span class="badge pill-status status-approved">Disetujui</span></td>
                                <td class="table-actions">-</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        
        <!-- === Manajemen User Section (Placeholder) === -->
        <div id="manajemen-user" class="dashboard-section">
             <div class="card-modern">
                <h5 class="fw-bold">Manajemen User</h5>
                <p class="text-muted">Halaman untuk mengelola pengguna akan ada di sini.</p>
            </div>
        </div>

    </div>

    <!-- JS remains the same -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const sidebarNavLinks = document.querySelectorAll('.sidebar-nav .nav-link');
            const contentSections = document.querySelectorAll('.dashboard-section');
            const pageTitle = document.getElementById('page-title');
            const sidebar = document.getElementById('sidebar');
            const sidebarToggler = document.getElementById('sidebar-toggler');

            function switchSection(targetId) {
                contentSections.forEach(section => section.classList.remove('active'));
                const targetSection = document.getElementById(targetId);
                if (targetSection) targetSection.classList.add('active');

                sidebarNavLinks.forEach(link => {
                    link.classList.remove('active');
                    if (link.dataset.target === targetId) {
                        link.classList.add('active');
                        pageTitle.textContent = link.textContent.trim();
                    }
                });
            }

            sidebarNavLinks.forEach(link => {
                if(link.dataset.target) {
                    link.addEventListener('click', function (e) {
                        e.preventDefault();
                        switchSection(this.dataset.target);
                        if (window.innerWidth < 992) sidebar.classList.remove('active');
                    });
                }
            });

            if (sidebarToggler) {
                sidebarToggler.addEventListener('click', () => sidebar.classList.toggle('active'));
            }
        });
    </script>
</body>
</html>
