<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\DataUser;

class Dokter extends Model
{
    use HasFactory;

    protected $table = 'dokter';
    protected $primaryKey = 'id_dokter';
    public $timestamps = false;

    protected $fillable = [
        'alamat',
        'no_hp',
        'bidang_dokter',
        'jenis_kelamin',
        'id_user'
    ];

    public function user()
    {
        return $this->belongsTo(DataUser::class, 'id_user', 'iduser');
    }
}
