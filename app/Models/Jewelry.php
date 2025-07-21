<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Jewelry extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'price',
        'weight',
        'main_stone',
        'sub_stone',
        'gender',
        'brand',
        'description',
        'after_sales_policy',
        'stock',
        'category_id',
        'is_deleted',
    ];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function reviews()
    {
        return $this->hasMany(Review::class, 'jewelries_id');
    }

    public function jewelryFiles()
    {
        return $this->hasMany(JewelryFile::class);
    }

    public function orderDetails()
    {
        return $this->hasMany(OrderDetail::class);
    }
}
