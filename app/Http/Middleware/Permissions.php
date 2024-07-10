<?php

namespace App\Http\Middleware;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

class Permissions
{
    /**
     * Handle an incoming request.
     *
     * @param \Illuminate\Http\Request $request
     */
    public function handle($request, \Closure $next)
    {
        if (Auth::user()->role == '1' || Auth::user()->role == '2' && kvfj(Auth::user()->permissions, Route::currentRouteName()) == true) {
            return $next($request);
        } else {
            return redirect('/');
        }
    }
}
