<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Dokter;
use App\Models\DataUser;
use App\Models\RoleUser;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class DokterController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $dokters = Dokter::with('user')->get();
        return view('admin.Dokter.index', compact('dokters'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $unassignedUsers = DataUser::whereDoesntHave('dokter')->get();
        return view('admin.Dokter.create', compact('unassignedUsers'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Base validation for Dokter fields
        $request->validate([
            'alamat' => 'required',
            'no_hp' => 'required',
            'bidang_dokter' => 'required',
            'jenis_kelamin' => 'required|in:L,P',
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

                // Assign Role: Dokter (idrole = 2)
                RoleUser::create([
                    'iduser' => $userId,
                    'idrole' => 2,
                    'status' => 1,
                ]);
            } else {
                // Using existing user
                $request->validate([
                    'id_user' => 'required|unique:dokter,id_user',
                ]);
                $userId = (int) $request->input('id_user');

                // Ensure the selected user has Dokter role; if missing, create it
                $hasRole = RoleUser::where('iduser', $userId)
                    ->where('idrole', 2)
                    ->exists();
                if (!$hasRole) {
                    RoleUser::create([
                        'iduser' => $userId,
                        'idrole' => 2,
                        'status' => 1,
                    ]);
                }
            }

            Dokter::create([
                'alamat' => $request->input('alamat'),
                'no_hp' => $request->input('no_hp'),
                'bidang_dokter' => $request->input('bidang_dokter'),
                'jenis_kelamin' => $request->input('jenis_kelamin'),
                'id_user' => $userId,
            ]);

            return redirect()->route('admin.dokter.index')->with('success', 'Data dokter berhasil ditambahkan');
        });
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $dokter = Dokter::with('user')->findOrFail($id);
        return view('admin.Dokter.show', compact('dokter'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $dokter = Dokter::findOrFail($id);
        $unassignedUsers = DataUser::whereDoesntHave('dokter')
            ->orWhere('iduser', $dokter->id_user)
            ->get();
        return view('admin.Dokter.edit', compact('dokter', 'unassignedUsers'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $dokter = Dokter::findOrFail($id);

        $request->validate([
            'id_user' => 'required|unique:dokter,id_user,' . $id . ',id_dokter',
            'alamat' => 'required',
            'no_hp' => 'required',
            'bidang_dokter' => 'required',
            'jenis_kelamin' => 'required|in:L,P'
        ]);

        $dokter->update($request->all());

        return redirect()->route('admin.dokter.index')->with('success', 'Data dokter berhasil diupdate');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $dokter = Dokter::findOrFail($id);
        $dokter->delete();

        return redirect()->route('admin.dokter.index')->with('success', 'Data dokter berhasil dihapus');
    }
}
