<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Transaction;
use App\Models\Transaction_item;
use App\Models\Inventory;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class TransactionController extends Controller
{
    public function index()
    {
        $transactions = Transaction::where('user_id', Auth::id())
            ->with('items.game')
            ->get();

        return view('user.transactions.index', compact('transactions'));
    }

    public function adminIndex()
    {
        $transactions = Transaction::with(['items.game', 'user'])->get();

        return view('admin.transactions.index', compact('transactions'));
    }

    public function checkout(Request $request)
    {
        $request->validate([
            'payment_method' => 'required|string'
        ]);

        $cartItems = Cart::where('user_id', Auth::id())->with('game')->get();

        if ($cartItems->isEmpty()) {
            return back()->with('error', 'Your cart is empty.');
        }

        foreach ($cartItems as $item) {
            if ($item->quantity > $item->game->availableStock()) {
                return back()->with(
                    'error',
                    "Stock untuk {$item->game->name} tidak mencukupi."
                );
            }
        }

        $transaction = Transaction::create([
            'user_id' => Auth::id(),
            'status' => 'pending',
            'payment_method' => $request->payment_method
        ]);

        foreach ($cartItems as $item) {
            Transaction_item::create([
                'transaction_id' => $transaction->id,
                'game_id' => $item->game_id,
                'quantity' => $item->quantity,
            ]);
        }

        Cart::where('user_id', Auth::id())->delete();

        return redirect()->route('user.transactions.index')
            ->with('success', 'Checkout berhasil. Menunggu konfirmasi admin.');
    }

    public function updateStatus($id, $status)
    {
        $transaction = Transaction::findOrFail($id);
        $transaction->status = $status;
        $transaction->save();

        // Jika confirmed, masukkan ke inventory
        if ($status === 'confirmed') {
            foreach ($transaction->items as $item) {

                $game = $item->game;

                if ($game->stock < $item->quantity) {
                    return back()->with('error', 'Stock not sufficient.');
                }

                // Kurangi stock
                $game->decrement('stock', $item->quantity);

                Inventory::firstOrCreate([
                    'user_id' => $transaction->user_id,
                    'game_id' => $item->game_id
                ]);
            }
        }

        return back()->with('success', 'Transaction updated.');
    }
}