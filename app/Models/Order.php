<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'total_amount',
        'status',
        'notes',
        'is_deleted',
    ];

    protected $casts = [
        'total_amount' => 'decimal:2',
        'is_deleted' => 'boolean',
    ];

    // Global scope để loại bỏ các record đã xóa
    protected static function booted()
    {
        static::addGlobalScope('not_deleted', function (Builder $builder) {
            $builder->where('is_deleted', false);
        });
    }

    public function user()
    {
        return $this->belongsTo(User::class);
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
