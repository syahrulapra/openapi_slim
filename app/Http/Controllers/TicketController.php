<?php

namespace App\Http\Controllers;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use App\Models\Tickets;
use App\Http\Controllers\OpenApi;
use OpenApi\Attributes as OAT;

class TicketController extends OpenApi {
    
    #[OAT\Get(
        tags: ["Tickets"],
        path: "/api/tickets",
        operationId: "getTickets",
        summary: "Get all tickets",
        responses: [
            new OAT\Response(
                response: 200,
                description: "Success",
                content: new OAT\JsonContent(type: "array", items: new OAT\Items(ref: "#/components/schemas/Ticket"))
            )
        ],
        security: [
            ["bearerAuth" => []]
        ]
    )]
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

    #[OAT\Post(
        tags: ["Tickets"],
        path: "/api/tickets",
        operationId: "createTicket",
        summary: "Create a new ticket",
        responses: [
            new OAT\Response(response: 201, description: "Ticket created successfully")
        ],
        requestBody: new OAT\RequestBody(
            required: true,
            content: new OAT\JsonContent(ref: "#/components/schemas/Ticket")
        ),
        security: [
            ["bearerAuth" => []]
        ]
    )]
    public function store(Request $request, Response $response): Response
    {
        $data = json_decode($request->getBody()->getContents(), true);

        $ticket = Tickets::create([
            'title'       => $data['title'],
            'description' => $data['description'],
            'status'      => $data['status'] ?? "open",
            'priority'    => $data['priority'] ?? "low"
        ]);

        $response->getBody()->write(json_encode([
            "status" => "Success",
            "code" => 201,
            "data" => $ticket
        ]));

        return $response->withHeader('Content-Type', 'application/json');
    }

    #[OAT\Put(
        tags: ["Tickets"],
        path: "/api/tickets/{id}",
        operationId: "updateTicket",
        summary: "Update an existing ticket",
        parameters: [
            new OAT\Parameter(name: "id", in: "path", required: true, schema: new OAT\Schema(type: "integer"))
        ],
        requestBody: new OAT\RequestBody(
            required: true,
            content: new OAT\JsonContent(ref: "#/components/schemas/Ticket")
        ),
        responses: [
            new OAT\Response(response: 200, description: "Ticket updated successfully"),
            new OAT\Response(response: 404, description: "Ticket not found")
        ],
        security: [
            ["bearerAuth" => []]
        ]
    )]
    public function update(Request $request, Response $response, array $args): Response
    {
        $id = $args['id'];
        $data = json_decode($request->getBody()->getContents(), true);

        $ticket = Tickets::find($id);

        if (!$ticket) {
            $response->getBody()->write(json_encode(["status" => "Error", "message" => "Ticket not found"]));
            return $response->withHeader('Content-Type', 'application/json')->withStatus(404);
        }

        $ticket->update([
            'title'       => $data['title'] ?? $ticket->title,
            'description' => $data['description'] ?? $ticket->description,
            'status'      => $data['status'] ?? $ticket->status,
            'priority'    => $data['priority'] ?? $ticket->priority
        ]);

        $response->getBody()->write(json_encode(["status" => "Success", "code" => 200, "data" => $ticket]));
        return $response->withHeader('Content-Type', 'application/json');
    }

    #[OAT\Delete(
        tags: ["Tickets"],
        path: "/api/tickets/{id}",
        operationId: "deleteTicket",
        summary: "Delete a ticket",
        parameters: [
            new OAT\Parameter(name: "id", in: "path", required: true, schema: new OAT\Schema(type: "integer"))
        ],
        responses: [
            new OAT\Response(response: 200, description: "Ticket deleted successfully"),
            new OAT\Response(response: 404, description: "Ticket not found")
        ],
        security: [
            ["bearerAuth" => []]
        ]
    )]
    public function delete(Request $request, Response $response, array $args): Response
    {
        $id = $args['id'];
        $ticket = Tickets::find($id);

        if (!$ticket) {
            $response->getBody()->write(json_encode(["status" => "Error", "message" => "Ticket not found"]));
            return $response->withHeader('Content-Type', 'application/json')->withStatus(404);
        }

        $ticket->delete();

        $response->getBody()->write(json_encode(["status" => "Success", "code" => 200, "message" => "Ticket deleted successfully"]));
        return $response->withHeader('Content-Type', 'application/json');
    }
}

#[OAT\Schema(schema: "Ticket")]
class TicketSchema
{
    #[OAT\Property(type: "string", example: "Issue with server")]
    public string $title;

    #[OAT\Property(type: "string", example: "The server is down since morning.")]
    public string $description;

    #[OAT\Property(type: "string", enum: ["open", "in_progress", "closed"], example: "open")]
    public string $status;

    #[OAT\Property(type: "string", enum: ["low", "medium", "high"], example: "medium")]
    public string $priority;
}

#[OAT\Tag(
    name: "Tickets",
    description: "Operations about tickets",
)]
class TicketTag {}