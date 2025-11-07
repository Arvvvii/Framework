<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\RekamMedis;
use App\Models\RoleUser;
use App\Models\TemuDokter;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;

class RekamMedisController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $rekamMedis = RekamMedis::with('temuDokter.pet.pemilik', 'temuDokter.pet.rasHewan', 'roleUser.user')->get();
        return view('admin.RekamMedis.index', compact('rekamMedis'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // Get active role_user entries for dokter (status = 1)
        $dokters = RoleUser::with('user', 'role')
            ->where('status', '1')
            ->whereHas('role', function ($q) {
                $q->whereRaw("LOWER(nama_role) LIKE '%dokter%'");
            })
            ->get();

        // Get available temu dokter records (to attach rekam medis to a reservation)
        $temuDokters = TemuDokter::with('pet')->get();

        return view('admin.RekamMedis.create', compact('dokters', 'temuDokters'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'anamnesa' => ['required', 'string', 'min:3'],
            'temuan_klinis' => ['nullable', 'string'],
            'diagnosa' => ['nullable', 'string'],
            'dokter_pemeriksa' => ['required', 'integer'], // idrole_user
            'idreservasi_dokter' => ['required', 'integer'],
        ]);

        RekamMedis::create([
            'anamnesa' => $validated['anamnesa'],
            'temuan_klinis' => $validated['temuan_klinis'] ?? null,
            'diagnosa' => $validated['diagnosa'] ?? null,
            'dokter_pemeriksa' => $validated['dokter_pemeriksa'],
            'idreservasi_dokter' => $validated['idreservasi_dokter'],
        ]);

        return redirect()->route('admin.rekammedis.index')->with('success', 'Rekam medis berhasil ditambahkan.');
    }

    /**
     * Display the specified resource.
     */
    public function show(RekamMedis $rekammedi)
    {
        return view('admin.RekamMedis.show', compact('rekammedi'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(RekamMedis $rekammedi)
    {
        $dokters = RoleUser::with('user', 'role')
            ->where('status', '1')
            ->whereHas('role', function ($q) {
                $q->whereRaw("LOWER(nama_role) LIKE '%dokter%'");
            })
            ->get();

        $temuDokters = TemuDokter::with('pet')->get();

        return view('admin.RekamMedis.edit', compact('rekammedi', 'dokters', 'temuDokters'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, RekamMedis $rekammedi)
    {
        $validated = $request->validate([
            'anamnesa' => ['required', 'string', 'min:3'],
            'temuan_klinis' => ['nullable', 'string'],
            'diagnosa' => ['nullable', 'string'],
            'dokter_pemeriksa' => ['required', 'integer'],
            'idreservasi_dokter' => ['required', 'integer'],
        ]);

        $rekammedi->update([
            'anamnesa' => $validated['anamnesa'],
            'temuan_klinis' => $validated['temuan_klinis'] ?? null,
            'diagnosa' => $validated['diagnosa'] ?? null,
            'dokter_pemeriksa' => $validated['dokter_pemeriksa'],
            'idreservasi_dokter' => $validated['idreservasi_dokter'],
        ]);

        return redirect()->route('admin.rekammedis.index')->with('success', 'Rekam medis berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(RekamMedis $rekammedi)
    {
        $rekammedi->delete();

        return redirect()->route('admin.rekammedis.index')->with('success', 'Rekam medis berhasil dihapus.');
    }
}
