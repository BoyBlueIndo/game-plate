<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Game;
use App\Models\Genre;

class GameSeeder extends Seeder
{
    public function run(): void
    {
        $action = Genre::where('name', 'Action')->first();
        $rpg    = Genre::where('name', 'RPG')->first();
        $horror = Genre::where('name', 'Horror')->first();

        $games = [
            [
                'name'        => 'Shadow Blade',
                'genres_id'   => $action->id,
                'publisher'   => 'Indie Studio',
                'description' => 'Fast-paced ninja action game.',
                'price'       => 50000,
                'stock'       => 5,
                'game_link'   => 'https://example.com/shadow-blade',
                'comments'    => null,
            ],
            [
                'name'        => 'Legend of Eldoria',
                'genres_id'   => $rpg->id,
                'publisher'   => 'Fantasy Corp',
                'description' => 'Open world RPG with deep story.',
                'price'       => 75000,
                'stock'       => 10,
                'game_link'   => 'https://example.com/eldoria',
                'comments'    => null,
            ],
            [
                'name'        => 'Nightmare Asylum',
                'genres_id'   => $horror->id,
                'publisher'   => 'Horror Labs',
                'description' => 'Psychological horror survival game.',
                'price'       => 60000,
                'stock'       => 3,
                'game_link'   => 'https://example.com/nightmare',
                'comments'    => null,
            ],
        ];

        foreach ($games as $game) {
            Game::firstOrCreate(
                ['name' => $game['name']],
                $game
            );
        }
    }
}