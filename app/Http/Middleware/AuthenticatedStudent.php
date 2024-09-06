<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;

class AuthenticatedStudent
{
    public function handle(Request $request, Closure $next): mixed
    {
        if (!Auth::guard('students')->check()) {
            return Redirect::route('students.login');
        }

        return $next($request);
    }
}
