<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\DataUser;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;

class DataUserController extends Controller
{
   // Menampilkan daftar DataUser
    public function index()
    {
        $datausers = DataUser::all();
        return view('admin.DataUser.index', compact('datausers'));
    }


    public function create()
    {
        return view('admin.DataUser.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $this->validateDataUser($request);

        $this->createDataUser($validated);

        return redirect()->route('admin.datauser.index')->with('success', 'Pengguna berhasil ditambahkan.');
    }

    /**
     * Display the specified resource.
     */
    public function show(DataUser $datauser)
    {
        return view('admin.DataUser.show', compact('datauser'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(DataUser $datauser)
    {
        return view('admin.DataUser.edit', compact('datauser'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, DataUser $datauser)
    {
        $validated = $this->validateDataUser($request, $datauser->idDataUser);

        $updateData = [
            'nama' => $validated['nama'],
            'email' => $validated['email'],
        ];

        if (!empty($validated['password'])) {
            $updateData['password'] = Hash::make($validated['password']);
        }

        $datauser->update($updateData);

        return redirect()->route('admin.datauser.index')->with('success', 'Pengguna berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(DataUser $datauser)
    {
        $datauser->delete();

        return redirect()->route('admin.datauser.index')->with('success', 'DataUser deleted successfully.');
    }

    /**
     * Validation helper for DataUser
     */
    protected function validateDataUser(Request $request, $id = null)
    {
        $uniqueEmail = $id
            ? 'unique:DataUser,email,' . $id . ',idDataUser'
            : 'unique:DataUser,email';

        $rules = [
            'nama' => ['required', 'string', 'min:3', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', $uniqueEmail],
        ];

        if ($id) {
            // password optional on update
            $rules['password'] = ['nullable', 'string', 'min:8', 'confirmed'];
        } else {
            $rules['password'] = ['required', 'string', 'min:8', 'confirmed'];
        }

        return $request->validate($rules, [
            'nama.required' => 'Nama wajib diisi.',
            'nama.string' => 'Nama harus berupa teks.',
            'nama.min' => 'Nama minimal 3 karakter.',
            'email.required' => 'Email wajib diisi.',
            'email.email' => 'Format email tidak valid.',
            'email.unique' => 'Email sudah digunakan.',
            'password.required' => 'Password wajib diisi.',
            'password.min' => 'Password minimal 8 karakter.',
            'password.confirmed' => 'Konfirmasi password tidak cocok.',
        ]);
    }

    /**
     * Create helper for DataUser
     */
    protected function createDataUser(array $data)
    {
        return DataUser::create([
            'nama' => $data['nama'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
        ]);
    }
}
