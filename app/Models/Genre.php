<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Genre extends Model
{
    protected $fillable = [
        'name',
    ];

    public function game() 
    {
        return $this->hasMany(Game::class, 'genres_id');
    }
}
