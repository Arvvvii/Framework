<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CheckPerawatRole
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

        // Check if user has perawat role
        $hasPerawatRole = $user->roles()->where('nama_role', 'perawat')->exists();

        if (!$hasPerawatRole) {
            abort(403, 'Unauthorized. Perawat access required.');
        }

        return $next($request);
    }
}
