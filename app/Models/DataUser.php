<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable; 
use Illuminate\Notifications\Notifiable;

// PENTING: Class harus MENG-EXTEND Authenticatable agar bisa digunakan untuk Login/Auth
class DataUser extends Authenticatable 
{
    use HasFactory, Notifiable;

    public $timestamps = false; // Mengabaikan kolom created_at dan updated_at

    /**
     * The table associated with the model.
     * PENTING: Jika tabel Anda benar-benar bernama 'datauser', ini sudah benar.
     */
    // Migration creates table 'datauser' so model should reference it
    protected $table = 'user'; // Nama tabel di database: user

    /**
     * The primary key associated with the table.
     */
    protected $primaryKey = 'iduser'; // Primary key adalah 'iduser'
    public $incrementing = true; // Menonaktifkan auto-increment jika iduser bukan auto-increment
    protected $keyType = 'int'; // Tipe data primary key
    protected $fillable = [
        'nama',
        'email',
        'password',
    ];

    protected $hidden = [
        'password'
    ];

    /**
     * Get the pemilik associated with the DataUser (One to One).
     * PERBAIKAN: Menggunakan iduser sebagai foreign key.
     */
    public function pemilik()
    {
        // foreign key di tabel 'pemilik' adalah 'iduser' yang merujuk ke 'iduser' di tabel 'user'
        return $this->hasOne(Pemilik::class, 'iduser', 'iduser');
    }

    /**
     * The roles that belong to the DataUser (Many to Many).
     */
    public function roles()
    {
        // Pivot table: role_user, foreign key: iduser (merujuk ke iduser), related key: idrole
        return $this->belongsToMany(Role::class, 'role_user', 'iduser', 'idrole');
    }

    /**
     * The role_users that belong to the DataUser (One to Many).
     * PENTING: Relasi ini digunakan untuk Logika Login kustom (roleUser[0]->idrole)
     */
    public function roleUsers()
    {
        // foreign key di tabel 'role_user' adalah 'iduser' yang merujuk ke 'iduser' di tabel 'user'
        return $this->hasMany(RoleUser::class, 'iduser', 'iduser');
    }

    /**
     * Get the dokter associated with the DataUser (One to One).
     */
    public function dokter()
    {
        return $this->hasOne(Dokter::class, 'id_user', 'iduser');
    }

    /**
     * Get the perawat associated with the DataUser (One to One).
     */
    public function perawat()
    {
        return $this->hasOne(Perawat::class, 'id_user', 'iduser');
    }
}