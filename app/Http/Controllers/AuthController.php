<?php

namespace App\Http\Controllers;

use App\Session;
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
            'id' => 'required|integer',
            'password' => 'required'
        ]);
        $user = User::find($data['id']);

        if (!$user || !Hash::check($data['password'], $user->password)) {
            throw new UnauthorizedException('Invalid credentials.');
        }

        return response()->json([
            'success' => true,
            'data' => [
                'token' => JWT::encode([
                    'sub' => "user $user->id"
                ], env('JWT_SECRET'))
            ]
        ]);
    }

    public function session(Request $request)
    {
        $data = $this->validate($request, [
            'table' => 'required|integer|min:1'
        ]);

        $session = new Session();

        $session->table = $data['table'];

        $session->save();

        return response()->json([
            'success' => true,
            'data' => [
                'token' => JWT::encode([
                    'sub' => "tablet $session->id"
                ], env('JWT_SECRET'))
            ]
        ]);
    }
}
