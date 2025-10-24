<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Pemilik;
use App\Models\DataUser;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class PemilikController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $pemiliks = Pemilik::with('user')->get();
        return view('admin.Pemilik.index', compact('pemiliks'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $users = DataUser::all();
        return view('admin.Pemilik.create', compact('users'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'no_wa' => 'required|string|max:255',
            'alamat' => 'required|string|max:255',
            'iduser' => 'required|exists:DataUser,idDataUser',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        Pemilik::create($request->only(['no_wa', 'alamat', 'iduser']));

        return redirect()->route('admin.pemilik.index')->with('success', 'Pemilik created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Pemilik $pemilik)
    {
        $pemilik->load('user');
        return view('admin.Pemilik.show', compact('pemilik'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Pemilik $pemilik)
    {
        $users = DataUser::all();
        return view('admin.Pemilik.edit', compact('pemilik', 'users'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Pemilik $pemilik)
    {
        $validator = Validator::make($request->all(), [
            'no_wa' => 'required|string|max:255',
            'alamat' => 'required|string|max:255',
            'iduser' => 'required|exists:DataUser,idDataUser',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $pemilik->update($request->only(['no_wa', 'alamat', 'iduser']));

        return redirect()->route('admin.pemilik.index')->with('success', 'Pemilik updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Pemilik $pemilik)
    {
        $pemilik->delete();

        return redirect()->route('admin.pemilik.index')->with('success', 'Pemilik deleted successfully.');
    }
}
