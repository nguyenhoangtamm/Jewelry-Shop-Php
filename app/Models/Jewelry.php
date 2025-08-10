<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

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

    protected $casts = [
        'price' => 'decimal:2',
        'weight' => 'decimal:2',
        'is_deleted' => 'boolean',
    ];

    // Global scope để loại bỏ các record đã xóa
    protected static function booted()
    {
        static::addGlobalScope('not_deleted', function (Builder $builder) {
            $builder->where('is_deleted', false);
        });
    }

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

    // Phương thức để lấy cả record đã xóa
    public static function withDeleted()
    {
        return (new static)->newQueryWithoutScope('not_deleted');
    }

    // Phương thức để chỉ lấy record đã xóa
    public static function onlyDeleted()
    {
        return (new static)->newQueryWithoutScope('not_deleted')->where('is_deleted', true);
    }

    // Soft delete
    public function softDelete()
    {
        return $this->update(['is_deleted' => true]);
    }

    // Restore
    public function restore()
    {
        return $this->update(['is_deleted' => false]);
    }

}
