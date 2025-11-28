<?php

namespace App\Http\Controllers\Resepsionis;

use App\Http\Controllers\Controller;
use App\Models\Pemilik;
use App\Models\DataUser;
use App\Models\RoleUser;
use App\Models\Pet;
use App\Models\TemuDokter;
use App\Models\RekamMedis;
use Illuminate\Support\Facades\DB as FacadesDB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class PemilikController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $pemilik = Pemilik::with('user')->get();
        return view('resepsionis.Pemilik.index', compact('pemilik'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('resepsionis.Pemilik.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'email' => 'required|email|unique:user,email',
            'password' => 'required|string|min:6',
            'alamat' => 'required|string',
            'no_wa' => 'required|string|max:20',
        ]);

        DB::beginTransaction();
        try {
            // Create DataUser
            $user = DataUser::create([
                'nama' => $request->nama,
                'email' => $request->email,
                'password' => Hash::make($request->password),
            ]);

            // Assign role Pemilik (role_id = 5)
            RoleUser::create([
                'iduser' => $user->iduser,
                'idrole' => 5,
                'status' => 1,
            ]);

            // Create Pemilik
            Pemilik::create([
                'alamat' => $request->alamat,
                'no_wa' => $request->no_wa,
                'iduser' => $user->iduser,
            ]);

            DB::commit();
            return redirect()->route('resepsionis.pemilik.index')->with('success', 'Pemilik berhasil ditambahkan!');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Gagal menambahkan pemilik: ' . $e->getMessage())->withInput();
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $pemilik = Pemilik::with('user')->findOrFail($id);
        return view('resepsionis.Pemilik.edit', compact('pemilik'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $pemilik = Pemilik::findOrFail($id);

        $request->validate([
            'nama' => 'required|string|max:255',
            'email' => 'required|email|unique:user,email,' . $pemilik->iduser . ',iduser',
            'alamat' => 'required|string',
            'no_wa' => 'required|string|max:20',
        ]);

        DB::beginTransaction();
        try {
            // Update DataUser
            $pemilik->user->update([
                'nama' => $request->nama,
                'email' => $request->email,
            ]);

            // Update password if provided
            if ($request->filled('password')) {
                $pemilik->user->update([
                    'password' => Hash::make($request->password),
                ]);
            }

            // Update Pemilik
            $pemilik->update([
                'alamat' => $request->alamat,
                'no_wa' => $request->no_wa,
            ]);

            DB::commit();
            return redirect()->route('resepsionis.pemilik.index')->with('success', 'Pemilik berhasil diupdate!');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Gagal mengupdate pemilik: ' . $e->getMessage())->withInput();
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        FacadesDB::beginTransaction();
        try {
            $pemilik = Pemilik::with('user.roleUsers')->findOrFail($id);
            $user = $pemilik->user;

            // mark pets and related data as deleted
            $pets = $pemilik->pets()->get();
            foreach ($pets as $p) {
                foreach ($p->temuDokter()->get() as $t) {
                    foreach ($t->rekamMedis()->get() as $rm) {
                        $rm->markDeleted();
                    }
                    $t->markDeleted();
                }
                $p->markDeleted();
            }

            // mark pemilik
            $pemilik->markDeleted();

            // mark role_user entries
            if ($user) {
                foreach ($user->roleUsers()->get() as $ru) {
                    $ru->markDeleted();
                }

                // Only mark the user if the `user` table actually has `is_deleted` column.
                // markDeleted() falls back to hard delete when column missing, which breaks FK constraints.
                try {
                    $userTable = $user->getTable();
                    if (\Illuminate\Support\Facades\Schema::hasColumn($userTable, 'is_deleted')) {
                        $user->markDeleted();
                    } else {
                        // skip deleting user to avoid FK constraint; keep user row intact
                    }
                } catch (\Throwable $e) {
                    // if any error checking schema, skip deleting user for safety
                }
            }

            FacadesDB::commit();
            return redirect()->route('resepsionis.pemilik.index')->with('success', 'Pemilik berhasil dihapus!');
        } catch (\Exception $e) {
            FacadesDB::rollBack();
            return back()->with('error', 'Gagal menghapus pemilik: ' . $e->getMessage());
        }
    }
}
