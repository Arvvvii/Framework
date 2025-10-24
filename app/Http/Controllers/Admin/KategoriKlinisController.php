<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\KategoriKlinis;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class KategoriKlinisController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $kategorikliniss = KategoriKlinis::all();
        return view('admin.KategoriKlinis.index', compact('kategorikliniss'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.KategoriKlinis.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nama_kategori_klinis' => 'required|string|max:255|unique:kategori_klinis,nama_kategori_klinis',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        KategoriKlinis::create($request->only(['nama_kategori_klinis']));

        return redirect()->route('admin.kategoriklinis.index')->with('success', 'KategoriKlinis created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(KategoriKlinis $kategoriklinis)
    {
        return view('admin.KategoriKlinis.show', compact('kategoriklinis'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(KategoriKlinis $kategoriklinis)
    {
        return view('admin.KategoriKlinis.edit', compact('kategoriklinis'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, KategoriKlinis $kategoriklinis)
    {
        $validator = Validator::make($request->all(), [
            'nama_kategori_klinis' => 'required|string|max:255|unique:kategori_klinis,nama_kategori_klinis,' . $kategoriklinis->idkategori_klinis . ',idkategori_klinis',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $kategoriklinis->update($request->only(['nama_kategori_klinis']));

        return redirect()->route('admin.kategoriklinis.index')->with('success', 'KategoriKlinis updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(KategoriKlinis $kategoriklinis)
    {
        $kategoriklinis->delete();

        return redirect()->route('admin.kategoriklinis.index')->with('success', 'KategoriKlinis deleted successfully.');
    }
}
