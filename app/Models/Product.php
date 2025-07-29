<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable = [
        'name',
        'slug',
        'description',
        'image',
        'price',
        'status',
    ];

    public function getRouteKeyName()
    {
        return 'slug'; // Gunakan slug daripada id
    }

}
