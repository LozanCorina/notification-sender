<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ApiAuthMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if ($this->isValidToken($request->bearerToken())) {
            return $next($request);
        }

        return response()->json([
            'message' => 'Unauthorized',
        ], 401);
    }

    protected function isValidToken($token): bool
    {
        return config('auth.api_key') === $token;
    }
}
