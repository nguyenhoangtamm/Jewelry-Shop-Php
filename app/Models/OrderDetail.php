<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

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

    protected $casts = [
        'quantity' => 'integer',
        'unit_price' => 'decimal:2',
        'is_deleted' => 'boolean',
    ];

    // Global scope để loại bỏ các record đã xóa
    protected static function booted()
    {
        static::addGlobalScope('not_deleted', function (Builder $builder) {
            $builder->where('is_deleted', false);
        });
    }

    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    public function jewelry()
    {
        return $this->belongsTo(Jewelry::class, 'jewelry_id');
    }

    // Phương thức để lấy cả record đã xóa
    public static function withDeleted()
    {
        return (new static)->newQueryWithoutScope('not_deleted');
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
