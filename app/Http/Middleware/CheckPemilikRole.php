<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CheckPemilikRole
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

        // Check if user has pemilik role
        $hasPemilikRole = $user->roles()->where('nama_role', 'pemilik')->exists();

        if (!$hasPemilikRole) {
            abort(403, 'Unauthorized. Pemilik access required.');
        }

        return $next($request);
    }
}
