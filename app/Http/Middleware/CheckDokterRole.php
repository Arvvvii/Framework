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

        // Check if user has dokter role
        $hasDokterRole = $user->roles()->where('nama_role', 'dokter')->exists();

        if (!$hasDokterRole) {
            abort(403, 'Unauthorized. Dokter access required.');
        }

        return $next($request);
    }
}
