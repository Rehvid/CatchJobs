<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class Admin
{

    public function handle(Request $request, Closure $next): Response
    {
        if (Auth::user() && Auth::user()->isAdmin()) {
            return $next($request);
        }

        return redirect('/')->with('error', 'You have not admin access');
    }
}
