<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Symfony\Component\HttpFoundation\Response;

class ValidateApiToken
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next)
    {
        $token = $request->bearerToken();

        if (!$token) {
            return response()->json(['error' => 'Token requerido'], 401);
        }

        // Petición a la UI para validar el token
        $response = Http::withHeaders([
            'Authorization' => 'Bearer ' . $token
        ])->get('http://localhost:8000/api/validar-token');

        if ($response->failed() || !$response->json('valid')) {
            return response()->json(['error' => 'Token inválido'], 401);
        }

        return $next($request);
    }
}
