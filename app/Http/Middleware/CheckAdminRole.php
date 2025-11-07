<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Role;

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

        // Prefer checking session-stored role id (set at login) for performance and
        // to avoid string-case mismatches. Fall back to checking roles relation.
        $sessionRoleId = session('user_role');

        if ($sessionRoleId) {
            // If a session role id exists, verify via the roles table whether
            // that id corresponds to an administrator role. This allows the
            // admin to work even if the administrator's id is not literally 1.
            $role = Role::find($sessionRoleId);

            if ($role && in_array(strtolower($role->nama_role), ['administrator', 'admin'])) {
                return $next($request);
            }

            // Not an admin role according to DB
            abort(403, 'Unauthorized. Admin access required.');
        }

        // Fallback: check role name case-insensitively to avoid capitalization issues
        $hasAdminRole = $user->roles()->get()->contains(function ($role) {
            return strtolower($role->nama_role) === 'administrator' || strtolower($role->nama_role) === 'admin';
        });

        if (!$hasAdminRole) {
            abort(403, 'Unauthorized. Admin access required.');
        }

        return $next($request);
    }
}
