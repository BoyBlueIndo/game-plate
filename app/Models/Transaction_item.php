<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Transaction_item extends Model
{
    protected $fillable = ['transaction_id', 'game_id'];

    public function transaction() {
        return $this->belongsTo(Transaction::class);
    }

    public function game() {
        return $this->belongsTo(Game::class, 'game_id');
    }
}
