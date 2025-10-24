<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\KodeTindakanTerapi;
use App\Models\Kategori;
use App\Models\KategoriKlinis;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class KodeTindakanTerapiController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $kodeterapis = KodeTindakanTerapi::with('kategori', 'kategoriKlinis')->get();
        return view('admin.KodeTindakanTerapi.index', compact('kodeterapis'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $kategoris = Kategori::all();
        $kategorikliniss = KategoriKlinis::all();
        return view('admin.KodeTindakanTerapi.create', compact('kategoris', 'kategorikliniss'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'kode' => 'required|string|max:255|unique:kode_tindakan_terapi,kode',
            'deskripsi_tindakan_terapi' => 'required|string|max:255',
            'idkategori' => 'required|exists:kategori,idkategori',
            'idkategori_klinis' => 'required|exists:kategori_klinis,idkategori_klinis',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        KodeTindakanTerapi::create($request->only(['kode', 'deskripsi_tindakan_terapi', 'idkategori', 'idkategori_klinis']));

        return redirect()->route('admin.kodeterapi.index')->with('success', 'KodeTindakanTerapi created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(KodeTindakanTerapi $kodeterapi)
    {
        $kodeterapi->load('kategori', 'kategoriKlinis');
        return view('admin.KodeTindakanTerapi.show', compact('kodeterapi'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(KodeTindakanTerapi $kodeterapi)
    {
        $kategoris = Kategori::all();
        $kategorikliniss = KategoriKlinis::all();
        return view('admin.KodeTindakanTerapi.edit', compact('kodeterapi', 'kategoris', 'kategorikliniss'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, KodeTindakanTerapi $kodeterapi)
    {
        $validator = Validator::make($request->all(), [
            'kode' => 'required|string|max:255|unique:kode_tindakan_terapi,kode,' . $kodeterapi->idkode_tindakan_terapi . ',idkode_tindakan_terapi',
            'deskripsi_tindakan_terapi' => 'required|string|max:255',
            'idkategori' => 'required|exists:kategori,idkategori',
            'idkategori_klinis' => 'required|exists:kategori_klinis,idkategori_klinis',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $kodeterapi->update($request->only(['kode', 'deskripsi_tindakan_terapi', 'idkategori', 'idkategori_klinis']));

        return redirect()->route('admin.kodeterapi.index')->with('success', 'KodeTindakanTerapi updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(KodeTindakanTerapi $kodeterapi)
    {
        $kodeterapi->delete();

        return redirect()->route('admin.kodeterapi.index')->with('success', 'KodeTindakanTerapi deleted successfully.');
    }
}
