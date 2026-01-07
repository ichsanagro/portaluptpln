<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Permintaan Material - Portal UPT PLN</title>

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
            --light-bg: #f8f9fa;
            --text-dark: #212529;
            --text-muted: #6c757d;
        }

        body {
            font-family: 'Inter', sans-serif;
            background-color: var(--light-bg);
            color: var(--text-dark);
        }

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

        .main-content {
            margin-left: var(--sidebar-width);
            padding: 2.5rem;
        }
        
        #page-title {
            font-weight: 700;
            color: var(--text-dark);
        }

        .card-modern {
            background-color: #ffffff;
            border: none;
            border-radius: 15px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.08);
            padding: 2rem;
        }
        .card-modern .card-header-modern {
             padding-bottom: 1.5rem;
             margin-bottom: 1.5rem;
             border-bottom: 1px solid #f0f0f0;
        }

        .search-container {
            position: relative;
        }
        .search-container .form-control {
            padding-left: 2.5rem;
            border-radius: 50rem;
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
            border-bottom: none;
        }
        .table-clean thead th:first-child { border-top-left-radius: 10px; }
        .table-clean thead th:last-child { border-top-right-radius: 10px; }

        .table-clean tbody td {
            padding: 1.25rem;
            vertical-align: middle;
            border-bottom: 1px solid #f0f0f0;
        }
        .table-clean tbody tr:last-child td {
            border-bottom: none;
        }

        .table-actions button, .table-actions a {
            background: none;
            border: none;
            padding: 0.25rem 0.5rem;
            font-size: 1.1rem;
            text-decoration: none;
        }
        
        .badge.pill-status {
            border-radius: 50rem;
            font-weight: 600;
            padding: 0.4em 0.8em;
            font-size: 0.8rem;
        }
        .pill-status.status-waiting {
            background-color: rgba(0, 84, 155, 0.1);
            color: var(--pln-blue);
        }
        .pill-status.status-approved {
            background-color: rgba(25, 135, 84, 0.1);
            color: #198754;
        }
    </style>
</head>
<body>
    @include('layouts.partials.sidebar')
    
    <!-- Main Content -->
    <div class="main-content">
        <header class="d-flex justify-content-between align-items-center mb-4">
            <h1 class="h2" id="page-title">Permintaan Material</h1>
            <button class="btn d-lg-none" id="sidebar-toggler"><i class="bi bi-list fs-2"></i></button>
        </header>

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
</body>
</html>