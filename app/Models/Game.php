<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Transaction_item;
use App\Models\Transaction;

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
        'stock',
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

    public function pendingQuantity()
    {
        return Transaction_item::where('game_id', $this->id)
            ->whereHas('transaction', function ($q) {
                $q->where('status', 'pending');
            })
            ->sum('quantity');
    }

    public function availableStock()
    {
        return $this->stock - $this->pendingQuantity();
    }
}
