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
use App\Http\Controllers\Perawat\TindakanTerapiController;
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
use App\Http\Controllers\Perawat\DashboardController as PerawatDashboardController;

// Protected Dashboard Routes
Route::middleware(['auth', 'admin'])->group(function () {
    Route::get('/admin/dashboard', [AdminDashboardController::class, 'index'])->name('admin.dashboard');
});

Route::middleware(['auth', 'resepsionis'])->group(function () {
    Route::get('/resepsionis/dashboard', [ResepsionisDashboardController::class, 'index'])->name('resepsionis.dashboard');
    Route::get('/resepsionis/pemilik', [ResepsionisPemilikController::class, 'index'])->name('resepsionis.pemilik.index');
    Route::get('/resepsionis/pet', [ResepsionisPetController::class, 'index'])->name('resepsionis.pet.index');
    Route::get('/resepsionis/temudokter', [ResepsionisTemuDokterController::class, 'index'])->name('resepsionis.temudokter.index');
});

Route::middleware(['auth', 'dokter'])->group(function () {
    Route::get('/dokter/dashboard', [DokterDashboardController::class, 'index'])->name('dokter.dashboard');
    Route::get('/dokter/rekammedis', [DokterRekamMedisController::class, 'index'])->name('dokter.rekammedis.index');
});

Route::middleware(['auth', 'pemilik'])->group(function () {
    Route::get('/pemilik/dashboard', [PemilikDashboardController::class, 'index'])->name('pemilik.dashboard');
    Route::get('/pemilik/pet', [PemilikPetController::class, 'index'])->name('pemilik.pet.index');
    Route::get('/pemilik/rekammedis', [PemilikRekamMedisController::class, 'index'])->name('pemilik.rekammedis.index');
});

Route::middleware(['auth', 'perawat'])->group(function () {
    Route::get('/perawat/dashboard', [PerawatDashboardController::class, 'index'])->name('perawat.dashboard');
    Route::get('/perawat/rekammedis', [PerawatRekamMedisController::class, 'index'])->name('perawat.rekammedis.index');
    Route::get('/perawat/tindakanterapi', [TindakanTerapiController::class, 'index'])->name('perawat.tindakanterapi.index');
});

// -- GROUPING SEMUA ROUTE CRUD --
// Kita tidak menggunakan Route::resource() di sini agar nanti mudah di-grouping/diberi middleware.
// Kita hanya menggunakan Route::get() untuk menampilkan data (sesuai tugas C Modul 9: "hanya read saja")

Route::get('admin/role', [RoleController::class, 'index'])->name('admin.role.index');
Route::get('admin/datauser', [DataUserController::class, 'index'])->name('admin.datauser.index');
Route::get('admin/jenishewan', [JenisHewanController::class, 'index'])->name('admin.jenishewan.index');
Route::get('admin/kategori', [KategoriController::class, 'index'])->name('admin.kategori.index');
Route::get('admin/kategoriklinis', [KategoriKlinisController::class, 'index'])->name('admin.kategoriklinis.index');
Route::get('admin/kodeterapi', [KodeTindakanTerapiController::class, 'index'])->name('admin.kodeterapi.index');
Route::get('admin/pet', [PetController::class, 'index'])->name('admin.pet.index');
Route::get('admin/rashewan', [RasHewanController::class, 'index'])->name('admin.rashewan.index');
Route::get('admin/pemilik', [PemilikController::class, 'index'])->name('admin.pemilik.index');
Route::get('admin/rekammedis', [RekamMedisController::class, 'index'])->name('admin.rekammedis.index');
