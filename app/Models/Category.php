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
        'is_deleted',
    ];

    public function jewelries()
    {
        return $this->hasMany(Jewelry::class);
    }
}
