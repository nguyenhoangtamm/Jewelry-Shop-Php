<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

class JewelryFile extends Model
{
    use HasFactory;

    protected $fillable = [
        'jewelry_id',
        'file_id',
        'is_main',
        'is_deleted',
    ];

    protected $casts = [
        'is_main' => 'boolean',
        'is_deleted' => 'boolean',
    ];

    // Global scope để loại bỏ các record đã xóa
    protected static function booted()
    {
        static::addGlobalScope('not_deleted', function (Builder $builder) {
            $builder->where('is_deleted', false);
        });
    }

    public function jewelry()
    {
        return $this->belongsTo(Jewelry::class);
    }

    public function file()
    {
        return $this->belongsTo(File::class);
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
