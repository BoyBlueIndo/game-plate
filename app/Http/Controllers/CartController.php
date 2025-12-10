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

    public function add($game_id)
    {
        if (Cart::where('user_id', Auth::id())->where('game_id', $game_id)->exists()) {
            return back()->with('error', 'Game already in cart.');
        }

        Cart::create([
            'user_id' => Auth::id(),
            'game_id' => $game_id
        ]);

        return back()->with('success', 'Added to cart.');
    }

    public function remove($id)
    {
        Cart::where('id', $id)->where('user_id', Auth::id())->delete();
        return back()->with('success', 'Removed from cart.');
    }
}