<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheetosAuthorizationMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $authorizationHeader = $request->header('X-Authorization');

        $token = config('app.cheetos_token');

        if (!$authorizationHeader || $authorizationHeader !== $token) {
            return response()->json([
                'message' => 'Unauthorized'
            ], Response::HTTP_UNAUTHORIZED);
        }

        return $next($request);
    }
}
