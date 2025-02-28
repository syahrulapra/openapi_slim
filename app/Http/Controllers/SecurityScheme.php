<?php

namespace App\Http\Controllers;

use OpenApi\Attributes as OAT;

#[OAT\SecurityScheme(
    securityScheme: "bearerAuth",
    type: "http",
    scheme: "bearer",
    bearerFormat: "JWT"
)]
class SecurityScheme {}