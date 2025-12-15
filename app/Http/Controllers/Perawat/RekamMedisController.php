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
            ->where('status', 1) // hanya reservasi menunggu
            ->whereDoesntHave('pet.rekamMedis')
            // hanya reservasi yang menunjuk RoleUser dokter aktif (idrole=2, status=1)
            ->whereHas('roleUser', function($q){
                $q->where('idrole', 2)->where('status', 1);
            })
            ->orderBy('waktu_daftar', 'desc')
            ->get()
            // there may be multiple reservations for the same pet without rekam_medis;
            // show only the most recent reservation per pet to avoid duplicate "Buat Rekam Medis" buttons
            ->unique('idpet')
            ->values();

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
        // Hanya tampilkan reservasi dengan RoleUser dokter aktif
        $temuDokters = TemuDokter::with('pet.pemilik.user')
            ->where('status', 1)
            ->whereHas('roleUser', function($q){
                $q->where('idrole', 2)->where('status', 1);
            })
            ->get();

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

        // Tentukan dokter yang ditugaskan pada reservasi
        $temu = \App\Models\TemuDokter::with('roleUser.role')->find($request->input('idreservasi_dokter'));
        $assignedDoctorRoleUserId = $temu->idrole_user ?? null;

        // Validasi: pastikan role yang ditugaskan adalah DOKTER (idrole = 2)
        if ($assignedDoctorRoleUserId && optional($temu->roleUser)->idrole !== 2) {
            return back()->withInput()->with('error', 'Reservasi ini tidak menunjuk RoleUser dokter yang valid. Mohon pilih reservasi dengan dokter (role id = 2).');
        }

        try {
            $rekam = RekamMedis::create([
                'idreservasi_dokter' => $request->input('idreservasi_dokter'),
                'anamnesa' => $request->input('anamnesa'),
                'temuan_klinis' => $request->input('temuan_klinis'),
                'diagnosa' => $request->input('diagnosa'),
                'dokter_pemeriksa' => $assignedDoctorRoleUserId,
            ]);

            // Update status temu_dokter menjadi 'Selesai' (3)
            if ($temu) {
                $temu->status = 3;
                $temu->save();
            }

            return redirect()->route('perawat.rekammedis.index')->with('success', 'Rekam medis berhasil dibuat.');
        } catch (\Exception $e) {
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
        // Dropdown reservasi juga dibatasi ke dokter aktif
        $temuDokters = TemuDokter::with('pet.pemilik.user')
            ->where('status', 1)
            ->whereHas('roleUser', function($q){
                $q->where('idrole', 2)->where('status', 1);
            })
            ->get();
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
