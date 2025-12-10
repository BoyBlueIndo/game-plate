@extends('layout.app')

@section('title', 'Add New Game')

@section('content')
<div class="container mt-4">

    <h1 class="mb-4">Add New Game</h1>

    <div class="card p-4 shadow-sm">
        <form action="{{ route('admin.games.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <div class="mb-3">
                <label class="form-label">Game Name</label>
                <input type="text" name="name" class="form-control" required>
            </div>

            <div class="mb-3">
                <label class="form-label">Genre</label>
                <select name="genres_id" class="form-control" required>
                    <option value="">-- Pilih Genre --</option>
                    @foreach ($genres as $genre)
                        <option value="{{ $genre->id }}">{{ $genre->name }}</option>
                    @endforeach
                </select>
            </div>

            <div class="mb-3">
                <label class="form-label">Publisher</label>
                <input type="text" name="publisher" class="form-control" required>
            </div>

            <div class="mb-3">
                <label class="form-label">Description</label>
                <textarea name="description" class="form-control" rows="4" required></textarea>
            </div>

            <div class="mb-3">
                <label class="form-label">Price</label>
                <input type="number" name="price" class="form-control" required>
            </div>

            <div class="mb-3">
                <label class="form-label">Image</label>
                <input type="file" name="image" class="form-control" accept="image/*">
            </div>

            <div class="mb-3">
                <label class="form-label">Game Link</label>
                <input type="url" name="game_link" class="form-control" required>
            </div>

            <button class="btn btn-primary w-100">Create Game</button>
        </form>
    </div>

</div>
@endsection