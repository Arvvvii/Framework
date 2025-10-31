<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    use HasFactory;

    public $timestamps = false;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'role';

    /**
     * The primary key associated with the table.
     *
     * @var string
     */
    protected $primaryKey = 'idrole';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'nama_role',
    ];

    /**
     * The users that belong to the role (Many to Many).
     */
    public function users()
    {
        return $this->belongsToMany(DataUser::class, 'role_user', 'idrole', 'iduser');
    }

    /**
     * The role_users that belong to the Role (One to Many).
     */
    public function roleUsers()
    {
        return $this->hasMany(RoleUser::class, 'idrole', 'idrole');
    }
}
