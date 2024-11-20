<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Tymon\JWTAuth\Facades\JWTAuth;

class JWTAuthenticate
{
    public function handle(Request $request, Closure $next)
    {
        try {
            // Intentar autenticar usando el token de la cookie
            $user = JWTAuth::parseToken()->authenticate();
        } catch (\Exception $e) {
            return redirect()->route('login')->withErrors(['error' => 'Debe iniciar sesión']);
        }

        return $next($request);
    }

    
}
