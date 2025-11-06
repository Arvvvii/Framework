<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class CheckPerawatRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        if (!auth()->check()) {
            return redirect()->route('login');
        }

        $user = auth()->user();
        $hasPerawat = false;

        // Check the authenticated user's roleUsers relation for a perawat role.
        // Historically the perawat role id was 3 in other parts of the app, while this
        // middleware previously checked for id == 5. To be robust we accept either
        // a matching id (3) or a role name 'Perawat' (case-insensitive). Also respect
        // the roleUser status if present (require '1' or missing).
        if ($user && isset($user->roleUsers)) {
            foreach ($user->roleUsers as $ru) {
                $isPerawatById = isset($ru->idrole) && (int)$ru->idrole === 3; // fallback id used elsewhere
                $isPerawatByName = isset($ru->role) && isset($ru->role->nama_role) && strtolower($ru->role->nama_role) === 'perawat';

                if ($isPerawatById || $isPerawatByName) {
                    // if status is set, require it to be '1'
                    if (!isset($ru->status) || $ru->status == '1') {
                        $hasPerawat = true;
                        break;
                    }
                }
            }
        }

        // Debug log: include session fallback for easier debugging
        \Log::info('PerawatMiddleware - user_id: ' . ($user->iduser ?? 'null') . ' hasPerawat:' . ($hasPerawat ? '1' : '0') . ' session_role:' . session('user_role'));

        // Allow if the user has perawat role or session explicitly set to a perawat id/name
        $sessionIsPerawat = (int) session('user_role') === 3 || strtolower(session('user_role_name') ?? '') === 'perawat';

        if (!$hasPerawat && !$sessionIsPerawat) {
            abort(403, 'Unauthorized. Perawat access required.');
        }

        return $next($request);
    }
}