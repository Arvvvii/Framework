<aside class="app-sidebar bg-body-secondary shadow" data-bs-theme="dark">
    <div class="sidebar-brand">
        <a href="{{ route('pemilik.dashboard') }}" class="brand-link">
            <i class="fas fa-hospital brand-icon"></i>
            <span class="brand-text fw-light">RSHP UNAIR</span>
        </a>
    </div>

    <div class="sidebar-wrapper">
        <nav class="mt-2">
            <ul class="nav sidebar-menu flex-column" data-lte-toggle="treeview" role="menu" data-accordion="false">
                <!-- Dashboard -->
                <li class="nav-item">
                    <a href="{{ route('pemilik.dashboard') }}" class="nav-link {{ request()->routeIs('pemilik.dashboard') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-tachometer-alt"></i>
                        <p>Dashboard</p>
                    </a>
                </li>

                <!-- Profil & Pet Saya -->
                <li class="nav-item">
                    <a href="{{ route('pemilik.pet.index') }}" class="nav-link {{ request()->routeIs('pemilik.pet.*') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-user"></i>
                        <p>Profil & Pet Saya</p>
                    </a>
                </li>

                <!-- Rekam Medis -->
                <li class="nav-item">
                    <a href="{{ route('pemilik.rekammedis.index') }}" class="nav-link {{ request()->routeIs('pemilik.rekammedis.*') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-file-medical"></i>
                        <p>Rekam Medis</p>
                    </a>
                </li>

                <!-- Jadwal Temu Dokter -->
                <li class="nav-item">
                    <a href="{{ route('pemilik.reservasi.index') }}" class="nav-link {{ request()->routeIs('pemilik.reservasi.*') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-calendar-check"></i>
                        <p>Jadwal Temu Dokter</p>
                    </a>
                </li>
            </ul>
        </nav>
    </div>
</aside>
