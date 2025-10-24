<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\DataUser;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;

class DataUserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $datausers = DataUser::all();
        return view('admin.DataUser.index', compact('datausers'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.DataUser.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nama' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:DataUser,email',
            'password' => 'required|string|min:8|confirmed',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        DataUser::create([
            'nama' => $request->nama,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        return redirect()->route('admin.datauser.index')->with('success', 'DataUser created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(DataUser $datauser)
    {
        return view('admin.DataUser.show', compact('datauser'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(DataUser $datauser)
    {
        return view('admin.DataUser.edit', compact('datauser'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, DataUser $datauser)
    {
        $validator = Validator::make($request->all(), [
            'nama' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:DataUser,email,' . $datauser->idDataUser . ',idDataUser',
            'password' => 'nullable|string|min:8|confirmed',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $data = [
            'nama' => $request->nama,
            'email' => $request->email,
        ];

        if ($request->filled('password')) {
            $data['password'] = Hash::make($request->password);
        }

        $datauser->update($data);

        return redirect()->route('admin.datauser.index')->with('success', 'DataUser updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(DataUser $datauser)
    {
        $datauser->delete();

        return redirect()->route('admin.datauser.index')->with('success', 'DataUser deleted successfully.');
    }
}
