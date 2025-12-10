@extends('layout.app')

@section('title', 'Genres')

@section('content')
<div class="container mt-4">

    <h1 class="mb-3">Genre List</h1>

    <a href="{{ route('admin.genres.create') }}" class="btn btn-primary mb-3">Add Genre</a>
    <a href="{{ route('admin.index') }}" class="btn btn-secondary mb-3">Back to Admin</a>

    <div class="card shadow-sm">
        <table class="table table-bordered table-striped mb-0">
            <thead class="table-dark">
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th width="160px">Actions</th>
                </tr>
            </thead>

            <tbody>
                @foreach ($genres as $genre)
                <tr>
                    <td>{{ $genre->id }}</td>
                    <td>{{ $genre->name }}</td>

                    <td>
                        <a href="{{ route('admin.genres.edit', $genre->id) }}" class="btn btn-warning btn-sm">Edit</a>

                        <form action="{{ route('admin.genres.destroy', $genre->id) }}" method="POST" class="d-inline">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-danger btn-sm" onclick="return confirm('Delete genre?')">
                                Delete
                            </button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>

        </table>
    </div>

</div>
@endsection