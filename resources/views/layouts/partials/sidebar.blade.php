<!-- Sidebar -->
<div class="sidebar" id="sidebar">
    <div class="sidebar-header">
        <a href="{{ route('logistik.dashboard') }}" class="logo"><i class="bi bi-lightning-charge-fill"></i> UPT PLN</a>
    </div>
    <nav class="sidebar-nav">
        <ul class="nav flex-column">
            <li class="nav-item">
                <a class="nav-link {{ request()->routeIs('logistik.dashboard') ? 'active' : '' }}" href="{{ route('logistik.dashboard') }}">
                    <i class="bi bi-grid-fill"></i> Dashboard
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ request()->routeIs('logistik.material') ? 'active' : '' }}" href="{{ route('logistik.material') }}">
                    <i class="bi bi-box-seam-fill"></i> Kelola Material
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ request()->routeIs('logistik.permintaan') ? 'active' : '' }}" href="{{ route('logistik.permintaan') }}">
                    <i class="bi bi-card-checklist"></i> Permintaan
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="#">
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