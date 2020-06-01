<?php

namespace App\Http\Middleware;

use App\Session;
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

        $parts = explode(' ', $credentials->sub);

        if ($parts[0] === 'user') {
            $request->user = User::find($parts[1]);
        } else if ($parts[0] === 'tablet') {
            $request->tablet = Session::find($parts[1]);
        }

        return $next($request);
    }
}
