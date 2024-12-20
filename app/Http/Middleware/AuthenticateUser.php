<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthenticateUser
{
    public function handle(Request $request, Closure $next)
    {
        if (Auth::guard('user_api')->check()) {
            // print_r(Auth::guard('driver_api')->user());die;
            return $next($request);
        }

        return response()->json(['message' => 'Unauthorized'], 401);
    }
}

