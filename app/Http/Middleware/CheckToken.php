<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\Facades\JWTAuth;

class CheckToken
{
    public function handle(Request $request, Closure $next)
    {
        try {
            $user = JWTAuth::parseToken()->authenticate();
        } catch (JWTException $e) {
            if ($e instanceof \Tymon\JWTAuth\Exceptions\TokenExpiredException) {
                return redirect()->route('login')->with('error', 'Su sesión ha expirado. Por favor, inicie sesión nuevamente.');
            }
            return redirect()->route('login')->with('error', 'Token inválido. Por favor, inicie sesión.');
        }
        return $next($request);
    }
}
