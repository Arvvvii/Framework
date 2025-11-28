<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\TemuDokter;
use App\Models\Pet;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Schema;

class TemuDokterController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
                // Eager-load relations. For admin list we want to show the original
                // pet/pemilik data even when those records were soft-flagged by
                // resepsionis (is_deleted). So we explicitly remove the global
                // "is_deleted" scope for the relation queries here to surface the
                // related rows for auditing. Other admin actions (create/edit) still
                // use the normal lists that exclude flagged pets.
                $temuDokter = TemuDokter::with([
                        'pet' => function ($q) {
                                // load pet including flagged rows
                                $q->withoutGlobalScope('is_deleted')
                                    ->with(['pemilik' => function ($q2) {
                                            $q2->withoutGlobalScope('is_deleted')->with('user');
                                    }, 'rasHewan']);
                        },
                        'rekamMedis',
                        'roleUser.user'
                ])->orderBy('waktu_daftar', 'desc')
                    ->get();
        
        // Compute a displayable keluhan for each record. This chooses:
        // 1) the `keluhan` column if present and not empty
        // 2) fallback to the first related rekamMedis->anamnesa
        // 3) null if neither exists
        foreach ($temuDokter as $td) {
            $kel = null;
            if (\Illuminate\Support\Facades\Schema::hasColumn('temu_dokter', 'keluhan')) {
                $kel = trim((string) ($td->keluhan ?? '')) ?: null;
            }

            // If keluhan is not present, try to use the latest related RekamMedis
            // (some reservations may have multiple rekam_medis records). Use
            // orderBy to pick the newest entry.
            if (!$kel) {
                $latestRekam = $td->rekamMedis()->orderByDesc('idrekam_medis')->first();
                $kel = optional($latestRekam)->anamnesa;
            }

            $td->display_keluhan = $kel;

            // compute dokter name from roleUser->user relation if available
            $td->dokter_name = optional(optional($td->roleUser)->user)->nama;
        }
        
        return view('admin.TemuDokter.index', compact('temuDokter'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $pets = Pet::with('pemilik.user', 'rasHewan')->get();
        // Ambil daftar dokter (role_user yang berperan sebagai dokter)
        $dokters = \App\Models\RoleUser::with('user', 'role')
            ->where('status', '1')
            ->whereHas('role', function ($q) {
                $q->whereRaw("LOWER(nama_role) LIKE '%dokter%'");
            })
            ->get();

        return view('admin.TemuDokter.create', compact('pets', 'dokters'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'idpet' => 'required|exists:pet,idpet',
            'waktu_daftar' => 'required|date',
            'idrole_user' => 'nullable|integer',
        ]);

        $payload = [
            'idpet' => $request->idpet,
            'waktu_daftar' => $request->waktu_daftar,
            'idrole_user' => $request->input('idrole_user') ?: null,
        ];

        // only include keluhan if column exists (backwards-compatibility)
        if (Schema::hasColumn('temu_dokter', 'keluhan') && $request->filled('keluhan')) {
            $payload['keluhan'] = $request->keluhan;
        }

        TemuDokter::create($payload);

        return redirect()->route('admin.temudokter.index')->with('success', 'Temu dokter berhasil dibuat!');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $temuDokter = TemuDokter::findOrFail($id);
        $pets = Pet::with('pemilik.user', 'rasHewan')->get();
        $dokters = \App\Models\RoleUser::with('user', 'role')
            ->where('status', '1')
            ->whereHas('role', function ($q) {
                $q->whereRaw("LOWER(nama_role) LIKE '%dokter%'");
            })
            ->get();

        $currentDokterId = $temuDokter->idrole_user ?? null;

        return view('admin.TemuDokter.edit', compact('temuDokter', 'pets', 'dokters', 'currentDokterId'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'idpet' => 'required|exists:pet,idpet',
            'waktu_daftar' => 'required|date',
            'idrole_user' => 'nullable|integer',
        ]);

        $temuDokter = TemuDokter::findOrFail($id);

        $updateData = [
            'idpet' => $request->idpet,
            'waktu_daftar' => $request->waktu_daftar,
            'idrole_user' => $request->input('idrole_user') ?: null,
        ];

        if (Schema::hasColumn('temu_dokter', 'keluhan') && $request->filled('keluhan')) {
            $updateData['keluhan'] = $request->keluhan;
        }

        $temuDokter->update($updateData);

        return redirect()->route('admin.temudokter.index')->with('success', 'Temu dokter berhasil diupdate!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $temuDokter = TemuDokter::findOrFail($id);
        $temuDokter->delete();

        return redirect()->route('admin.temudokter.index')->with('success', 'Temu dokter berhasil dihapus!');
    }
}
