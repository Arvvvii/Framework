<?php

namespace App\Http\Controllers\Perawat;

use App\Http\Controllers\Controller;
use App\Models\RekamMedis;
use Illuminate\Http\Request;
use App\Models\TemuDokter;
use Illuminate\Support\Facades\DB;

class RekamMedisController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index($pet = null)
    {
        if ($pet) {
            $rekamMedis = RekamMedis::whereHas('temuDokter', function($q) use ($pet) {
                $q->where('idpet', $pet);
            })->with('temuDokter.pet.pemilik.user', 'temuDokter.pet.rasHewan', 'roleUser.user')->get();
            $petData = \App\Models\Pet::with('pemilik.user', 'rasHewan.jenisHewan')->find($pet);
            return view('perawat.RekamMedis.index', compact('rekamMedis', 'petData'));
        }

        $rekamMedis = RekamMedis::with('temuDokter.pet.pemilik', 'temuDokter.pet.rasHewan', 'roleUser.user')
            ->orderBy('created_at', 'desc')
            ->get();

        // Also load reservations (temu_dokter) for pets that never had any rekam_medis
        // This prevents showing 'Buat Rekam Medis' for pets that already have at least one rekam_medis
        $newReservations = TemuDokter::with('pet.pemilik.user', 'pet.rasHewan')
            ->whereDoesntHave('pet.rekamMedis')
            ->orderBy('waktu_daftar', 'desc')
            ->get();

        return view('perawat.RekamMedis.index', compact('rekamMedis', 'newReservations'));
    }

    /**
     * Display single rekam medis for viewing (perawat)
     */
    public function show($rekamMedisId)
    {
        $rekamMedis = RekamMedis::with('temuDokter.pet.pemilik.user', 'temuDokter.pet.rasHewan', 'roleUser.user', 'detailRekamMedis.kodeTindakanTerapi')->findOrFail($rekamMedisId);
        return view('perawat.RekamMedis.show', compact('rekamMedis'));
    }

    /**
     * Show create form for rekam medis (perawat)
     */
    public function create(Request $request)
    {
        $temuDokters = TemuDokter::with('pet.pemilik.user')->get();

        // allow preselecting a reservation via query param ?idreservasi=123
        $selectedReservasi = $request->query('idreservasi');

        return view('perawat.RekamMedis.create', compact('temuDokters', 'selectedReservasi'));
    }

    /**
     * Store a newly created rekam medis in storage.
     */
    public function store(Request $request)
    {
        // log entire request for debugging (will not log files)
        \Log::info('Perawat\RekamMedisController@store input', $request->except(['_token']));

        $request->validate([
            'idreservasi_dokter' => 'required|exists:temu_dokter,idreservasi_dokter',
            'anamnesa' => 'nullable|string',
            'temuan_klinis' => 'nullable|string',
            'diagnosa' => 'nullable|string',
        ]);

        // determine doctor assigned to the selected reservation (if any)
        $temu = \App\Models\TemuDokter::find($request->input('idreservasi_dokter'));
        $assignedDoctorRoleUserId = $temu->idrole_user ?? null;

        try {
            $rekam = RekamMedis::create([
                'idreservasi_dokter' => $request->input('idreservasi_dokter'),
                'anamnesa' => $request->input('anamnesa'),
                'temuan_klinis' => $request->input('temuan_klinis'),
                'diagnosa' => $request->input('diagnosa'),
                // assign the dokter_pemeriksa based on the reservation's assigned role_user (doctor),
                // do NOT use the currently authenticated perawat's role_user id here.
                'dokter_pemeriksa' => $assignedDoctorRoleUserId,
            ]);

            return redirect()->route('perawat.rekammedis.index')->with('success', 'Rekam medis berhasil dibuat.');
        } catch (\Exception $e) {
            // Log the error and show a friendly message with the actual DB error for debugging
            \Log::error('Gagal membuat rekam medis: ' . $e->getMessage());
            return back()->withInput()->with('error', 'Gagal menambahkan rekam medis: ' . $e->getMessage());
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($rekamMedisId)
    {
        $rekamMedis = RekamMedis::findOrFail($rekamMedisId);
        $temuDokters = TemuDokter::with('pet.pemilik.user')->get();
        return view('perawat.RekamMedis.edit', compact('rekamMedis', 'temuDokters'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $rekamMedisId)
    {
        $request->validate([
            'idreservasi_dokter' => 'required|exists:temu_dokter,idreservasi_dokter',
            'anamnesa' => 'nullable|string',
            'temuan_klinis' => 'nullable|string',
            'diagnosa' => 'nullable|string',
        ]);

        $rekam = RekamMedis::findOrFail($rekamMedisId);
        $rekam->update([
            'idreservasi_dokter' => $request->input('idreservasi_dokter'),
            'anamnesa' => $request->input('anamnesa'),
            'temuan_klinis' => $request->input('temuan_klinis'),
            'diagnosa' => $request->input('diagnosa'),
        ]);

        return redirect()->route('perawat.rekammedis.index')->with('success', 'Rekam medis berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($rekamMedisId)
    {
        $rekam = RekamMedis::findOrFail($rekamMedisId);
        $rekam->delete();
        return redirect()->route('perawat.rekammedis.index')->with('success', 'Rekam medis berhasil dihapus.');
    }
}
