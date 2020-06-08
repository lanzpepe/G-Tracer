<?php

use App\Models\Rank;
use Illuminate\Database\Seeder;

class RanksTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Rank::insert([
            [
                'name' => 'Novice',
                'exp_point' => 0,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'name' => 'Apprentice',
                'exp_point' => 50,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'name' => 'Journeyman',
                'exp_point' => 250,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'name' => 'Expert',
                'exp_point' => 1000,
                'created_at' => now(),
                'updated_at' => now()
            ]
        ]);
    }
}
