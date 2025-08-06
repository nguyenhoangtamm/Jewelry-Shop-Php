<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

class File extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'path',
        'type',
        'size',
        'extension',
        'is_deleted',
    ];

    protected $casts = [
        'is_deleted' => 'boolean',
        'size' => 'integer',
    ];

    // Global scope để loại bỏ các record đã xóa
    protected static function booted()
    {
        static::addGlobalScope('not_deleted', function (Builder $builder) {
            $builder->where('is_deleted', false);
        });
    }

    public function jewelryFiles()
    {
        return $this->hasMany(JewelryFile::class);
    }

    public function categories()
    {
        return $this->hasMany(Category::class, 'file_id');
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
