<?php

namespace App\Http\Controllers\Tests;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use App\Models\Tickets;
use App\Http\Controllers\OpenApi;
use OpenApi\Attributes as OAT;

class Ticket extends OpenApi {
    #[OAT\Get(path: "/api/tickets", operationId: "getTicket")]
    #[OAT\Response(response: 200, description: "Success")]
    public function index(Request $request, Response $response): Response
    {
        $tickets = Tickets::all();

        $response->getBody()->write(json_encode([
            "status" => "Success",
            "code" => 200,
            "data" => $tickets
        ]));
        
        return $response->withHeader('Content-Type', 'application/json');
    }

    #[OAT\Post(path: "/api/tickets", operationId: "storeTicket")]
    #[OAT\RequestBody(ref: '#/components/schemas/TicketSchema')]
    #[OAT\Response(response: 201, description: "Success")]
    public function store(Request $request, Response $response): Response
    {
        $data = json_decode($request->getBody()->getContents(), true);

        $ticket = Tickets::create([
            'title'         => $data['title'],
            'description'   => $data['description'],
            'status'        => $data['status'] ?? "Low",
            'priority'      => $data['priority'] ?? "Low"
        ]);

        $response->getBody()->write(json_encode([
            "status" => "Success",
            "code" => 201,
            "data" => $ticket
        ]));

        return $response->withHeader('Content-Type', 'application/json');
    }

    #[OAT\Put(path: "/api/tickets/{id}", operationId: "updateTicket")]
    #[OAT\Parameter(name: "id", in: "path", required: true, schema: new OAT\Schema(type: "integer"))]
    #[OAT\RequestBody(ref: '#/components/schemas/TicketSchema')]
    #[OAT\Response(response: 200, description: "Success")]
    public function update(Request $request, Response $response, array $args): Response
    {
        $id = $args['id'];
        $data = json_decode($request->getBody()->getContents(), true);

        $ticket = Tickets::find($id);

        if (!$ticket) {
            $response->getBody()->write(json_encode([
                "status" => "Error",
                "message" => "Ticket not found"
            ]));

            return $response->withHeader('Content-Type', 'application/json')->withStatus(404);
        }

        $ticket->update([
            'title'       => $data['title'] ?? $ticket->title,
            'description' => $data['description'] ?? $ticket->description,
            'status'      => $data['status'] ?? $ticket->status,
            'priority'    => $data['priority'] ?? $ticket->priority
        ]);

        $response->getBody()->write(json_encode([
            "status" => "Success",
            "code" => 200,
            "data" => $ticket
        ]));

        return $response->withHeader('Content-Type', 'application/json');
    }

    #[OAT\Delete(path: "/api/tickets/{id}", operationId: "deleteTicket")]
    #[OAT\Parameter(name: "id", in: "path", required: true, schema: new OAT\Schema(type: "integer"))]
    #[OAT\Response(response: 200, description: "Success")]
    public function delete(Request $request, Response $response, array $args): Response
    {
        $id = $args['id'];
        $ticket = Tickets::find($id);

        if (!$ticket) {
            $response->getBody()->write(json_encode([
                "status" => "Error",
                "message" => "Ticket not found"
            ]));

            return $response->withHeader('Content-Type', 'application/json')->withStatus(404);
        }

        $ticket->delete();

        $response->getBody()->write(json_encode([
            "status" => "Success",
            "code" => 200,
            "message" => "Ticket deleted successfully"
        ]));

        return $response->withHeader('Content-Type', 'application/json');
    }
}
