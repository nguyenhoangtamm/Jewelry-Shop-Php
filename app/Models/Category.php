<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'file_id',
        'is_deleted',
    ];

    public function jewelries()
    {
        return $this->hasMany(Jewelry::class);
    }
    public function file()
    {
        return $this->belongsTo(File::class, 'file_id');
    }
}
