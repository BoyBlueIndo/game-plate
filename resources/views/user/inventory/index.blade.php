@extends('layout.app')

@section('title', 'My Inventory')

@section('content')
<div class="container mt-4">

    <h1 class="mb-4">My Game Inventory</h1>

    <button>
        <a href="{{ route('user.index') }}" class="btn btn-secondary btn-sm">Back to Store</a>
    </button>

    @if ($items->isEmpty())
        <div class="alert alert-info">
            You have no games yet.
        </div>
    @else

        <div class="row">
            @foreach ($items as $item)
                <div class="col-md-4 mb-3">
                    <div class="card shadow-sm">
                        <img src="{{ asset('storage/' . $item->game->image) }}" class="card-img-top" alt="Game Image">

                        <div class="card-body">
                            <h5 class="card-title">{{ $item->game->name }}</h5>
                            <p class="card-text">{{ Str::limit($item->game->description, 80) }}</p>

                            <a href="{{ $item->game->game_link ?? '#' }}" class="btn btn-primary w-100 mb-2">
                                Play
                            </a>

                            @if ($item->game->game_file)
                                <a href="{{ asset('storage/' . $item->game->game_file) }}" class="btn btn-secondary w-100">
                                    Download
                                </a>
                            @endif
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

    @endif

</div>
@endsection