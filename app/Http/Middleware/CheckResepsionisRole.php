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

        // Check if user has resepsionis role (role ID 4)
        if (session('user_role') != 4) {
            abort(403, 'Unauthorized. Resepsionis access required.');
        }

        return $next($request);
    }
}
