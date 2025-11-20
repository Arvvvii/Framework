<aside class="app-sidebar bg-body-secondary shadow" data-bs-theme="dark">
    <div class="sidebar-brand">
        <a href="{{ route('resepsionis.dashboard') }}" class="brand-link">
            <i class="fas fa-hospital-user brand-icon"></i>
            <span class="brand-text fw-light">RSHP UNAIR</span>
        </a>
    </div>

    <div class="sidebar-wrapper">
        <nav class="mt-2">
            <ul class="nav sidebar-menu flex-column" data-lte-toggle="treeview" role="menu" data-accordion="false">
                <!-- Dashboard -->
                <li class="nav-item">
                    <a href="{{ route('resepsionis.dashboard') }}" class="nav-link {{ request()->routeIs('resepsionis.dashboard') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-tachometer-alt"></i>
                        <p>Dashboard</p>
                    </a>
                </li>

                <!-- Registrasi Dropdown -->
                <li class="nav-item {{ request()->routeIs('resepsionis.pemilik.*') || request()->routeIs('resepsionis.pet.*') ? 'menu-open' : '' }}">
                    <a href="#" class="nav-link {{ request()->routeIs('resepsionis.pemilik.*') || request()->routeIs('resepsionis.pet.*') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-user-plus"></i>
                        <p>
                            Registrasi
                            <i class="nav-arrow fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{ route('resepsionis.pemilik.index') }}" class="nav-link {{ request()->routeIs('resepsionis.pemilik.*') ? 'active' : '' }}">
                                <i class="nav-icon fas fa-users"></i>
                                <p>Pemilik</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('resepsionis.pet.index') }}" class="nav-link {{ request()->routeIs('resepsionis.pet.*') ? 'active' : '' }}">
                                <i class="nav-icon fas fa-paw"></i>
                                <p>Pet</p>
                            </a>
                        </li>
                    </ul>
                </li>

                <!-- Temu Dokter -->
                <li class="nav-item">
                    <a href="{{ route('resepsionis.temudokter.index') }}" class="nav-link {{ request()->routeIs('resepsionis.temudokter.*') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-calendar-check"></i>
                        <p>Temu Dokter</p>
                    </a>
                </li>
            </ul>
        </nav>
    </div>
</aside>
