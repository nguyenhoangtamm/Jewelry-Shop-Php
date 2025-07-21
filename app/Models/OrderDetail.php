<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderDetail extends Model
{
    use HasFactory;

    protected $fillable = [
        'order_id',
        'jewelry_id',
        'quantity',
        'unit_price',
        'is_deleted',
    ];

    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    public function jewelry()
    {
        return $this->belongsTo(Jewelry::class);
    }
}
