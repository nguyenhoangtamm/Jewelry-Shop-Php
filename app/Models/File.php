<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

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

    public function jewelryFiles()
    {
        return $this->hasMany(JewelryFile::class);
    }
}
