<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Favorite extends Model
{
    protected $fillable = ['user_id', 'jewelry_id'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function jewelry()
    {
        return $this->belongsTo(Jewelry::class);
    }
}
