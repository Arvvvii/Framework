<?php

namespace App\Http\Controllers\Resepsionis;

use App\Http\Controllers\Controller;
use App\Models\TemuDokter;
use App\Models\Pet;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Carbon\Carbon;

class TemuDokterController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $temuDokter = TemuDokter::with('pet.pemilik.user', 'pet.rasHewan', 'rekamMedis')
            ->orderBy('waktu_daftar', 'desc')
            ->get();

        // Antrian hari ini (urut berdasarkan no_urut jika ada)
        $today = Carbon::today();
        $antrianHariIni = TemuDokter::with('pet.pemilik.user', 'pet.rasHewan')
            ->whereDate('waktu_daftar', $today)
            ->orderBy('no_urut')
            ->orderBy('waktu_daftar')
            ->get();

        return view('resepsionis.TemuDokter.index', compact('temuDokter', 'antrianHariIni'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // Hanya tampilkan pet yang masih valid: punya pemilik aktif dan ras hewan yang tidak dihapus
        $pets = Pet::with('pemilik.user', 'rasHewan')
            ->whereHas('pemilik')
            ->whereHas('rasHewan')
            ->get();
        // Ambil semua role_user yang merupakan dokter (idrole = 2) beserta relasi user
        $dokters = \App\Models\RoleUser::with('user')->where('idrole', 2)->where('status', 1)->get();
        return view('resepsionis.TemuDokter.create', compact('pets', 'dokters'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'id_pet' => 'required|exists:pet,idpet',
            // wajib pilih dokter aktif (role=2, status=1)
            'idrole_user_dokter' => [
                'required',
                Rule::exists('role_user', 'idrole_user')->where(function($q){
                    $q->where('idrole', 2)->where('status', 1);
                }),
            ],
        ]);

        // gunakan waktu saat ini sebagai waktu daftar
        $now = Carbon::now();
        $tanggal = $now->toDateString();
        // hitung nomor urut per tanggal saat ini
        $maxUrut = TemuDokter::whereDate('waktu_daftar', $tanggal)->max('no_urut');
        $nextNoUrut = (int)($maxUrut ?? 0) + 1;

        TemuDokter::create([
            'idpet' => $request->id_pet,
            'waktu_daftar' => $now,
            'idrole_user' => $request->idrole_user_dokter,
            'no_urut' => $nextNoUrut,
            'status' => '1', // default to '1' (Menunggu)
        ]);

        return redirect()->route('resepsionis.temudokter.index')->with('success', 'Temu dokter berhasil dibuat!');
    }

    /**
     * Cancel (delete) the specified resource.
     */
    public function destroy($id)
    {
        $temuDokter = TemuDokter::findOrFail($id);
        $temuDokter->delete();

        return redirect()->route('resepsionis.temudokter.index')->with('success', 'Temu dokter berhasil dibatalkan!');
    }
}
