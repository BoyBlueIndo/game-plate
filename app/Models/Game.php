<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Game extends Model
{
    // protected $table = 'games';

    protected $fillable = [
        'name',
        'genres_id',
        'publisher',
        'user_id',
        'description',
        'price',
        'image',
        'game_link',
        'comments',
    ];

    public function genre()
    {
        return $this->belongsTo(Genre::class, 'genres_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
