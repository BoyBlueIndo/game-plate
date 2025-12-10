<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Transaction;
use App\Models\Transaction_item;
use App\Models\Inventory;
use Illuminate\Support\Facades\Auth;

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

    public function checkout()
    {
        $cartItems = Cart::where('user_id', Auth::id())->get();

        if ($cartItems->isEmpty()) {
            return back()->with('error', 'Your cart is empty.');
        }

        $transaction = Transaction::create([
            'user_id' => Auth::id(),
            'status'  => 'pending'
        ]);

        foreach ($cartItems as $item) {
            Transaction_item::create([
                'transaction_id' => $transaction->id,
                'game_id' => $item->game_id
            ]);
        }

        Cart::where('user_id', Auth::id())->delete();

        return redirect()->route('user.transactions.index')
            ->with('success', 'Checkout successful. Waiting for admin confirmation.');
    }

    public function updateStatus($id, $status)
    {
        $transaction = Transaction::findOrFail($id);
        $transaction->status = $status;
        $transaction->save();

        // Jika confirmed, masukkan ke inventory
        if ($status === 'confirmed') {
            foreach ($transaction->items as $item) {
                Inventory::firstOrCreate([
                    'user_id' => $transaction->user_id,
                    'game_id' => $item->game_id
                ]);
            }
        }

        return back()->with('success', 'Transaction updated.');
    }
}