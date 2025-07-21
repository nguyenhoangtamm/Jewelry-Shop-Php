<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'jewelries_id',
        'content',
        'rating',
        'is_deleted',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function jewelry()
    {
        return $this->belongsTo(Jewelry::class, 'jewelries_id');
    }
}
