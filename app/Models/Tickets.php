<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tickets extends Model
{
    protected $table = "tbtickets";

    protected $fillable = [
        'id',
        'title',
        'description',
        'status',
        'priority',
        'created_at',
        'updated_at',
    ];
}