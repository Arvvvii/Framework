<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
// use App\Models\RekamMedis; // Hapus atau jadikan komentar
use App\Models\RoleUser; // Tetap diperlukan untuk create/edit form
use App\Models\TemuDokter; // Tetap diperlukan untuk create/edit form
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB; // PENTING: Import DB

class RekamMedisController extends Controller
{
    /**
     * Display a listing of the resource. (READ - Menggunakan JOIN)
     */
    public function index()
    {
        // GANTI: RekamMedis::with('temuDokter.pet.pemilik', 'temuDokter.pet.rasHewan', 'roleUser.user')->get();
        // MENGGUNAKAN QUERY BUILDER DENGAN MULTI-LEVEL JOIN
        $rekamMedis = DB::table('rekam_medis AS rm')
            // Join ke RoleUser (untuk mendapatkan dokter/user pemeriksa)
            ->leftJoin('role_user AS ru', 'rm.dokter_pemeriksa', '=', 'ru.idrole_user')
            ->leftJoin('user AS u', 'ru.iduser', '=', 'u.iduser') // Ganti datauser menjadi user

            // Join ke TemuDokter (Reservasi)
            ->leftJoin('temu_dokter AS td', 'rm.idreservasi_dokter', '=', 'td.idreservasi_dokter')
            
            // Join ke Pet
            ->leftJoin('pet AS p', 'td.idpet', '=', 'p.idpet')
            
            // Join ke Pemilik
            ->leftJoin('pemilik AS pm', 'p.idpemilik', '=', 'pm.idpemilik')
            
            // Join ke RasHewan
            ->leftJoin('ras_hewan AS rh', 'p.idras_hewan', '=', 'rh.idras_hewan')
            
            ->select('rm.*', // Ambil semua data rekam medis
                'u.nama AS dokter_nama', // Nama Dokter Pemeriksa
                'p.nama AS pet_nama', // Nama Pet
                'pm.idpemilik AS pemilik_id', // ID Pemilik
                'rh.nama_ras AS ras_hewan_nama' // Nama Ras Hewan
            )
            ->get();
            
        // CATATAN: View Rekam Medis (index.blade.php) harus diubah untuk menggunakan nama kolom baru ini 
        // Contoh: {{ $rekam->dokter_nama }}, {{ $rekam->pet_nama }}
        return view('admin.RekamMedis.index', compact('rekamMedis'));
    }

    /**
     * Show the form for creating a new resource. (Helper data tetap Eloquent)
     */
    public function create()
    {
        // Data helper tetap Eloquent
        $dokters = RoleUser::with('user', 'role')
            ->where('status', '1')
            ->whereHas('role', function ($q) {
                $q->whereRaw("LOWER(nama_role) LIKE '%dokter%'");
            })
            ->get();

        $temuDokters = TemuDokter::with('pet')->get();

        return view('admin.RekamMedis.create', compact('dokters', 'temuDokters'));
    }

    /**
     * Store a newly created resource in storage. (CREATE)
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'anamnesa' => ['required', 'string', 'min:3'],
            'temuan_klinis' => ['nullable', 'string'],
            'diagnosa' => ['nullable', 'string'],
            'dokter_pemeriksa' => ['required', 'integer'], 
            'idreservasi_dokter' => ['required', 'integer'],
        ]);

        // GANTI: RekamMedis::create([...]);
        DB::table('rekam_medis')->insert([
            'anamnesa' => $validated['anamnesa'],
            'temuan_klinis' => $validated['temuan_klinis'] ?? null,
            'diagnosa' => $validated['diagnosa'] ?? null,
            'dokter_pemeriksa' => $validated['dokter_pemeriksa'],
            'idreservasi_dokter' => $validated['idreservasi_dokter'],
            'created_at' => now(), // Tambahkan manual jika kolom ada
            'updated_at' => now(), // Tambahkan manual jika kolom ada
        ]);

        return redirect()->route('admin.rekammedis.index')->with('success', 'Rekam medis berhasil ditambahkan.');
    }

    /**
     * Display the specified resource. (SHOW)
     */
    public function show($idrekam_medis) // Model Binding diganti
    {
        $rekammedi = DB::table('rekam_medis')
                        ->where('idrekam_medis', $idrekam_medis)
                        ->first();
                        
        if (!$rekammedi) {
            abort(404);
        }
        return view('admin.RekamMedis.show', compact('rekammedi'));
    }

    /**
     * Show the form for editing the specified resource. (EDIT)
     */
    public function edit($idrekam_medis) // Model Binding diganti
    {
        $rekammedi = DB::table('rekam_medis')
                        ->where('idrekam_medis', $idrekam_medis)
                        ->first();
                        
        if (!$rekammedi) {
            abort(404);
        }
        
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
     * Update the specified resource in storage. (UPDATE)
     */
    public function update(Request $request, $idrekam_medis) // Model Binding diganti
    {
        $validated = $request->validate([
            'anamnesa' => ['required', 'string', 'min:3'],
            'temuan_klinis' => ['nullable', 'string'],
            'diagnosa' => ['nullable', 'string'],
            'dokter_pemeriksa' => ['required', 'integer'],
            'idreservasi_dokter' => ['required', 'integer'],
        ]);

        // GANTI: $rekammedi->update([...]);
        DB::table('rekam_medis')
            ->where('idrekam_medis', $idrekam_medis)
            ->update([
                'anamnesa' => $validated['anamnesa'],
                'temuan_klinis' => $validated['temuan_klinis'] ?? null,
                'diagnosa' => $validated['diagnosa'] ?? null,
                'dokter_pemeriksa' => $validated['dokter_pemeriksa'],
                'idreservasi_dokter' => $validated['idreservasi_dokter'],
                'updated_at' => now(), // Tambahkan manual jika kolom ada
            ]);

        return redirect()->route('admin.rekammedis.index')->with('success', 'Rekam medis berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage. (DELETE)
     */
    public function destroy($idrekam_medis) // Model Binding diganti
    {
        // GANTI: $rekammedi->delete();
        DB::table('rekam_medis')->where('idrekam_medis', $idrekam_medis)->delete();

        return redirect()->route('admin.rekammedis.index')->with('success', 'Rekam medis berhasil dihapus.');
    }
}