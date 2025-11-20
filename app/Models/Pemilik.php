<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pemilik extends Model
{
    use HasFactory;

    public $timestamps = false;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'pemilik';

    /**
     * The primary key associated with the table.
     *
     * @var string
     */
    protected $primaryKey = 'idpemilik';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'no_wa',
        'alamat',
        'iduser',
    ];

    /**
     * Get the user that owns the pemilik (One to One).
     */
    public function user()
    {
        return $this->belongsTo(DataUser::class, 'iduser', 'iduser');
    }

    /**
     * Get the pets for the pemilik (One to Many).
     */
    public function pets()
    {
        return $this->hasMany(Pet::class, 'idpemilik', 'idpemilik');
    }
}
