<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
// use App\Models\DataUser; // Hapus atau jadikan komentar
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB; // PENTING: Import DB

class DataUserController extends Controller
{
    // Menampilkan daftar DataUser (READ)
    public function index()
    {
        // GANTI: $datausers = DataUser::all();
        // Ambil juga role (jika ada) melalui tabel role_user -> role
        $datausers = DB::table('user as u')
            ->leftJoin('role_user as ru', 'u.iduser', '=', 'ru.iduser')
            ->leftJoin('role as r', 'ru.idrole', '=', 'r.idrole')
            ->select('u.*', 'r.nama_role as role_name')
            ->whereNull('u.deleted_at')
            ->get();
        return view('admin.DataUser.index', compact('datausers'));
    }


    public function create()
    {
        // Ambil daftar role yang tersedia untuk dropdown (jangan migrate)
        $roles = DB::table('role')->whereNull('deleted_at')->get();
        return view('admin.DataUser.create', compact('roles'));
    }

    /**
     * Store a newly created resource in storage. (CREATE)
     */
    public function store(Request $request)
    {
        $validated = $this->validateDataUser($request);
        $newId = $this->createDataUser($validated);

        // jika role dipilih, masukkan ke tabel role_user
        if ($request->filled('role_id')) {
            DB::table('role_user')->insert([
                'iduser' => $newId,
                'idrole' => $request->input('role_id'),
                'status' => 1,
            ]);
        }

        return redirect()->route('admin.datauser.index')->with('success', 'Pengguna berhasil ditambahkan.');
    }

    /**
     * Display the specified resource. (SHOW)
     */
    public function show($idDataUser) // Model Binding diganti
    {
        // Menggunakan Query Builder
        $datauser = DB::table('user')->where('iduser', $idDataUser)->whereNull('deleted_at')->first();
        if (!$datauser) {
            abort(404);
        }
        return view('admin.DataUser.show', compact('datauser'));
    }

    /**
     * Show the form for editing the specified resource. (EDIT)
     */
    public function edit($idDataUser) // Model Binding diganti
    {
        // Menggunakan Query Builder
        $datauser = DB::table('user')->where('iduser', $idDataUser)->whereNull('deleted_at')->first();
        if (!$datauser) {
            abort(404);
        }
        // Ambil semua role untuk select
        $roles = DB::table('role')->get();
        // Ambil role_user (jika ada) untuk user ini
        $roleUser = DB::table('role_user')->where('iduser', $idDataUser)->first();
        $currentRoleId = $roleUser->idrole ?? null;

        return view('admin.DataUser.edit', compact('datauser', 'roles', 'currentRoleId'));
    }

    /**
     * Update the specified resource in storage. (UPDATE)
     */
    public function update(Request $request, $idDataUser) // Model Binding diganti
    {
        $validated = $this->validateDataUser($request, $idDataUser);

        $updateData = [
            'nama' => $validated['nama'],
            'email' => $validated['email'],
        ];

        if (!empty($validated['password'])) {
            $updateData['password'] = Hash::make($validated['password']);
        }

        // GANTI: $datauser->update($updateData);
        DB::table('user')->where('iduser', $idDataUser)->update($updateData);

        // Update atau insert role_user jika role dipilih
        if ($request->filled('role_id')) {
            $existing = DB::table('role_user')->where('iduser', $idDataUser)->first();
            if ($existing) {
                DB::table('role_user')->where('iduser', $idDataUser)->update([
                    'idrole' => $request->input('role_id'),
                    'status' => 1,
                ]);
            } else {
                DB::table('role_user')->insert([
                    'iduser' => $idDataUser,
                    'idrole' => $request->input('role_id'),
                    'status' => 1,
                ]);
            }
        }

        return redirect()->route('admin.datauser.index')->with('success', 'Pengguna berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage. (DELETE)
     */
    public function destroy($idDataUser) // Model Binding diganti
    {
        // GANTI: $datauser->delete();
        DB::table('user')->where('iduser', $idDataUser)->update([
            'deleted_at' => now(),
            'deleted_by' => auth()->id() ?? null,
        ]);

        return redirect()->route('admin.datauser.index')->with('success', 'DataUser deleted successfully.');
    }

    // --- HELPER METHOD (DIBIARKAN SAMA KARENA LOGIC VALIDASI TIDAK BERUBAH) ---

    protected function validateDataUser(Request $request, $id = null)
    {
        $uniqueEmail = $id
            ? 'unique:user,email,' . $id . ',iduser'
            : 'unique:user,email';

        $rules = [
            'nama' => ['required', 'string', 'min:2', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', $uniqueEmail],
        ];

        if ($id) {
            $rules['password'] = ['nullable', 'string', 'min:6', 'confirmed'];
        } else {
            $rules['password'] = ['required', 'string', 'min:6', 'confirmed'];
        }

        // optional role id (if present, must exist in role table)
        $rules['role_id'] = ['nullable', 'integer'];

        return $request->validate($rules, [
            'nama.required' => 'Nama wajib diisi.',
            'nama.min' => 'Nama minimal 3 karakter.',
            'email.required' => 'Email wajib diisi.',
            'email.unique' => 'Email sudah digunakan.',
            'password.required' => 'Password wajib diisi.',
            'password.confirmed' => 'Konfirmasi password tidak cocok.',
        ]);
    }

    /**
     * Create helper for DataUser
     */
    protected function createDataUser(array $data)
    {
        // Insert dan kembalikan id yang baru dibuat
        return DB::table('user')->insertGetId([
            'nama' => $data['nama'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
        ]);
    }

    /**
     * Restore a soft-deleted data user
     */
    public function restore($idDataUser)
    {
        DB::table('user')->where('iduser', $idDataUser)->update([
            'deleted_at' => null,
            'deleted_by' => null,
        ]);
        return redirect()->route('admin.datauser.index')->with('success', 'User restored successfully.');
    }
}