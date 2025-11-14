<aside class="app-sidebar bg-body-secondary shadow" data-bs-theme="dark">
	<!--begin::Sidebar Brand-->
	<div class="sidebar-brand">
		<a href="/" class="brand-link">
			<img src="{{ asset('assets/img/AdminLTELogo.png') }}" alt="AdminLTE Logo" class="brand-image opacity-75 shadow" />
			<span class="brand-text fw-light">RSHP</span>
		</a>
	</div>
	<!--end::Sidebar Brand-->

	<!--begin::Sidebar Wrapper-->
	<div class="sidebar-wrapper">
		<nav class="mt-2">
			<!--begin::Sidebar Menu-->
			<ul class="nav sidebar-menu flex-column" data-lte-toggle="treeview" role="menu" data-accordion="false">
				
				<!-- Dashboard -->
				<li class="nav-item">
					<a href="{{ route('admin.dashboard') }}" class="nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
						<i class="nav-icon bi bi-speedometer2"></i>
						<p>Dashboard</p>
					</a>
				</li>

				<!-- Header: MENU UTAMA -->
				<li class="nav-header">MENU UTAMA</li>

				<!-- Dropdown: Data Master -->
				<li class="nav-item {{ request()->routeIs('admin.jenishewan.*') || request()->routeIs('admin.rashewan.*') || request()->routeIs('admin.kategori.*') || request()->routeIs('admin.kategoriklinis.*') ? 'menu-open' : '' }}">
					<a href="#" class="nav-link {{ request()->routeIs('admin.jenishewan.*') || request()->routeIs('admin.rashewan.*') || request()->routeIs('admin.kategori.*') || request()->routeIs('admin.kategoriklinis.*') ? 'active' : '' }}">
						<i class="nav-icon bi bi-database"></i>
						<p>
							Data Master
							<i class="nav-arrow bi bi-chevron-right"></i>
						</p>
					</a>
					<ul class="nav nav-treeview">
						<li class="nav-item">
							<a href="{{ route('admin.jenishewan.index') }}" class="nav-link {{ request()->routeIs('admin.jenishewan.*') ? 'active' : '' }}">
								<i class="nav-icon bi bi-circle"></i>
								<p>Jenis Hewan</p>
							</a>
						</li>
						<li class="nav-item">
							<a href="{{ route('admin.rashewan.index') }}" class="nav-link {{ request()->routeIs('admin.rashewan.*') ? 'active' : '' }}">
								<i class="nav-icon bi bi-circle"></i>
								<p>Ras Hewan</p>
							</a>
						</li>
						<li class="nav-item">
							<a href="{{ route('admin.kategori.index') }}" class="nav-link {{ request()->routeIs('admin.kategori.*') ? 'active' : '' }}">
								<i class="nav-icon bi bi-circle"></i>
								<p>Kategori</p>
							</a>
						</li>
						<li class="nav-item">
							<a href="{{ route('admin.kategoriklinis.index') }}" class="nav-link {{ request()->routeIs('admin.kategoriklinis.*') ? 'active' : '' }}">
								<i class="nav-icon bi bi-circle"></i>
								<p>Kategori Klinis</p>
							</a>
						</li>
					</ul>
				</li>

				<!-- Dropdown: Manajemen User -->
				<li class="nav-item {{ request()->routeIs('admin.datauser.*') || request()->routeIs('admin.role.*') ? 'menu-open' : '' }}">
					<a href="#" class="nav-link {{ request()->routeIs('admin.datauser.*') || request()->routeIs('admin.role.*') ? 'active' : '' }}">
						<i class="nav-icon bi bi-people"></i>
						<p>
							Manajemen User
							<i class="nav-arrow bi bi-chevron-right"></i>
						</p>
					</a>
					<ul class="nav nav-treeview">
						<li class="nav-item">
							<a href="{{ route('admin.datauser.index') }}" class="nav-link {{ request()->routeIs('admin.datauser.*') ? 'active' : '' }}">
								<i class="nav-icon bi bi-circle"></i>
								<p>User</p>
							</a>
						</li>
						<li class="nav-item">
							<a href="{{ route('admin.role.index') }}" class="nav-link {{ request()->routeIs('admin.role.*') ? 'active' : '' }}">
								<i class="nav-icon bi bi-circle"></i>
								<p>Role</p>
							</a>
						</li>
					</ul>
				</li>

				<!-- Dropdown: Pemilik & Pet -->
				<li class="nav-item {{ request()->routeIs('admin.pemilik.*') || request()->routeIs('admin.pet.*') ? 'menu-open' : '' }}">
					<a href="#" class="nav-link {{ request()->routeIs('admin.pemilik.*') || request()->routeIs('admin.pet.*') ? 'active' : '' }}">
						<i class="nav-icon bi bi-person-hearts"></i>
						<p>
							Pemilik & Pet
							<i class="nav-arrow bi bi-chevron-right"></i>
						</p>
					</a>
					<ul class="nav nav-treeview">
						<li class="nav-item">
							<a href="{{ route('admin.pemilik.index') }}" class="nav-link {{ request()->routeIs('admin.pemilik.*') ? 'active' : '' }}">
								<i class="nav-icon bi bi-circle"></i>
								<p>Data Pemilik</p>
							</a>
						</li>
						<li class="nav-item">
							<a href="{{ route('admin.pet.index') }}" class="nav-link {{ request()->routeIs('admin.pet.*') ? 'active' : '' }}">
								<i class="nav-icon bi bi-circle"></i>
								<p>Data Pet</p>
							</a>
						</li>
					</ul>
				</li>

				<!-- Dropdown: Pelayanan -->
				<li class="nav-item {{ request()->routeIs('admin.temudokter.*') || request()->routeIs('admin.rekammedis.*') || request()->routeIs('admin.kodeterapi.*') ? 'menu-open' : '' }}">
					<a href="#" class="nav-link {{ request()->routeIs('admin.temudokter.*') || request()->routeIs('admin.rekammedis.*') || request()->routeIs('admin.kodeterapi.*') ? 'active' : '' }}">
						<i class="nav-icon bi bi-hospital"></i>
						<p>
							Pelayanan
							<i class="nav-arrow bi bi-chevron-right"></i>
						</p>
					</a>
					<ul class="nav nav-treeview">
						<li class="nav-item">
							<a href="#" class="nav-link">
								<i class="nav-icon bi bi-circle"></i>
								<p>Temu Dokter</p>
							</a>
						</li>
						<li class="nav-item">
							<a href="{{ route('admin.rekammedis.index') }}" class="nav-link {{ request()->routeIs('admin.rekammedis.*') ? 'active' : '' }}">
								<i class="nav-icon bi bi-circle"></i>
								<p>Rekam Medis</p>
							</a>
						</li>
						<li class="nav-item">
							<a href="{{ route('admin.kodeterapi.index') }}" class="nav-link {{ request()->routeIs('admin.kodeterapi.*') ? 'active' : '' }}">
								<i class="nav-icon bi bi-circle"></i>
								<p>Tindakan Terapi</p>
							</a>
						</li>
					</ul>
				</li>

				<!-- Header: LAPORAN -->
				<li class="nav-header">LAPORAN</li>

				<!-- Dropdown: Laporan -->
				<li class="nav-item">
					<a href="#" class="nav-link">
						<i class="nav-icon bi bi-bar-chart"></i>
						<p>
							Laporan
							<i class="nav-arrow bi bi-chevron-right"></i>
						</p>
					</a>
					<ul class="nav nav-treeview">
						<li class="nav-item">
							<a href="#" class="nav-link">
								<i class="nav-icon bi bi-circle"></i>
								<p>Laporan Kunjungan</p>
							</a>
						</li>
						<li class="nav-item">
							<a href="#" class="nav-link">
								<i class="nav-icon bi bi-circle"></i>
								<p>Laporan Pendapatan</p>
							</a>
						</li>
					</ul>
				</li>

			</ul>
			<!--end::Sidebar Menu-->
		</nav>
	</div>
	<!--end::Sidebar Wrapper-->
</aside>

