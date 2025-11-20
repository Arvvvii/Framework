<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CheckDokterRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        if (!Auth::check()) {
            return redirect('/login');
        }

        $user = Auth::user();
        $userRole = session('user_role');

        // Check if user has dokter role (role ID 2)
        if ($userRole != 2) {
            abort(403, 'Unauthorized. Dokter access required.');
        }

        return $next($request);
    }
}
