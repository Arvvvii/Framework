<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
// use App\Models\Role; // Hapus atau jadikan komentar
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB; // PENTING: Import DB

class RoleController extends Controller
{
    /**
     * Display a listing of the resource. (READ)
     */
    public function index()
    {
        // GANTI: $roles = Role::all();
        $roles = DB::table('role')->get();
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
     * Store a newly created resource in storage. (CREATE)
     */
    public function store(Request $request)
    {
        $validated = $this->validateRole($request);

        $this->createRole($validated);

        return redirect()->route('admin.role.index')->with('success', 'Role berhasil ditambahkan.');
    }

    /**
     * Display the specified resource. (SHOW)
     */
    public function show($idrole) // Model Binding diganti
    {
        $role = DB::table('role')->where('idrole', $idrole)->first();
        if (!$role) {
            abort(404);
        }
        return view('admin.Role.show', compact('role'));
    }

    /**
     * Show the form for editing the specified resource. (EDIT)
     */
    public function edit($idrole) // Model Binding diganti
    {
        $role = DB::table('role')->where('idrole', $idrole)->first();
        if (!$role) {
            abort(404);
        }
        return view('admin.Role.edit', compact('role'));
    }

    /**
     * Update the specified resource in storage. (UPDATE)
     */
    public function update(Request $request, $idrole) // Model Binding diganti
    {
        $validated = $this->validateRole($request, $idrole);

        // GANTI: $role->update([...]);
        // Update only existing columns; the `role` table does not have timestamp columns.
        DB::table('role')
            ->where('idrole', $idrole)
            ->update([
                'nama_role' => $this->formatNamaRole($validated['nama_role']),
            ]);

        return redirect()->route('admin.role.index')->with('success', 'Role berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage. (DELETE)
     */
    public function destroy($idrole) // Model Binding diganti
    {
        // GANTI: $role->delete();
        DB::table('role')->where('idrole', $idrole)->delete();

        return redirect()->route('admin.role.index')->with('success', 'Role deleted successfully.');
    }

    // --- HELPER METHOD (DIBIARKAN SAMA) ---

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
        // GANTI: Menggunakan Query Builder untuk INSERT
        // Insert only the columns that exist on the table (no timestamps).
        return DB::table('role')->insert([
            'nama_role' => $this->formatNamaRole($data['nama_role']),
        ]);
    }

    protected function formatNamaRole(string $nama)
    {
        return trim(ucwords(strtolower($nama)));
    }
}