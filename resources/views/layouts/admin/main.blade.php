<!doctype html>
<html lang="en">
	@include('layouts.admin.head')
	<body class="layout-fixed sidebar-expand-lg sidebar-open bg-body-tertiary">
		<div class="app-wrapper">
			{{-- Navbar --}}
			@include('layouts.admin.navbar')

			{{-- Sidebar --}}
			@include('layouts.admin.sidebar')

			{{-- App Main / Content --}}
			<main class="app-main">
				@yield('content')
			</main>

			{{-- Footer --}}
			@include('layouts.admin.footer')
		</div>

		{{-- Scripts: third-party and local --}}
		<script src="https://cdn.jsdelivr.net/npm/overlayscrollbars@2.11.0/browser/overlayscrollbars.browser.es6.min.js" crossorigin="anonymous"></script>
		<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" crossorigin="anonymous"></script>
		<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/js/bootstrap.min.js" crossorigin="anonymous"></script>
		<script src="{{ asset('assets/js/adminlte.js') }}"></script>

		{{-- Optional scripts --}}
		<script src="https://cdn.jsdelivr.net/npm/sortablejs@1.15.0/Sortable.min.js" crossorigin="anonymous"></script>
		<script src="https://cdn.jsdelivr.net/npm/apexcharts@3.37.1/dist/apexcharts.min.js" crossorigin="anonymous"></script>
		<script src="https://cdn.jsdelivr.net/npm/jsvectormap@1.5.3/dist/js/jsvectormap.min.js" crossorigin="anonymous"></script>

		<script>
			const SELECTOR_SIDEBAR_WRAPPER = '.sidebar-wrapper';
			const DefaultScrollbar = {
				scrollbarTheme: 'os-theme-light',
				scrollbarAutoHide: 'leave',
				scrollbarClickScroll: true,
			};

			document.addEventListener('DOMContentLoaded', function () {
				const sidebarWrapper = document.querySelector(SELECTOR_SIDEBAR_WRAPPER);
				if (typeof OverlayScrollbars !== 'undefined' && sidebarWrapper) {
					OverlayScrollbars(sidebarWrapper, {
						className: DefaultScrollbar.scrollbarTheme,
						scrollbars: {
							autoHide: DefaultScrollbar.scrollbarAutoHide,
							clickScroll: DefaultScrollbar.scrollbarClickScroll,
						}
					});
				}

				// Treeview functionality for sidebar dropdown
				const treeviewMenus = document.querySelectorAll('[data-lte-toggle="treeview"]');
				treeviewMenus.forEach(function(menu) {
					menu.addEventListener('click', function(e) {
						const parentItem = this.closest('.nav-item');
						const isOpen = parentItem.classList.contains('menu-open');
						
						// Close all other open menus if accordion mode
						const allMenus = document.querySelectorAll('.nav-item.menu-open');
						allMenus.forEach(function(item) {
							if (item !== parentItem) {
								item.classList.remove('menu-open');
								const submenu = item.querySelector('.nav-treeview');
								if (submenu) {
									submenu.style.display = 'none';
								}
							}
						});

						// Toggle current menu
						if (isOpen) {
							parentItem.classList.remove('menu-open');
							const submenu = parentItem.querySelector('.nav-treeview');
							if (submenu) {
								submenu.style.display = 'none';
							}
						} else {
							parentItem.classList.add('menu-open');
							const submenu = parentItem.querySelector('.nav-treeview');
							if (submenu) {
								submenu.style.display = 'block';
							}
						}
						
						e.preventDefault();
					});
				});

				// Auto-open menu if active item inside
				const activeItems = document.querySelectorAll('.nav-item.menu-open');
				activeItems.forEach(function(item) {
					const submenu = item.querySelector('.nav-treeview');
					if (submenu) {
						submenu.style.display = 'block';
					}
				});
			});
		</script>

		@stack('scripts')
	</body>
</html>

