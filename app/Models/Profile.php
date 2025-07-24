<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Profile extends Model
{
    protected $fillable = [
        'user_id',
        'name',
        'nickname',
        'date_of_birth',
        'date_of_place',
        'gender',
        'no_whatsapp',
        'image',
        'saldo',
    ];
}
