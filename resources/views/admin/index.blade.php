@extends('layout.app')

@section('title', 'Admin - Game List')

@section('content')
<div class="container mt-4">

    <h1 class="mb-4">Admin Dashboard</h1>

    <div class="mb-3">
        <a href="{{ route('admin.games.create') }}" class="btn btn-primary btn-sm">Add Game</a>
        <a href="{{ route('admin.genres.index') }}" class="btn btn-warning btn-sm">Manage Genres</a>
        <a href="{{ route('admin.transactions.index') }}" class="btn btn-warning btn-sm">Manage Transactions</a>
    </div>

    <form class="card p-3 mb-4" method="GET" action="">
        <div class="d-flex gap-3">
            <input 
                type="text" 
                name="search" 
                class="form-control"
                placeholder="Search game..." 
                value="{{ $search ?? '' }}"
            >
            <button class="btn btn-dark">Search</button>
        </div>
    </form>

    <div class="card shadow-sm">
        <table class="table table-bordered table-striped mb-0">
            <thead class="table-dark">
                <tr>
                    <th>Image</th>
                    <th>Name</th>
                    <th>Genre</th>
                    <th>Publisher</th>
                    <th>Description</th>
                    <th>Price</th>
                    <th>Game Link</th>
                    <th>Actions</th>
                </tr>
            </thead>

            <tbody>
                @forelse ($games as $game)
                <tr>
                    <td>
                        @if ($game->image)
                            <img src="{{ asset('storage/' . $game->image) }}" width="80" class="rounded">
                        @endif
                    </td>

                    <td>{{ $game->name }}</td>
                    <td>{{ $game->genre->name }}</td>
                    <td>{{ $game->publisher }}</td>
                    <td style="max-width:250px">{{ $game->description }}</td>
                    <td>Rp {{ number_format($game->price, 0, ',', '.') }}</td>

                    <td>
                        @if ($game->game_link)
                            <a href="{{ $game->game_link }}" target="_blank" class="btn btn-sm btn-info">Open</a>
                        @endif
                    </td>

                    <td>
                        <a href="{{ route('admin.games.edit', $game->id) }}" class="btn btn-sm btn-warning mb-1">Edit</a>

                        <form action="{{ route('admin.games.destroy', $game->id) }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-sm btn-danger w-100" onclick="return confirm('Delete this game?')">Delete</button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="9" class="text-center">No games found.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

</div>
@endsection