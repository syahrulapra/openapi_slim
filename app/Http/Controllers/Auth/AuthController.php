<?php

namespace App\Http\Controllers\Auth;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Firebase\JWT\JWT;
use Illuminate\Database\Capsule\Manager as Capsule;
use App\Models\Users;

class AuthController
{
    public function login(Request $request, Response $response)
    {
        $data = json_decode($request->getBody()->getContents(), true);

        $user = Users::where('email', $data['email'])->first();
        
        if (!$user || !password_verify($data['password'], $user->password)) {
            $response->getBody()->write(json_encode(['error' => 'Invalid credentials']));
            return $response->withHeader('Content-Type', 'application/json')->withStatus(401);
        }

        $payload = [
            'sub' => $user->id,
            'name' => $user->name
        ];

        $jwt = JWT::encode($payload, env('JWT_SECRET'), 'HS256');

        $response->getBody()->write(json_encode(['token' => $jwt]));
        return $response->withHeader('Content-Type', 'application/json');
    }

    public function logout(Request $request, Response $response)
    {
        // Untuk JWT stateless, logout dilakukan di sisi client dengan menghapus token
        $response->getBody()->write(json_encode(['message' => 'Logged out successfully']));
        return $response->withHeader('Content-Type', 'application/json');
    }
}