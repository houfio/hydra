<?php

namespace App\Http\Middleware;

use App\User;
use Closure;
use Exception;
use Firebase\JWT\JWT;
use Illuminate\Http\Request;
use Illuminate\Validation\UnauthorizedException;

class AuthMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        $token = $request->header('authorization');

        if (!$token) {
            throw new UnauthorizedException('Token not provided.');
        }

        try {
            $credentials = JWT::decode(substr($token, 7), env('JWT_SECRET'), ['HS256']);
        } catch(Exception $e) {
            throw new UnauthorizedException('Invalid token.');
        }

        $user = User::find($credentials->sub);
        $request->auth = $user;

        return $next($request);
    }
}
