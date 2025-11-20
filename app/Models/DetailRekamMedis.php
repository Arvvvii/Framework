<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DetailRekamMedis extends Model
{
    use HasFactory;

    /**
     * This table does not use Laravel timestamps columns `created_at`/`updated_at`.
     * Disable automatic timestamps to prevent QueryException when inserting.
     */
    public $timestamps = false;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'detail_rekam_medis';

    /**
     * The primary key associated with the table.
     *
     * @var string
     */
    protected $primaryKey = 'iddetail_rekam_medis';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'idrekam_medis',
        'idkode_tindakan_terapi',
        'detail',
    ];

    /**
     * Get the rekam_medis that owns the detail_rekam_medis (One to Many).
     */
    public function rekamMedis()
    {
        return $this->belongsTo(RekamMedis::class, 'idrekam_medis', 'idrekam_medis');
    }

    /**
     * Get the kode_tindakan_terapi that owns the detail_rekam_medis (One to Many).
     */
    public function kodeTindakanTerapi()
    {
        return $this->belongsTo(KodeTindakanTerapi::class, 'idkode_tindakan_terapi', 'idkode_tindakan_terapi');
    }
}
