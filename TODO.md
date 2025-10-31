# TODO: Fix Login Redirect Based on Role

## Current Issues
- LoginController redirects to routes like 'admin.dashboard', 'dokter.dashboard', etc.
- But routes/web.php has protected routes inside middleware groups
- Route names don't match between LoginController and web.php
- Role IDs in LoginController don't match seeder (1=admin, 2=dokter, 3=perawat, 4=resepsionis, default=pemilik vs seeder: 1=administrator, 2=dokter, 3=pemilik, 4=resepsionis, 5=perawat)

## Tasks
- [x] Update LoginController redirectTo property to use correct default route
- [x] Fix switch case in LoginController login method to match seeder role IDs
- [x] Ensure route names in LoginController match those in web.php
- [x] Verify all dashboard routes exist and are properly named
- [x] Start Laravel development server
- [ ] Test login redirects for all roles (browser tool disabled)
- [ ] Verify middleware protection works correctly

## Role Mapping (from DataUserSeeder)
- ID 1: administrator -> admin.dashboard
- ID 2: dokter -> dokter.dashboard
- ID 3: pemilik -> pemilik.dashboard
- ID 4: resepsionis -> resepsionis.dashboard
- ID 5: perawat -> perawat.dashboard

## Changes Made
- Updated LoginController redirectTo to '/'
- Fixed switch case to match seeder role IDs (1=admin, 2=dokter, 3=pemilik, 4=resepsionis, 5=perawat)
- Removed duplicate dashboard routes from web.php (they are now protected by middleware)
