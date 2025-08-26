<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PaymentMethod extends Model
{
    protected $fillable = [
        'name',
        'atas_nama',
        'number',
        'image',
        'is_active',
    ];
}
