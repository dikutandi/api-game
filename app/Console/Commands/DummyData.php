<?php

namespace App\Console\Commands;

use Faker\Factory;
use Illuminate\Console\Command;

class DummyData extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'dikut:dummy';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $faker = Factory::create();

        for ($i = 1; $i < rand(10, 30); $i++) {
            dump('user ke-' . $i);
            $gamer = \App\Models\Gamers::create([
                'fbid'            => $faker->unique()->isbn10,
                'email'           => $faker->unique()->email,
                'name'            => $faker->unique()->userName,
                'profile_picture' => $faker->imageUrl(80, 80),
            ]);

            for ($j = 1; $j < rand(5, 10); $j++) {
                dump('user ke-' . $i . ' main game ke-' . $j);
                $skor = \App\Models\GamerSkors::create([
                    'gamer_id' => $gamer->id,
                    'skor'     => $faker->numberBetween(100, 1100),
                ]);
            }
            dump('=================');
        }
    }
}
