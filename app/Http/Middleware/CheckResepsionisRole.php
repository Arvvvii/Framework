<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CheckResepsionisRole
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

        // Check if user has resepsionis role
        $hasResepsionisRole = $user->roles()->where('nama_role', 'resepsionis')->exists();

        if (!$hasResepsionisRole) {
            abort(403, 'Unauthorized. Resepsionis access required.');
        }

        return $next($request);
    }
}
