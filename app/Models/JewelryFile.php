<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JewelryFile extends Model
{
    use HasFactory;

    protected $fillable = [
        'jewelry_id',
        'file_id',
        'is_main',
        'is_deleted',
    ];

    public function jewelry()
    {
        return $this->belongsTo(Jewelry::class);
    }

    public function file()
    {
        return $this->belongsTo(File::class);
    }
}
