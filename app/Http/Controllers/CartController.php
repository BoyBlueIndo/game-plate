<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Game;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{
    public function index()
    {
        $cart = Cart::where('user_id', Auth::id())->with('game')->get();
        return view('user.cart.index', compact('cart'));
    }

    public function add($gameId)
    {
        $game = Game::findOrFail($gameId);

        // jumlah di cart user saat ini
        $cartItem = Cart::where('user_id', Auth::id())
            ->where('game_id', $gameId)
            ->first();

        $currentQty = $cartItem ? $cartItem->quantity : 0;

        // CEK STOCK TERSEDIA
        if ($game->availableStock() <= $currentQty) {
            return back()->with('error', 'Stock game tidak mencukupi.');
        }

        Cart::updateOrCreate(
            [
                'user_id' => Auth::id(),
                'game_id' => $gameId,
            ],
            [
                'quantity' => $currentQty + 1
            ]
        );

        return back()->with('success', 'Game added to cart.');
    }

    public function remove($id)
    {
        Cart::where('id', $id)->where('user_id', Auth::id())->delete();
        return back()->with('success', 'Removed from cart.');
    }
}