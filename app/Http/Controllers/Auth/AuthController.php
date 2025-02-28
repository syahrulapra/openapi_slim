<?php

namespace App\Http\Controllers\Auth;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Firebase\JWT\JWT;
use App\Models\Users;
use OpenApi\Attributes as OAT;

class AuthController
{
    #[OAT\Post(
        tags: ["Auth"],
        path: "/login",
        operationId: "login",
        summary: "User login",
        requestBody: new OAT\RequestBody(
            required: true,
            content: new OAT\JsonContent(ref: "#/components/schemas/Auth")
        ),
        responses: [
            new OAT\Response(response: 201, description: "Login successful"),
            new OAT\Response(response: 401, description: "Invalid credentials")
        ]
    )]
    public function login(Request $request, Response $response)
    {
        $data = json_decode($request->getBody()->getContents(), true);

        $user = Users::where('email', $data['email'])->first();
        
        if (!$user || !password_verify($data['password'], $user->password)) {
            return $response->withStatus(401)->withHeader('Content-Type', 'application/json')->write(json_encode(['error' => 'Invalid credentials']));
        }

        $jwt = JWT::encode(['sub' => $user->id, 'name' => $user->name], env('JWT_SECRET'), 'HS256');

        $response->getBody()->write(json_encode(['token' => $jwt]));
        return $response->withHeader('Content-Type', 'application/json');
    }
}

#[OAT\Schema(schema: "Auth")]
class AuthSchema
{
    #[OAT\Property(type: "string", example: "admin@example.com")]
    public string $email;

    #[OAT\Property(type: "string", example: "password")]
    public string $password;
}

#[OAT\Tag(
    name: "Auth",
    description: "User authentication",
)]
class AuthTag {}