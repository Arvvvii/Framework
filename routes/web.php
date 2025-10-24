<?php

use Illuminate\Support\Facades\Route;
// Impor Controller Anda agar bisa digunakan
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

// Tambahkan route untuk cek koneksi database
Route::get('/cek-koneksi', [SiteController::class, 'cekKoneksi'])->name('cek-koneksi');

// 1. Home Page (Biasanya root '/' diarahkan ke home atau index)
Route::get('/', [SiteController::class, 'index'])->name('home');

// 2. Struktur Organisasi
Route::get('/struktur-organisasi', [SiteController::class, 'strukturOrganisasi'])->name('struktur-organisasi');

// 3. Layanan Umum
Route::get('/layanan-umum', [SiteController::class, 'layananUmum'])->name('layanan-umum');

// 4. Visi Misi dan Tujuan
Route::get('/visi-misi-tujuan', [SiteController::class, 'visiMisi'])->name('visi-misi-tujuan');

// 5. Berita
Route::get('/berita', [SiteController::class, 'berita'])->name('berita');

// Route untuk Login (sesuai navigasi native Anda, menuju file terpisah)
// Jika Anda belum membuat Controller untuk Login, gunakan Closure sementara
Route::get('/login', function () {
    return view('login'); // Anggap login.blade.php ada di resources/views/
})->name('login');

// Role CRUD Routes
Route::resource('role', RoleController::class)->names([
    'index' => 'admin.role.index',
    'create' => 'admin.role.create',
    'store' => 'admin.role.store',
    'show' => 'admin.role.show',
    'edit' => 'admin.role.edit',
    'update' => 'admin.role.update',
    'destroy' => 'admin.role.destroy',
]);

// DataUser CRUD Routes
Route::resource('datauser', DataUserController::class)->names([
    'index' => 'admin.datauser.index',
    'create' => 'admin.datauser.create',
    'store' => 'admin.datauser.store',
    'show' => 'admin.datauser.show',
    'edit' => 'admin.datauser.edit',
    'update' => 'admin.datauser.update',
    'destroy' => 'admin.datauser.destroy',
]);

// JenisHewan CRUD Routes
Route::resource('jenishawan', JenisHewanController::class)->names([
    'index' => 'admin.jenishawan.index',
    'create' => 'admin.jenishawan.create',
    'store' => 'admin.jenishawan.store',
    'show' => 'admin.jenishawan.show',
    'edit' => 'admin.jenishawan.edit',
    'update' => 'admin.jenishawan.update',
    'destroy' => 'admin.jenishawan.destroy',
]);

// Kategori CRUD Routes
Route::resource('kategori', KategoriController::class)->names([
    'index' => 'admin.kategori.index',
    'create' => 'admin.kategori.create',
    'store' => 'admin.kategori.store',
    'show' => 'admin.kategori.show',
    'edit' => 'admin.kategori.edit',
    'update' => 'admin.kategori.update',
    'destroy' => 'admin.kategori.destroy',
]);

// KategoriKlinis CRUD Routes
Route::resource('kategoriklinis', KategoriKlinisController::class)->names([
    'index' => 'admin.kategoriklinis.index',
    'create' => 'admin.kategoriklinis.create',
    'store' => 'admin.kategoriklinis.store',
    'show' => 'admin.kategoriklinis.show',
    'edit' => 'admin.kategoriklinis.edit',
    'update' => 'admin.kategoriklinis.update',
    'destroy' => 'admin.kategoriklinis.destroy',
]);

// KodeTindakanTerapi CRUD Routes
Route::resource('kodeterapi', KodeTindakanTerapiController::class)->names([
    'index' => 'admin.kodeterapi.index',
    'create' => 'admin.kodeterapi.create',
    'store' => 'admin.kodeterapi.store',
    'show' => 'admin.kodeterapi.show',
    'edit' => 'admin.kodeterapi.edit',
    'update' => 'admin.kodeterapi.update',
    'destroy' => 'admin.kodeterapi.destroy',
]);

// Pet CRUD Routes
Route::resource('pet', PetController::class)->names([
    'index' => 'admin.pet.index',
    'create' => 'admin.pet.create',
    'store' => 'admin.pet.store',
    'show' => 'admin.pet.show',
    'edit' => 'admin.pet.edit',
    'update' => 'admin.pet.update',
    'destroy' => 'admin.pet.destroy',
]);

// RasHewan CRUD Routes
Route::resource('rashewan', RasHewanController::class)->names([
    'index' => 'admin.rashewan.index',
    'create' => 'admin.rashewan.create',
    'store' => 'admin.rashewan.store',
    'show' => 'admin.rashewan.show',
    'edit' => 'admin.rashewan.edit',
    'update' => 'admin.rashewan.update',
    'destroy' => 'admin.rashewan.destroy',
]);

// Pemilik CRUD Routes
Route::resource('pemilik', PemilikController::class)->names([
    'index' => 'admin.pemilik.index',
    'create' => 'admin.pemilik.create',
    'store' => 'admin.pemilik.store',
    'show' => 'admin.pemilik.show',
    'edit' => 'admin.pemilik.edit',
    'update' => 'admin.pemilik.update',
    'destroy' => 'admin.pemilik.destroy',
]);
