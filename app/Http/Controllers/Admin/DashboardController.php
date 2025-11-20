<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
// Hapus atau jadikan komentar semua import Model
// use App\Models\DataUser;
// use App\Models\Role;
// use App\Models\Pet;
// ... dan Model lainnya
use Illuminate\Support\Facades\DB; // PENTING: Hanya butuh DB

class DashboardController extends Controller
{
    /**
     * Display the admin dashboard.
     */
    public function index()
    {
        // GANTI: Menggunakan Query Builder untuk semua operasi count
        $stats = [
            'total_users' => DB::table('user')->count(),
            'total_roles' => DB::table('role')->count(),
            'total_pets' => DB::table('pet')->count(),
            'total_pemilik' => DB::table('pemilik')->count(),
            'total_kategori' => DB::table('kategori')->count(),
            'total_kategori_klinis' => DB::table('kategori_klinis')->count(),
            'total_jenis_hewan' => DB::table('jenis_hewan')->count(),
            'total_ras_hewan' => DB::table('ras_hewan')->count(),
            'total_kode_terapi' => DB::table('kode_tindakan_terapi')->count(),
        ];

        // GANTI: Menggunakan Query Builder untuk recent activities (read)
        $recent_users = DB::table('user')->orderBy('iduser', 'desc')->limit(5)->get();
        
        // Untuk Pet, jika butuh pemiliknya, harus pakai JOIN
        $recent_pets = DB::table('pet AS p')
            ->leftJoin('pemilik AS pm', 'p.idpemilik', '=', 'pm.idpemilik')
            ->select('p.*', 'pm.no_wa AS pemilik_no_wa', 'pm.alamat AS pemilik_alamat') // Ambil data pemilik
            ->orderBy('idpet', 'desc')
            ->limit(5)
            ->get();

        // CATATAN: View dashboard harus diubah untuk membaca nama kolom JOIN (misalnya $pet->pemilik_no_wa)
        return view('admin.dashboard', compact('stats', 'recent_users', 'recent_pets'));
    }
}