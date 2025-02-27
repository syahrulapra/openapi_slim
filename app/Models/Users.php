<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Users extends Model
{
    use HasFactory;

    protected $table = 'tbusers';
    protected $primaryKey = 'id';

    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    public $timestamps = false;
}