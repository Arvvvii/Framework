<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class DataUser extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\DataUserFactory> */
    use HasFactory, Notifiable;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'user';

    /**
     * The primary key associated with the table.
     *
     * @var string
     */
    protected $primaryKey = 'iduser';

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'nama',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    /**
     * Get the pemilik associated with the DataUser (One to One).
     */
    public function pemilik()
    {
        return $this->hasOne(Pemilik::class, 'idDataUser', 'idDataUser');
    }

    /**
     * The roles that belong to the DataUser (Many to Many).
     */
    public function roles()
    {
        return $this->belongsToMany(Role::class, 'role_DataUser', 'idDataUser', 'idrole');
    }
}
