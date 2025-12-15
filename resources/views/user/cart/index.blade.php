@extends('layout.app')

@section('title', 'My Cart')

@section('content')
<div class="container mt-4">

    <h1 class="mb-4">My Cart</h1>

    <a href="{{ route('user.index') }}" class="btn btn-secondary btn-sm mb-3">
        Back to Store
    </a>

    @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    @if (session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    @if ($cart->isEmpty())
        <div class="alert alert-info">Your cart is empty.</div>
    @else

        <div class="table-responsive">
            <table class="table table-bordered table-striped align-middle">
                <thead class="table-dark">
                    <tr>
                        <th>Game</th>
                        <th>Price</th>
                        <th>Quantity</th>
                        <th>Subtotal</th>
                        <th style="width: 120px;">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @php $total = 0; @endphp

                    @foreach ($cart as $item)
                        @php
                            $subtotal = $item->game->price * $item->quantity;
                            $total += $subtotal;
                        @endphp

                        <tr>
                            <td>{{ $item->game->name }}</td>

                            <td>
                                Rp {{ number_format($item->game->price, 0, ',', '.') }}
                            </td>

                            <td class="text-center">
                                {{ $item->quantity }}
                            </td>

                            <td>
                                Rp {{ number_format($subtotal, 0, ',', '.') }}
                            </td>

                            <td>
                                <form action="{{ route('user.cart.remove', $item->id) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-danger btn-sm w-100">
                                        Remove
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @endforeach

                    <tr class="table-secondary fw-bold">
                        <td colspan="3" class="text-end">Total</td>
                        <td>
                            Rp {{ number_format($total, 0, ',', '.') }}
                        </td>
                        <td></td>
                    </tr>
                </tbody>
            </table>
        </div>

        <form method="POST" action="{{ route('user.checkout') }}">
            @csrf

            <div class="mb-3">
                <label class="form-label">Payment Method</label>
                <select name="payment_method" class="form-select" required>
                    <option value="">-- Choose Payment Method --</option>
                    <option value="manual_transfer">Manual Transfer</option>
                    <option value="bank_transfer">Bank Transfer</option>
                    <option value="qris">QRIS</option>
                    <option value="cod">Cash on Delivery</option>
                </select>
            </div>

            <button class="btn btn-success w-100">
                Checkout
            </button>
        </form>

    @endif

</div>
@endsection