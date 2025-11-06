<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use App\Models\DataUser; 
use App\Models\Role;
use App\Models\RoleUser; 

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    */

    use AuthenticatesUsers;

    protected $redirectTo = '/';

    public function __construct()
    {
        $this->middleware('guest')->except('logout');
        $this->middleware('auth')->only('logout');
    }

    public function showLoginForm()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required|min:6',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }
        
        // Query Model DataUser
        $user = DataUser::with(['roleUsers' => function ($query) {
            $query->where('status', '1')->with('role');
        }])
            ->where('email', $request->input('email'))
            ->first();

        if (!$user) {
            return redirect()->back()
                ->withErrors(['email' => 'Email tidak ditemukan.'])
                ->withInput();
        }

        if (!Hash::check($request->password, $user->password)) {
            return redirect()->back()
                ->withErrors(['password' => 'Password salah.'])
                ->withInput();
        }

        // --- PENGAMBILAN DATA ROLE ---
        $activeRoleUser = $user->roleUsers->first();
        
        if (!$activeRoleUser || !$activeRoleUser->role) {
             return redirect()->back()->withErrors(['email' => 'No active role found'])->withInput();
        }

        $activeRoleID = $activeRoleUser->idrole;
        $activeRoleName = $activeRoleUser->role->nama_role;
        $activeStatus = $activeRoleUser->status;

        Auth::login($user); 

        // Simpan session user Kustom
        $request->session()->put([
            'user_id' => $user->iduser,
            'user_name' => $user->nama,
            'user_email' => $user->email,
            'user_role' => $activeRoleID,
            'user_role_name' => $activeRoleName,
            'user_status' => $activeStatus,
        ]);

        // PERBAIKAN REDIRECT UTAMA
        switch ((int)$activeRoleID) { // Cast ke integer untuk perbandingan aman
            case 1: // Administrator
                return redirect()->route('admin.dashboard')->with('success', 'Login Berhasil!');
            case 2: // Dokter
                return redirect()->route('dokter.dashboard')->with('success', 'Login Berhasil!');
            case 3: // PERAWAT (Perbaikan: Role ID 3 = Perawat)
                return redirect()->route('perawat.dashboard')->with('success', 'Login Berhasil!');
            case 4: // Resepsionis
                return redirect()->route('resepsionis.dashboard')->with('success', 'Login Berhasil!');
            case 5: // PEMILIK (Perbaikan: Role ID 5 = Pemilik)
                return redirect()->route('pemilik.dashboard')->with('success', 'Login Berhasil!');
            default:
                return redirect('/')->with('success', 'Login Berhasil!');
        }
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/')->with('success', 'Logged out successfully');
    }
}