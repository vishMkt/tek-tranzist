<?php
namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class EnsureJsonResponse
{
    public function handle(Request $request, Closure $next)
    {
        $response = $next($request);

        if ($response instanceof \Illuminate\Http\Response &&
            !$response->headers->contains('Content-Type', 'application/json')) {
            $response->headers->set('Content-Type', 'application/json');
        }

        return $response;
    }
}
