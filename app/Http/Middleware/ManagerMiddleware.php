<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ManagerMiddleware
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
        $user_roles = Auth::user()->roles;
        if ($user_roles == 'superadmin' || $user_roles == 'manager') {
            return $next($request);
        } else {
            abort(403);
            
        }
        // if (Auth::guest() || Auth::user()->roles == 'pendaftar' || Auth::user()->roles == 'kasir') {
        //     return redirect('/');
        // } else {
        //     return $next($request);
        // }
    }
}
