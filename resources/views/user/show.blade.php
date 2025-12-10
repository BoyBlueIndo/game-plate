@extends('layout.app')

@section('title', $game->name)

@section('content')
<div class="container mt-4">
    <h1>{{ $game->name }}</h1>

    @if($game->image)
        <img src="{{ asset('storage/' . $game->image) }}" width="200">
    @endif

    <p><strong>Genre:</strong> {{ $game->genre->name }}</p>
    <p><strong>Publisher:</strong> {{ $game->publisher }}</p>
    <p><strong>Description:</strong> {{ $game->description }}</p>
    <p><strong>Price:</strong> Rp{{ number_format($game->price, 0, ',', '.') }}</p>

    <a class="btn btn-primary" href="{{ $game->game_link }}" target="_blank">Play / Download</a>
</div>
@endsection