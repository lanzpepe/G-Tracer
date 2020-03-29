<?php

use App\Models\Gender;
use Illuminate\Database\Seeder;

class GendersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Gender::insert([
            [
                'name' => 'Male',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'name' => 'Female',
                'created_at' => now(),
                'updated_at' => now()
            ]
        ]);
    }
}
