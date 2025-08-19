<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $fillable = [
        'order_uuid',
        'product_id',
        'user_id',
        'conselor_id',
        'schedule_id',
        'method_id',
        'price',
        'unique_kode',
        'total',
        'status',
        'image',
    ];

    public function getRouteKeyName()
    {
        return 'order_uuid';
    }

    // Relasi ke produk yang dipesan
    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    // Relasi ke user pemesan
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    // Relasi ke konselor
    public function conselor()
    {
        return $this->belongsTo(User::class, 'conselor_id');
    }

    // Relasi ke jadwal sesi
    public function schedule()
    {
        return $this->belongsTo(Schedule::class);
    }

    // Relasi ke metode konseling
    public function method()
    {
        return $this->belongsTo(ConselingMethod::class, 'method_id');
    }
}