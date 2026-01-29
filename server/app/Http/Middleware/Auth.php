<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Laravel\Sanctum\PersonalAccessToken;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth as SanctumAuth;

class Auth
{
    /**
     * Handle an incoming request.
     *
     * @param  Closure(Request): (Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (!SanctumAuth::guard('sanctum')->check()) {
            return response()->json([
                'success' => false,
                'message' => 'unauthorized',
                'errors' => 'unauthorized'
            ], Response::HTTP_UNAUTHORIZED);
        }

        $bearer_token = $request->bearerToken();
        $token = PersonalAccessToken::findToken($bearer_token);

        if ($token->cant('authenticate')) {
            return response()->json([
                'success' => false,
                'message' => 'unauthorized',
                'errors' => 'unauthorized'
            ], Response::HTTP_UNAUTHORIZED);
        }

        return $next($request);
    }
}
