<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class JWTFromCookieMiddleware
{
    public function handle($request, Closure $next)
    {
        // Comprueba si la cookie "token" está presente
        if ($token = $request->cookie('token')) {
            // Añade el token al encabezado Authorization para que lo use JWTAuth
            $request->headers->set('Authorization', 'Bearer ' . $token);
        }

        return $next($request);
    }
}
