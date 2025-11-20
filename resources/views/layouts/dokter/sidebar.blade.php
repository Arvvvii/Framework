<aside class="app-sidebar bg-body-secondary shadow" data-bs-theme="dark">
	<!--begin::Sidebar Brand-->
	<div class="sidebar-brand">
		<a href="/" class="brand-link">
			<img src="{{ asset('assets/img/AdminLTELogo.png') }}" alt="RSHP Logo" class="brand-image opacity-75 shadow" />
			<span class="brand-text fw-light">RSHP Dokter</span>
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
					<a href="{{ route('dokter.dashboard') }}" class="nav-link {{ request()->routeIs('dokter.dashboard') ? 'active' : '' }}">
						<i class="nav-icon bi bi-speedometer2"></i>
						<p>Dashboard</p>
					</a>
				</li>

				<!-- Header: MENU UTAMA -->
				<li class="nav-header">MENU UTAMA</li>


				   <!-- Data Pasien -->
				   <li class="nav-item">
					   <a href="{{ route('dokter.pasien.index') }}" class="nav-link {{ request()->routeIs('dokter.pasien.*') ? 'active' : '' }}">
						   <i class="nav-icon bi bi-people"></i>
						   <p>Pasien &amp; Rekam Medis</p>
					   </a>
				   </li>


				   <!-- Profil Dokter -->
				   <li class="nav-item">
					   <a href="{{ route('dokter.profil.index') }}" class="nav-link {{ request()->routeIs('dokter.profil.*') ? 'active' : '' }}">
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
