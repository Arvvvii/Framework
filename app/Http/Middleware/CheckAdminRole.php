<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CheckAdminRole
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

        // Check if user has administrator role
        $hasAdminRole = $user->roles()->where('nama_role', 'administrator')->exists();

        if (!$hasAdminRole) {
            abort(403, 'Unauthorized. Admin access required.');
        }

        return $next($request);
    }
}
