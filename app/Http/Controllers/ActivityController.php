<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ActivityController extends Controller
{
    protected $fillable = [
        'user_id',
        'title',
        'description',
    ];
}
