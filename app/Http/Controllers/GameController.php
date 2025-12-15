<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Game;
use App\Models\Genre;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class GameController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->search;
        $genre = $request->genre;
        $sort = $request->sort;

        $games = Game::with('genre')
            ->when($genre, function ($q) use ($genre) {
                $q->where('genres_id', $genre);
            })
            ->when($search, function ($q) use ($search) {
                $q->where(function ($sub) use ($search) {
                    $sub->where("name", "like", "%$search%")
                        ->orWhere("publisher", "like", "%$search%");
                });
            })
            ->when($sort, function ($q) use ($sort) {
                return match ($sort) {
                    'price_asc'  => $q->orderBy('price', 'asc'),
                    'price_desc' => $q->orderBy('price', 'desc'),
                    'newest'     => $q->orderBy('created_at', 'desc'),
                    'oldest'     => $q->orderBy('created_at', 'asc'),
                    default      => $q
                };
            })
            ->paginate(12);

        $genres = Genre::all();

        return view('user.index', compact('games', 'genres', 'search', 'genre', 'sort'));
    }

    public function indexAdmin(Request $request)
    {
        $search = $request->search;
        $genre = $request->genre;
        $sort = $request->sort;

        $games = Game::with('genre')
            ->when($genre, function ($q) use ($genre) {
                $q->where('genres_id', $genre);
            })
            ->when($search, function ($q) use ($search) {
                $q->where(function ($sub) use ($search) {
                    $sub->where('name', 'like', "%$search%")
                        ->orWhere('publisher', 'like', "%$search%");
                });
            })
            ->when($sort, function ($q) use ($sort) {
                return match ($sort) {
                    'price_asc'  => $q->orderBy('price', 'asc'),
                    'price_desc' => $q->orderBy('price', 'desc'),
                    'newest'     => $q->orderBy('created_at', 'desc'),
                    'oldest'     => $q->orderBy('created_at', 'asc'),
                    default      => $q
                };
            })
            ->paginate(12);

        $genres = Genre::all();

        return view('admin.index', compact('games', 'genres', 'search', 'genre', 'sort'));
    }

    public function create()
    {
        $genres = Genre::all();
        return view('admin.games.create', compact('genres'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name'        => 'required|string|unique:games,name',
            'genres_id'   => 'required|exists:genres,id',
            'publisher'   => 'required|string',
            'description' => 'required|string',
            'price'       => 'required|integer|min:0',
            'stock'       => 'required|integer|min:1',
            'image'       => 'nullable|image|mimes:jpg,png,jpeg|max:2048',
            'game_link'   => 'required|string|url',
            'comments'    => 'nullable|string',
        ]);

        $game = new Game($request->only([
            'name', 
            'genres_id', 
            'publisher', 
            'description', 
            'price', 
            'stock',
            'game_link', 
            'comments',
        ]));

        if ($request->hasFile('image')) {
            $game->image = $request->file('image')->store('images', 'public');
        }

        $game->save();

        return redirect()->route('admin.index')->with('success', 'Game added.');
    }

    public function show(string $id)
    {
        $game = Game::with('genre')->findOrFail($id);

        if (Auth::user()->role === 'admin') {
            return view('admin.games.show', compact('game'));
        }

        return view('user.show', compact('game'));
    }



    /**
     * EDIT GAME (Admin)
     */
    public function edit(string $id)
    {
        $game = Game::findOrFail($id);
        $genres = Genre::all();
        return view('admin.games.edit', compact('game', 'genres'));
    }
    public function update(Request $request, string $id)
    {
        $game = Game::findOrFail($id);

        $request->validate([
            'name'        => 'required|string|unique:games,name,' . $id,
            'genres_id'   => 'required|exists:genres,id',
            'publisher'   => 'required|string',
            'description' => 'required|string',
            'price'       => 'required|integer|min:0',
            'stock'       => 'required|integer|min:0',
            'image'       => 'nullable|image|mimes:jpg,png,jpeg|max:2048',
            'game_link'   => 'required|string|url',
            'comments'    => 'nullable|string',
        ]);

        $game->fill($request->only([
            'name', 
            'genres_id', 
            'publisher', 
            'description', 
            'price',
            'stock',
            'game_link',
            'comments'
        ]));

        if ($request->hasFile('image')) {
            Storage::disk('public')->delete($game->image);
            $game->image = $request->file('image')->store('images', 'public');
        }

        $game->save();

        return redirect()->route('admin.index')->with('success', 'Game updated.');
    }
    public function destroy(string $id)
    {
        $game = Game::findOrFail($id);

        if ($game->stock > 0) {
            return back()->with('error', 'Game cannot be deleted while stock is available.');
        }

        if ($game->image) Storage::disk('public')->delete($game->image);

        $game->delete();

        return redirect()->route('admin.index')->with('success', 'Game deleted.');
    }
}