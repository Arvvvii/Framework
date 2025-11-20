<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
// use App\Models\Pemilik; // Hapus atau jadikan komentar
use App\Models\DataUser; // Tetap diperlukan untuk create/edit form
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB; // PENTING: Import DB

class PemilikController extends Controller
{
    /**
     * Display a listing of the resource. (READ - Menggunakan JOIN)
     */
    public function index()
    {
        // GANTI: $pemiliks = Pemilik::with('user')->get();
        // Menggunakan Query Builder dengan JOIN ke tabel user
        $pemiliks = DB::table('pemilik AS pm')
            ->leftJoin('user AS u', 'pm.iduser', '=', 'u.iduser')
            ->select('pm.*', 'u.nama AS user_nama', 'u.email AS user_email') // Ambil nama & email user
            ->get();
            
        return view('admin.Pemilik.index', compact('pemiliks'));
    }

    /**
     * Show the form for creating a new resource. (Helper data tetap Eloquent)
     */
    public function create()
    {
        $users = DataUser::all(); // Tetap pakai Eloquent untuk helper data
        return view('admin.Pemilik.create', compact('users'));
    }

    /**
     * Store a newly created resource in storage. (CREATE)
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'no_wa' => 'required|string|max:255',
            'alamat' => 'required|string|max:255',
            'iduser' => 'required|exists:user,iduser', // Perhatikan nama tabel di exists
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        // GANTI: Pemilik::create($request->only([...]));
        DB::table('pemilik')->insert($request->only(['no_wa', 'alamat', 'iduser']));

        return redirect()->route('admin.pemilik.index')->with('success', 'Pemilik created successfully.');
    }

    /**
     * Display the specified resource. (SHOW)
     */
    public function show($idpemilik) // Model Binding diganti
    {
        $pemilik = DB::table('pemilik')->where('idpemilik', $idpemilik)->first();
        if (!$pemilik) {
            abort(404);
        }
        return view('admin.Pemilik.show', compact('pemilik'));
    }

    /**
     * Show the form for editing the specified resource. (EDIT)
     */
    public function edit($idpemilik) // Model Binding diganti
    {
        $pemilik = DB::table('pemilik')->where('idpemilik', $idpemilik)->first();
        if (!$pemilik) {
            abort(404);
        }
        
        $users = DataUser::all();
        return view('admin.Pemilik.edit', compact('pemilik', 'users'));
    }

    /**
     * Update the specified resource in storage. (UPDATE)
     */
    public function update(Request $request, $idpemilik) // Model Binding diganti
    {
        $validator = Validator::make($request->all(), [
            'no_wa' => 'required|string|max:255',
            'alamat' => 'required|string|max:255',
            'iduser' => 'required|exists:user,iduser',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        // GANTI: $pemilik->update($request->only([...]));
        DB::table('pemilik')
            ->where('idpemilik', $idpemilik)
            ->update($request->only(['no_wa', 'alamat', 'iduser']));

        return redirect()->route('admin.pemilik.index')->with('success', 'Pemilik updated successfully.');
    }

    /**
     * Remove the specified resource from storage. (DELETE)
     */
    public function destroy($idpemilik) // Model Binding diganti
    {
        // GANTI: $pemilik->delete();
        DB::table('pemilik')->where('idpemilik', $idpemilik)->delete();

        return redirect()->route('admin.pemilik.index')->with('success', 'Pemilik deleted successfully.');
    }
}