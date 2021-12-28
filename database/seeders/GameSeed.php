<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Seeder;

class GameSeed extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = \Faker\Factory::create();
        $users = \App\Models\User::get();

        foreach ($users as $key => $user) {
            $dateTo   = Carbon::now();
            $dateFrom = $dateTo->copy()->subDays(45);
            $diffDay  = $dateTo->diffInDays($dateFrom);

            for ($i = 1; $i <= $diffDay; $i++) {
                $newDate = $dateFrom->copy()->addDays($i);

                for ($j = 0; $j < rand(1, 5); $j++) {

                    \App\Models\Game::create([
                        'user_id' => $user->id,
                        'skor'    => rand(100, 500),
                        'game'    => rand(1, 3),
                        'date'    => $newDate,
                    ]);
                }
            }
        }
    }
}
