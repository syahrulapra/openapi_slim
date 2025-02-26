<?php

namespace App\Http\Controllers\Schemas;

use OpenApi\Attributes as OAT;

#[OAT\Schema()]
class TicketSchema
{
    #[OAT\Property(type: "integer", example: 1)]
    public int $id;

    #[OAT\Property(type: "string", example: "Issue with server")]
    public string $title;

    #[OAT\Property(type: "string", example: "The server is down since morning.")]
    public string $description;

    #[OAT\Property(type: "string", enum: ["open", "in_progress", "closed"], example: "open")]
    public string $status;

    #[OAT\Property(type: "string", enum: ["low", "medium", "high"], example: "medium")]
    public string $priority;
}