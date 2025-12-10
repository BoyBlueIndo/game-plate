<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Inventory extends Model
{
    protected $table = 'inventory';
    protected $fillable = ['user_id', 'game_id'];

    public function game() {
        return $this->belongsTo(Game::class);
    }
}
