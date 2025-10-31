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
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
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

    $user = DataUser::with(['roleUsers' => function ($query) {
        $query->where('status', '1');
    }, 'roleUsers.role'])
        ->where('email', $request->input('email'))
        ->first();

    if (!$user) {
        return redirect()->back()
            ->withErrors(['email' => 'Email tidak ditemukan.'])
            ->withInput();
    }

    // Cek password
    if (!Hash::check($request->password, $user->password)) {
        return redirect()->back()
            ->withErrors(['password' => 'Password salah.'])
            ->withInput();
    }

    // Login user ke session
    Auth::login($user);

    // Simpan session user
    $request->session()->put([
        'user_id' => $user->iduser,
        'user_name' => $user->nama,
        'user_email' => $user->email,
        'user_role' => $user->roleUsers[0]->idrole ?? 'user',
        'user_status' => $user->roleUsers[0]->status ?? 'active'
    ]);

    $userRole = $user->roleUsers[0]->idrole ?? null;

    switch ($userRole) {
        case 1: // administrator
            return redirect()->route('admin.dashboard')->with('success', 'Login Berhasil!');
            break;
        case 2: // dokter
            return redirect()->route('dokter.dashboard')->with('success', 'Login Berhasil!');
            break;
        case 3: // perawat
            return redirect()->route('perawat.dashboard')->with('success', 'Login Berhasil!');
            break;
        case 4: // resepsionis
            return redirect()->route('resepsionis.dashboard')->with('success', 'Login Berhasil!');
            break;
        case 5: // pemilik
            return redirect()->route('pemilik.dashboard')->with('success', 'Login Berhasil!');
            break;
        
        default:
            return redirect('/')->with('success', 'Login Berhasil!');
            break;
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