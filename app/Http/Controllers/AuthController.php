<?php

namespace App\Http\Controllers;

use App\User;
use Firebase\JWT\JWT;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\UnauthorizedException;
use Laravel\Lumen\Routing\Controller;

class AuthController extends Controller
{
    public function authenticate(Request $request)
    {
        $data = $this->validate($request, [
            'email' => 'required|email',
            'password' => 'required'
        ]);
        $user = User::where('email', $data['email'])->first();

        if (!$user || !Hash::check($data['password'], $user->password)) {
            throw new UnauthorizedException('Invalid credentials.');
        }

        return response()->json([
            'data' => [
                'token' => JWT::encode([
                    'iss' => 'lumen',
                    'sub' => $user->id,
                    'iat' => time(),
                    'exp' => time() + 60 * 60
                ], env('JWT_SECRET'))
            ]
        ], 200);
    }
}