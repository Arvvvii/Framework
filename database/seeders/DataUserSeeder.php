<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DataUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create roles
        $roles = [
            ['nama_role' => 'administrator'],
            ['nama_role' => 'dokter'],
            ['nama_role' => 'pemilik'],
            ['nama_role' => 'resepsionis'],
            ['nama_role' => 'perawat'],
        ];

        foreach ($roles as $role) {
            \App\Models\Role::create($role);
        }

        // Create users
        $users = [
            [
                'nama' => 'Admin User',
                'email' => 'admin@example.com',
                'password' => bcrypt('password'),
                'role_id' => 1, // administrator
            ],
            [
                'nama' => 'Dokter User',
                'email' => 'dokter@example.com',
                'password' => bcrypt('password'),
                'role_id' => 2, // dokter
            ],
            [
                'nama' => 'Pemilik User',
                'email' => 'pemilik@example.com',
                'password' => bcrypt('password'),
                'role_id' => 3, // pemilik
            ],
            [
                'nama' => 'Reta Pemilik',
                'email' => 'reta@mail.com',
                'password' => bcrypt('password'),
                'role_id' => 3, // pemilik
            ],
            [
                'nama' => 'Resepsionis User',
                'email' => 'resepsionis@example.com',
                'password' => bcrypt('password'),
                'role_id' => 4, // resepsionis
            ],
            [
                'nama' => 'Perawat User',
                'email' => 'perawat@example.com',
                'password' => bcrypt('password'),
                'role_id' => 5, // perawat
            ],
            [
                'nama' => 'Adela Perawat',
                'email' => 'adela@mail.com',
                'password' => bcrypt('password'),
                'role_id' => 5, // perawat
            ],
        ];

        foreach ($users as $userData) {
            $roleId = $userData['role_id'];
            unset($userData['role_id']);

            $user = \App\Models\DataUser::create($userData);

            \App\Models\RoleUser::create([
                'iduser' => $user->iduser,
                'idrole' => $roleId,
                'status' => 1,
            ]);
        }
    }
}
