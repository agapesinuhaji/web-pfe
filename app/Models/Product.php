<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    use SoftDeletes;
    
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
