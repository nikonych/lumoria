<?php

namespace Database\Seeders;

use App\Models\Movie;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class WatchlistSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = User::all();
        $movies = Movie::pluck('id');

        if ($movies->isEmpty() || $users->isEmpty()) {
            $this->command->info('No movies or users found, skipping WatchlistSeeder.');
            return;
        }

        $users->each(function (User $user) use ($movies) {
            $moviesToAttach = $movies->random(rand(15, 30));

            $user->watchlist()->attach($moviesToAttach);
        });
    }
}
