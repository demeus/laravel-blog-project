<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class PostView extends Model
{
    use HasFactory;

    protected $fillable = [
        'ip_address',
        'user_agent',
        'post_id',
        'user_id',
    ];
}
