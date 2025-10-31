<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TemuDokter extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'temu_dokter';

    /**
     * The primary key associated with the table.
     *
     * @var string
     */
    protected $primaryKey = 'idreservasi_dokter';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'no_urut',
        'waktu_daftar',
        'status',
        'idpet',
        'idrole_user',
    ];

    /**
     * The attributes that should be cast.
     *
     * @return array
     */
    protected function casts(): array
    {
        return [
            'waktu_daftar' => 'datetime',
        ];
    }

    /**
     * Get the pet that owns the temu_dokter (One to Many).
     */
    public function pet()
    {
        return $this->belongsTo(Pet::class, 'idpet', 'idpet');
    }

    /**
     * Get the role_user that owns the temu_dokter (One to Many).
     */
    public function roleUser()
    {
        return $this->belongsTo(RoleUser::class, 'idrole_user', 'idrole_user');
    }

    /**
     * Get the rekam_medis for the temu_dokter (One to Many).
     */
    public function rekamMedis()
    {
        return $this->hasMany(RekamMedis::class, 'idreservasi_dokter', 'idreservasi_dokter');
    }
}
