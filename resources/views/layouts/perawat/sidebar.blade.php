<aside class="app-sidebar bg-body-secondary shadow" data-bs-theme="dark">
	<!--begin::Sidebar Brand-->
	<div class="sidebar-brand">
		<a href="/" class="brand-link">
			<img src="{{ asset('assets/img/AdminLTELogo.png') }}" alt="RSHP Logo" class="brand-image opacity-75 shadow" />
			<span class="brand-text fw-light">RSHP Perawat</span>
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
					<a href="{{ route('perawat.dashboard') }}" class="nav-link {{ request()->routeIs('perawat.dashboard') ? 'active' : '' }}">
						<i class="nav-icon bi bi-speedometer2"></i>
						<p>Dashboard</p>
					</a>
				</li>

				<!-- Header: MENU UTAMA -->
				<li class="nav-header">MENU UTAMA</li>

				<!-- Rekam Medis -->
				<li class="nav-item">
					<a href="{{ route('perawat.rekammedis.index') }}" class="nav-link {{ request()->routeIs('perawat.rekammedis.*') ? 'active' : '' }}">
						<i class="nav-icon bi bi-file-medical"></i>
						<p>Rekam Medis</p>
					</a>
				</li>

				<!-- Data Pasien -->
				<li class="nav-item">
					<a href="{{ route('perawat.pasien.index') }}" class="nav-link {{ request()->routeIs('perawat.pasien.*') ? 'active' : '' }}">
						<i class="nav-icon bi bi-people"></i>
						<p>Data Pasien</p>
					</a>
				</li>

				<!-- Profil Perawat -->
				<li class="nav-item">
					<a href="{{ route('perawat.profil.index') }}" class="nav-link {{ request()->routeIs('perawat.profil.*') ? 'active' : '' }}">
						<i class="nav-icon bi bi-person-circle"></i>
						<p>Profil</p>
					</a>
				</li>

			</ul>
			<!--end::Sidebar Menu-->
		</nav>
	</div>
	<!--end::Sidebar Wrapper-->
</aside>
