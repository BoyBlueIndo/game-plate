@extends('layout.app')

@section('title', 'My Cart')

@section('content')
<div class="container mt-4">

    <h1 class="mb-4">My Cart</h1>

    <button>
        <a href="{{ route('user.index') }}" class="btn btn-secondary btn-sm">Back to Store</a>
    </button>

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
                        <th style="width: 120px;">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @php $total = 0; @endphp

                    @foreach ($cart as $item)
                        @php $total += $item->game->price; @endphp

                        <tr>
                            <td>{{ $item->game->name }}</td>
                            <td>Rp {{ number_format($item->game->price, 0, ',', '.') }}</td>
                            <td>
                                <form action="{{ route('user.cart.remove', $item->id) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-danger btn-sm w-100">Remove</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach

                    <tr class="table-secondary">
                        <th>Total</th>
                        <th>Rp {{ number_format($total, 0, ',', '.') }}</th>
                        <th></th>
                    </tr>
                </tbody>
            </table>
        </div>

        <form method="POST" action="{{ route('user.checkout') }}">
            @csrf
            <button class="btn btn-success w-100 mt-3">Checkout</button>
        </form>

    @endif

</div>
@endsection