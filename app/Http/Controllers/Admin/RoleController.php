<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class RoleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $roles = Role::all();
        return view('admin.Role.index', compact('roles'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.Role.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $this->validateRole($request);

        $this->createRole($validated);

        return redirect()->route('admin.role.index')->with('success', 'Role berhasil ditambahkan.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Role $role)
    {
        return view('admin.Role.show', compact('role'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Role $role)
    {
        return view('admin.Role.edit', compact('role'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Role $role)
    {
        $validated = $this->validateRole($request, $role->idrole);

        $role->update([
            'nama_role' => $this->formatNamaRole($validated['nama_role']),
        ]);

        return redirect()->route('admin.role.index')->with('success', 'Role berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Role $role)
    {
        $role->delete();

        return redirect()->route('admin.role.index')->with('success', 'Role deleted successfully.');
    }

    /**
     * Validation helper for Role
     */
    protected function validateRole(Request $request, $id = null)
    {
        $uniqueRule = $id
            ? 'unique:role,nama_role,' . $id . ',idrole'
            : 'unique:role,nama_role';

        return $request->validate([
            'nama_role' => ['required', 'string', 'min:3', 'max:255', $uniqueRule],
        ], [
            'nama_role.required' => 'Nama role wajib diisi.',
            'nama_role.string' => 'Nama role harus berupa teks.',
            'nama_role.min' => 'Nama role minimal 3 karakter.',
            'nama_role.max' => 'Nama role maksimal 255 karakter.',
            'nama_role.unique' => 'Nama role sudah terdaftar.',
        ]);
    }

    /**
     * Create helper for Role
     */
    protected function createRole(array $data)
    {
        return Role::create([
            'nama_role' => $this->formatNamaRole($data['nama_role']),
        ]);
    }

    /**
     * Format helper for Role name
     */
    protected function formatNamaRole(string $nama)
    {
        return trim(ucwords(strtolower($nama)));
    }
}
