<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Perawat;
use App\Models\DataUser;
use App\Models\RoleUser;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class PerawatController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $perawats = Perawat::with('user')->get();
        return view('admin.Perawat.index', compact('perawats'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $unassignedUsers = DataUser::whereDoesntHave('perawat')->get();
        return view('admin.Perawat.create', compact('unassignedUsers'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Base validation for Perawat fields
        $request->validate([
            'alamat' => 'required',
            'no_hp' => 'required',
            'jenis_kelamin' => 'required|in:L,P',
            'pendidikan' => 'required'
        ]);

        return DB::transaction(function () use ($request) {
            $userId = null;

            if ($request->boolean('create_user')) {
                // Validate and create a new DataUser
                $validatedUser = $request->validate([
                    'nama' => 'required|string|max:255',
                    'email' => 'required|email|max:255|unique:user,email',
                    'password' => 'required|string|min:6|confirmed',
                ]);

                $newUser = DataUser::create([
                    'nama' => $validatedUser['nama'],
                    'email' => $validatedUser['email'],
                    'password' => Hash::make($validatedUser['password']),
                ]);
                $userId = $newUser->iduser;

                // Assign Role: Perawat (idrole = 3)
                RoleUser::create([
                    'iduser' => $userId,
                    'idrole' => 3,
                    'status' => 1,
                ]);
            } else {
                // Using existing user
                $request->validate([
                    'id_user' => 'required|unique:perawat,id_user',
                ]);
                $userId = (int) $request->input('id_user');

                // Ensure the selected user has Perawat role; if missing, create it
                $hasRole = RoleUser::where('iduser', $userId)
                    ->where('idrole', 3)
                    ->exists();
                if (!$hasRole) {
                    RoleUser::create([
                        'iduser' => $userId,
                        'idrole' => 3,
                        'status' => 1,
                    ]);
                }
            }

            Perawat::create([
                'alamat' => $request->input('alamat'),
                'no_hp' => $request->input('no_hp'),
                'jenis_kelamin' => $request->input('jenis_kelamin'),
                'pendidikan' => $request->input('pendidikan'),
                'id_user' => $userId,
            ]);

            return redirect()->route('admin.perawat.index')->with('success', 'Data perawat berhasil ditambahkan');
        });
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $perawat = Perawat::with('user')->findOrFail($id);
        return view('admin.Perawat.show', compact('perawat'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $perawat = Perawat::findOrFail($id);
        $unassignedUsers = DataUser::whereDoesntHave('perawat')
            ->orWhere('iduser', $perawat->id_user)
            ->get();
        return view('admin.Perawat.edit', compact('perawat', 'unassignedUsers'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $perawat = Perawat::findOrFail($id);

        $request->validate([
            'id_user' => 'required|unique:perawat,id_user,' . $id . ',id_perawat',
            'alamat' => 'required',
            'no_hp' => 'required',
            'jenis_kelamin' => 'required|in:L,P',
            'pendidikan' => 'required'
        ]);

        $perawat->update($request->all());

        return redirect()->route('admin.perawat.index')->with('success', 'Data perawat berhasil diupdate');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $perawat = Perawat::findOrFail($id);
        $perawat->delete();

        return redirect()->route('admin.perawat.index')->with('success', 'Data perawat berhasil dihapus');
    }
}
