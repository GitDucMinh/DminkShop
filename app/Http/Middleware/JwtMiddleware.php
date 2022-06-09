<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use PHPOpenSourceSaver\JWTAuth\Exceptions\TokenExpiredException;
use PHPOpenSourceSaver\JWTAuth\Exceptions\TokenInvalidException;
use PHPOpenSourceSaver\JWTAuth\Facades\JWTAuth;

class JwtMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        try {
            $user = JWTAuth::parseToken()->authenticate();
        } catch (\Exception $e) {
            if ($e instanceof TokenExpiredException) {
                $newToken = JWTAuth::pasreToken()->refresh();
                return response()->json([
                    'success' => false,
                    'token'   => $newToken,
                    'status'  => 'expired'
                ], 401);
            } else if ($e instanceof TokenInvalidException) {
                return response()->json([
                    'success' => false,
                    'message'   => 'Token Invalid',
                    'status'  => 'expired'
                ], 401);
            } else {
                return response()->json([
                    'success' => false,
                    'message'   => 'Token not found',
                    'status'  => 'expired'
                ], 401);
            }
        }
        return $next($request);
    }
}
