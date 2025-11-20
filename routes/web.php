<?php

use Illuminate\Support\Facades\Route;

// --- Import Semua Controller ---
use App\Http\Controllers\Site\SiteController;
use App\Http\Controllers\Admin\RoleController;
use App\Http\Controllers\Admin\DataUserController;
use App\Http\Controllers\Admin\JenisHewanController;
use App\Http\Controllers\Admin\KategoriController;
use App\Http\Controllers\Admin\KategoriKlinisController;
use App\Http\Controllers\Admin\KodeTindakanTerapiController;
use App\Http\Controllers\Admin\PetController;
use App\Http\Controllers\Admin\RasHewanController;
use App\Http\Controllers\Admin\PemilikController;
use App\Http\Controllers\Admin\RekamMedisController;
use App\Http\Controllers\Perawat\RekamMedisController as PerawatRekamMedisController;
use App\Http\Controllers\Dokter\RekamMedisController as DokterRekamMedisController;
use App\Http\Controllers\Resepsionis\PemilikController as ResepsionisPemilikController;
use App\Http\Controllers\Resepsionis\PetController as ResepsionisPetController;
use App\Http\Controllers\Resepsionis\TemuDokterController as ResepsionisTemuDokterController;
use App\Http\Controllers\Pemilik\PetController as PemilikPetController;
use App\Http\Controllers\Pemilik\RekamMedisController as PemilikRekamMedisController;


/*
|--------------------------------------------------------------------------
| A. PUBLIC ROUTES (Routes sebelum Login)
|--------------------------------------------------------------------------
| Route yang dapat diakses oleh siapa saja.
*/

// Route Cek Koneksi (Modul 9)
Route::get('/cek-koneksi', [SiteController::class, 'cekKoneksi'])->name('cek-koneksi');

// Route Home Page Statis (Modul 8/9)
Route::get('/', [SiteController::class, 'index'])->name('home');
Route::get('/struktur-organisasi', [SiteController::class, 'strukturOrganisasi'])->name('struktur-organisasi');
Route::get('/layanan-umum', [SiteController::class, 'layananUmum'])->name('layanan-umum');
Route::get('/visi-misi-tujuan', [SiteController::class, 'visiMisi'])->name('visi-misi-tujuan');
Route::get('/berita', [SiteController::class, 'berita'])->name('berita');


/*
|--------------------------------------------------------------------------
| B. AUTHENTICATION ROUTES
|--------------------------------------------------------------------------
| Semua Route Login, Logout, Register, dll., dibuat otomatis di sini.
*/

// Baris ini harus dipanggil di sini, setelah route publik statis
Auth::routes();

// Debug route untuk testing
Route::get('/debug-perawat', function() {
    if (!auth()->check()) {
        return 'Not logged in';
    }
    
    $user = auth()->user();
    return [
        'user_id' => $user->iduser ?? 'null',
        'user_name' => $user->nama ?? 'null',
        'session_user_role' => session('user_role'),
        'roleUsers' => $user->roleUsers ? $user->roleUsers->toArray() : 'null',
        'first_role' => $user->roleUsers[0]->idrole ?? 'null',
        'role_name' => $user->roleUsers[0]->role->nama_role ?? 'null',
    ];
})->middleware('auth');


// Dashboard Routes for Login Redirections (these are now protected by middleware below)

// Logout Route
Route::post('/logout', [App\Http\Controllers\Auth\LoginController::class, 'logout'])->name('logout');
// Logout GET for testing (remove in production)
Route::get('/logout-get', [App\Http\Controllers\Auth\LoginController::class, 'logout'])->name('logout.get');


/*
|--------------------------------------------------------------------------
| C. ADMIN/CRUD ROUTES (Routes yang akan diproteksi Middleware)
|--------------------------------------------------------------------------
| Semua route CRUD diletakkan di bawah Auth::routes() dan dikelompokkan
| agar nanti mudah ditambahkan Middleware.
*/

// Dashboard Controllers
use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Resepsionis\DashboardController as ResepsionisDashboardController;
use App\Http\Controllers\Dokter\DashboardController as DokterDashboardController;
use App\Http\Controllers\Pemilik\DashboardController as PemilikDashboardController;
use App\Http\Controllers\Pemilik\ReservasiController as PemilikReservasiController;
use App\Http\Controllers\Perawat\DashboardController as PerawatDashboardController;

// Protected Admin Routes (dashboard + CRUD) - grouped and protected by auth + admin middleware
Route::middleware(['auth', 'admin'])->group(function () {
    // Admin Dashboard
    Route::get('/admin/dashboard', [AdminDashboardController::class, 'index'])->name('admin.dashboard');

    // -- GROUPING SEMUA ROUTE CRUD (Admin) --
    // Register full resource routes for admin masters so create/edit/store/update/destroy
    // route names are available (e.g. admin.role.create, admin.rashewan.create, etc.).
    Route::resource('admin/role', RoleController::class, ['as' => 'admin']);
    Route::resource('admin/datauser', DataUserController::class, ['as' => 'admin']);
    Route::resource('admin/jenishewan', JenisHewanController::class, ['as' => 'admin']);
    Route::resource('admin/kategori', KategoriController::class, ['as' => 'admin']);
    Route::resource('admin/kategoriklinis', KategoriKlinisController::class, ['as' => 'admin']);
    Route::resource('admin/kodeterapi', KodeTindakanTerapiController::class, ['as' => 'admin']);
    Route::resource('admin/pet', PetController::class, ['as' => 'admin']);
    Route::resource('admin/rashewan', RasHewanController::class, ['as' => 'admin']);
    Route::resource('admin/pemilik', PemilikController::class, ['as' => 'admin']);
    Route::resource('admin/rekammedis', RekamMedisController::class, ['as' => 'admin']);
    Route::resource('admin/dokter', \App\Http\Controllers\Admin\DokterController::class, ['as' => 'admin']);
    Route::resource('admin/perawat', \App\Http\Controllers\Admin\PerawatController::class, ['as' => 'admin']);
    Route::resource('admin/temudokter', \App\Http\Controllers\Admin\TemuDokterController::class, ['as' => 'admin']);
});

Route::middleware(['auth', 'resepsionis'])->group(function () {
    Route::get('/resepsionis/dashboard', [ResepsionisDashboardController::class, 'index'])->name('resepsionis.dashboard');
    Route::resource('resepsionis/pemilik', ResepsionisPemilikController::class, ['as' => 'resepsionis'])->except(['show']);
    Route::resource('resepsionis/pet', ResepsionisPetController::class, ['as' => 'resepsionis'])->except(['show']);
    Route::resource('resepsionis/temudokter', ResepsionisTemuDokterController::class, ['as' => 'resepsionis'])->only(['index', 'create', 'store', 'destroy']);
});

Route::middleware(['auth', 'dokter'])->group(function () {
    Route::get('/dokter/dashboard', [DokterDashboardController::class, 'index'])->name('dokter.dashboard');
    Route::resource('dokter/pasien', \App\Http\Controllers\Dokter\PasienController::class, ['as' => 'dokter'])->only(['index']);
    Route::get('/dokter/rekammedis/{pet}', [DokterRekamMedisController::class, 'index'])->name('dokter.rekammedis.index');
    Route::resource('dokter/rekammedis.detail', \App\Http\Controllers\Dokter\DetailRekamMedisController::class, ['as' => 'dokter'])->parameters(['rekammedis' => 'rekamMedis'])->only(['index', 'show', 'create', 'store', 'edit', 'update', 'destroy']);
    Route::resource('dokter/profil', \App\Http\Controllers\Dokter\ProfilController::class, ['as' => 'dokter'])->only(['index']);
});

Route::middleware(['auth', 'pemilik'])->group(function () {
    Route::get('/pemilik/dashboard', [PemilikDashboardController::class, 'index'])->name('pemilik.dashboard');
    Route::get('/pemilik/pet', [PemilikPetController::class, 'index'])->name('pemilik.pet.index');
    Route::get('/pemilik/rekammedis', [PemilikRekamMedisController::class, 'index'])->name('pemilik.rekammedis.index');
    Route::get('/pemilik/reservasi', [PemilikReservasiController::class, 'index'])->name('pemilik.reservasi.index');
});

Route::middleware(['auth', 'perawat'])->group(function () {
    Route::get('/perawat/dashboard', [PerawatDashboardController::class, 'index'])->name('perawat.dashboard');

    // Pasien list (reuse Dokter\PasienController@index)
    Route::get('/perawat/pasien', [\App\Http\Controllers\Dokter\PasienController::class, 'index'])->name('perawat.pasien.index');

    // Rekam Medis: index supports optional pet parameter to view per-pet history
    // Constrain `{pet}` to numeric so paths like `/perawat/rekammedis/create` are not
    // accidentally matched as a pet identifier and instead reach the resource routes.
    Route::get('/perawat/rekammedis/{pet?}', [PerawatRekamMedisController::class, 'index'])
        ->where('pet', '[0-9]+')
        ->name('perawat.rekammedis.index');

    // Single rekam medis detail view for perawat (distinct path to avoid routing ambiguity)
    Route::get('/perawat/rekammedis/detail/{rekamMedis}', [PerawatRekamMedisController::class, 'show'])->name('perawat.rekammedis.show');

    // Note: Perawat does not have a dedicated Tindakan Terapi page (list view removed).

    // Profil perawat (index only)
    Route::resource('perawat/profil', \App\Http\Controllers\Perawat\ProfilController::class, ['as' => 'perawat'])->only(['index']);

    // Resource routes for Rekam Medis (perawat) - allow CRUD except index/show handled above
    Route::resource('perawat/rekammedis', PerawatRekamMedisController::class, ['as' => 'perawat'])->parameters(['rekammedis' => 'rekamMedis'])->except(['index', 'show']);

    // Note: detail tindakan/terapi CRUD is handled by Dokter role only (dokter.rekammedis.detail).
});

// (moved into admin middleware group above)
