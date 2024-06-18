<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CheckRole
{
    public function handle(Request $request, Closure $next, ...$roles)
    {
     
        $user = Auth::user();
        if (!in_array($user->role, $roles)) {
            return redirect('/home')->with('error', 'No tienes permiso para acceder a esta página.');
        }

        return $next($request);
    }
}
