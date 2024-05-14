<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class RoleMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
     public function handle($request, Closure $next, $role)
    {
          if (!Auth::check()) {
            return redirect('/login');
        }

        $user = Auth::user();
        
        if (!$user->hasRole($role)) {
            Auth::logout(); // detach user from session
            abort(403, 'Unauthorized action.'); // return 403 error
        }

        return $next($request);
    }
}
