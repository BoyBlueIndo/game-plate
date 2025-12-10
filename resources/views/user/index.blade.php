@extends('layout.app')

@section('title', 'Game Store')

@section('content')
<div class="container mt-4">

    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1>Game Store</h1>

        <div>
            <a href="{{ route('logout') }}" class="btn btn-danger btn-sm">Logout</a>
            <a href="{{ route('user.cart') }}" class="btn btn-primary btn-sm">Cart</a>
            {{-- <a href="{{ route('user.inventory') }}" class="btn btn-secondary btn-sm">Inventory</a> --}}
            <a href="{{ route('user.transactions.index') }}" class="btn btn-info btn-sm">Transactions</a>
        </div>
    </div>

    {{-- Search --}}
    <form method="GET" action="" class="mb-4">
        <div class="input-group">
            <input 
                type="text" 
                name="search"
                class="form-control"
                placeholder="Search games..."
                value="{{ $search ?? '' }}"
            >
            <button class="btn btn-dark">Search</button>
        </div>
    </form>

    {{-- Game List --}}
    @if ($games->isEmpty())
        <div class="alert alert-info">No games found.</div>
    @else
        <div class="row">
            @foreach ($games as $game)
                <div class="col-md-4 mb-4">
                    <div class="card shadow-sm">

                        @if ($game->image)
                            <img src="{{ asset('storage/' . $game->image) }}" class="card-img-top" alt="Game Cover">
                        @else
                            <img src="https://via.placeholder.com/300x180?text=No+Image" class="card-img-top">
                        @endif

                        <div class="card-body">
                            <h5 class="card-title">{{ $game->name }}</h5>
                            <p class="text-muted mb-1">
                                Genre: {{ $game->genre->name }}
                            </p>
                            <p class="text-muted">
                                Publisher: {{ $game->publisher }}
                            </p>

                            <p class="card-text" style="min-height: 60px;">
                                {{ Str::limit($game->description, 80) }}
                            </p>

                            <h5 class="text-success mb-3">
                                Rp {{ number_format($game->price, 0, ',', '.') }}
                            </h5>

                            <a href="{{ route('user.cart.add', $game->id) }}" class="btn btn-primary w-100">
                                Add to Cart
                            </a>
                        </div>

                    </div>
                </div>
            @endforeach
        </div>
    @endif

</div>
@endsection