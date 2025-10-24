# TODO: Implement CRUD for All Admin Models in Laravel

## 1. Buat dan Modifikasi Model
- [x] Model Role sudah ada di `app/Models/Role.php` dengan konfigurasi tabel 'role', primary key 'idrole', fillable 'nama_role', dan relasi many-to-many dengan User.
- [x] Model DataUser sudah ada di `app/Models/DataUser.php` dengan konfigurasi tabel 'DataUser', primary key 'idDataUser', fillable ['nama', 'email', 'password'].
- [x] Model JenisHewan sudah ada di `app/Models/JenisHewan.php` dengan konfigurasi tabel 'jenis_hewan', primary key 'idjenis_hewan', fillable 'nama_jenis_hewan'.
- [x] Model Kategori sudah ada di `app/Models/Kategori.php` dengan konfigurasi tabel 'kategori', primary key 'idkategori', fillable 'nama_kategori'.
- [x] Model KategoriKlinis sudah ada di `app/Models/KategoriKlinis.php` dengan konfigurasi tabel 'kategori_klinis', primary key 'idkategori_klinis', fillable 'nama_kategori_klinis'.
- [x] Model KodeTindakanTerapi sudah ada di `app/Models/KodeTindakanTerapi.php` dengan konfigurasi tabel 'kode_tindakan_terapi', primary key 'idkode_tindakan_terapi', fillable ['kode', 'deskripsi_tindakan_terapi', 'idkategori', 'idkategori_klinis'].
- [x] Model Pet sudah ada di `app/Models/Pet.php` dengan konfigurasi tabel 'pet', primary key 'idpet', fillable ['nama', 'tanggal_lahir', 'warna_tanda', 'jenis_kelamin', 'idpemilik', 'idras_hewan'].
- [x] Model RasHewan sudah ada di `app/Models/RasHewan.php` dengan konfigurasi tabel 'ras_hewan', primary key 'idras_hewan', fillable ['nama_ras', 'idjenis_hewan'].
- [x] Model Pemilik sudah ada di `app/Models/Pemilik.php` dengan konfigurasi tabel 'pemilik', primary key 'idpemilik', fillable ['no_wa', 'alamat', 'iduser'].

## 2. Buat dan Modifikasi Controller
- [x] Buat `app/Http/Controllers/RoleController.php` dengan metode CRUD: index, create, store, show, edit, update, destroy.
- [x] Buat `app/Http/Controllers/DataUserController.php` dengan metode CRUD.
- [x] Buat `app/Http/Controllers/JenisHewanController.php` dengan metode CRUD.
- [x] Buat `app/Http/Controllers/KategoriController.php` dengan metode CRUD.
- [x] Buat `app/Http/Controllers/KategoriKlinisController.php` dengan metode CRUD.
- [x] Buat `app/Http/Controllers/KodeTindakanTerapiController.php` dengan metode CRUD.
- [x] Buat `app/Http/Controllers/PetController.php` dengan metode CRUD.
- [x] Buat `app/Http/Controllers/RasHewanController.php` dengan metode CRUD.
- [x] Buat `app/Http/Controllers/PemilikController.php` dengan metode CRUD.

## 3. Buat View (Tampilan Blade)
- [x] Isi `resources/views/admin/Role/index.blade.php` dengan tabel untuk list role, tombol untuk create, edit, delete.
- [x] Buat `resources/views/admin/Role/create.blade.php` untuk form create.
- [x] Buat `resources/views/admin/Role/edit.blade.php` untuk form edit.
- [x] Buat `resources/views/admin/Role/show.blade.php` untuk detail view.
- [x] Isi `resources/views/admin/DataUser/index.blade.php` dengan tabel untuk list DataUser.
- [x] Isi `resources/views/admin/JenisHewan/index.blade.php` dengan tabel untuk list JenisHewan.
- [x] Isi `resources/views/admin/Kategori/index.blade.php` dengan tabel untuk list Kategori.
- [x] Isi `resources/views/admin/KategoriKlinis/index.blade.php` dengan tabel untuk list KategoriKlinis.
- [x] Isi `resources/views/admin/KodeTindakanTerapi/index.blade.php` dengan tabel untuk list KodeTindakanTerapi.
- [x] Isi `resources/views/admin/Pet/index.blade.php` dengan tabel untuk list Pet.
- [x] Isi `resources/views/admin/RasHewan/index.blade.php` dengan tabel untuk list RasHewan.
- [x] Isi `resources/views/admin/Pemilik/index.blade.php` dengan tabel untuk list Pemilik.

## 4. Daftarkan Route (web.php)
- [x] Tambahkan route di `routes/web.php` untuk role management (index, create, store, edit, update, destroy).
- [x] Tambahkan route di `routes/web.php` untuk semua model admin lainnya.

## 5. Verifikasi dan Lihat Hasil
- [ ] Jalankan aplikasi dan test CRUD untuk semua model.
