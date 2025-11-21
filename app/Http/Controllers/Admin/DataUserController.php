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
        $datausers = DB::table('user')->get();
        return view('admin.DataUser.index', compact('datausers'));
    }


    public function create()
    {
        return view('admin.DataUser.create');
    }

    /**
     * Store a newly created resource in storage. (CREATE)
     */
    public function store(Request $request)
    {
        $validated = $this->validateDataUser($request);

        $this->createDataUser($validated);

        return redirect()->route('admin.datauser.index')->with('success', 'Pengguna berhasil ditambahkan.');
    }

    /**
     * Display the specified resource. (SHOW)
     */
    public function show($idDataUser) // Model Binding diganti
    {
        // Menggunakan Query Builder
        $datauser = DB::table('user')->where('iduser', $idDataUser)->first();
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
        $datauser = DB::table('user')->where('iduser', $idDataUser)->first();
        if (!$datauser) {
            abort(404);
        }
        return view('admin.DataUser.edit', compact('datauser'));
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

        return redirect()->route('admin.datauser.index')->with('success', 'Pengguna berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage. (DELETE)
     */
    public function destroy($idDataUser) // Model Binding diganti
    {
        // GANTI: $datauser->delete();
        DB::table('user')->where('iduser', $idDataUser)->delete();

        return redirect()->route('admin.datauser.index')->with('success', 'DataUser deleted successfully.');
    }

    // --- HELPER METHOD (DIBIARKAN SAMA KARENA LOGIC VALIDASI TIDAK BERUBAH) ---

    protected function validateDataUser(Request $request, $id = null)
    {
        $uniqueEmail = $id
            ? 'unique:user,email,' . $id . ',iduser'
            : 'unique:user,email';

        $rules = [
            'nama' => ['required', 'string', 'min:3', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', $uniqueEmail],
        ];

        if ($id) {
            $rules['password'] = ['nullable', 'string', 'min:6', 'confirmed'];
        } else {
            $rules['password'] = ['required', 'string', 'min:6', 'confirmed'];
        }

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
        // GANTI: return DataUser::create([...]);
        return DB::table('user')->insert([
            'nama' => $data['nama'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
        ]);
    }
}