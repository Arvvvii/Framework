<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
// use App\Models\RekamMedis; // Hapus atau jadikan komentar
use App\Models\RoleUser; // Tetap diperlukan untuk create/edit form
use App\Models\TemuDokter; // Tetap diperlukan untuk create/edit form
use App\Models\RekamMedis; // use model for safe deletes
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB; // PENTING: Import DB
use Illuminate\Support\Facades\Schema;

class RekamMedisController extends Controller
{
    /**
     * Display a listing of the resource. (READ - Menggunakan JOIN)
     */
    public function index()
    {
        // GANTI: RekamMedis::with('temuDokter.pet.pemilik', 'temuDokter.pet.rasHewan', 'roleUser.user')->get();
        // MENGGUNAKAN QUERY BUILDER DENGAN MULTI-LEVEL JOIN
        // Build columns to select dynamically so we don't reference columns
        // that may be missing in some installations (no migrate).
        $selects = [
            'rm.*',
            'u.nama AS dokter_nama',
            'p.nama AS pet_nama',
            'pu.nama AS pemilik_nama',
            'rh.nama_ras AS ras_hewan_nama',
        ];

        // Avoid referencing specific `temu_dokter` columns that may not
        // exist in all installations. Select the entire `td.*` set so the
        // query doesn't fail; then handle missing properties in PHP.
        $selects[] = 'td.*';

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
            // Join ke User untuk mengambil nama pemilik (nama ada di tabel `user`)
            ->leftJoin('user AS pu', 'pm.iduser', '=', 'pu.iduser')
            
            // Join ke RasHewan
            ->leftJoin('ras_hewan AS rh', 'p.idras_hewan', '=', 'rh.idras_hewan')
            
            ->select($selects)
            // Exclude records where related pet or pemilik are soft-deleted
            ->where(function($q){
                $q->where('p.is_deleted', 0)->orWhereNull('p.is_deleted');
            })
            ->where(function($q){
                $q->where('pm.is_deleted', 0)->orWhereNull('pm.is_deleted');
            })
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
            // table `rekam_medis` in this project doesn't include timestamp columns
        ]);

        return redirect()->route('admin.rekammedis.index')->with('success', 'Rekam medis berhasil ditambahkan.');
    }

    /**
     * Display the specified resource. (SHOW)
     */
    public function show($idrekam_medis) // Model Binding diganti
    {
        $rekammedi = DB::table('rekam_medis AS rm')
                        ->leftJoin('temu_dokter AS td', 'rm.idreservasi_dokter', '=', 'td.idreservasi_dokter')
                        ->leftJoin('pet AS p', 'td.idpet', '=', 'p.idpet')
                        ->leftJoin('pemilik AS pm', 'p.idpemilik', '=', 'pm.idpemilik')
                        ->where('rm.idrekam_medis', $idrekam_medis)
                        ->where(function($q){
                            $q->where('p.is_deleted', 0)->orWhereNull('p.is_deleted');
                        })
                        ->where(function($q){
                            $q->where('pm.is_deleted', 0)->orWhereNull('pm.is_deleted');
                        })
                        ->select('rm.*')
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
        $rekammedi = DB::table('rekam_medis AS rm')
                        ->leftJoin('temu_dokter AS td', 'rm.idreservasi_dokter', '=', 'td.idreservasi_dokter')
                        ->leftJoin('pet AS p', 'td.idpet', '=', 'p.idpet')
                        ->leftJoin('pemilik AS pm', 'p.idpemilik', '=', 'pm.idpemilik')
                        ->where('rm.idrekam_medis', $idrekam_medis)
                        ->where(function($q){
                            $q->where('p.is_deleted', 0)->orWhereNull('p.is_deleted');
                        })
                        ->where(function($q){
                            $q->where('pm.is_deleted', 0)->orWhereNull('pm.is_deleted');
                        })
                        ->select('rm.*')
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
            ]);

        return redirect()->route('admin.rekammedis.index')->with('success', 'Rekam medis berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage. (DELETE)
     */
    public function destroy($idrekam_medis) // Model Binding diganti
    {
        try {
            $rekam = RekamMedis::findOrFail($idrekam_medis);
            // mark deleted if supported
            $rekam->markDeleted();
            return redirect()->route('admin.rekammedis.index')->with('success', 'Rekam medis berhasil dihapus.');
        } catch (\Exception $e) {
            return back()->with('error', 'Gagal menghapus rekam medis: ' . $e->getMessage());
        }
    }
}