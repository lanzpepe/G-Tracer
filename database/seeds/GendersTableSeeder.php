<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class GendersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('genders')->insert([
            [
                'id' => Str::random(),
                'name' => strtoupper('Male'),
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'id' => Str::random(),
                'name' => strtoupper('Female'),
                'created_at' => now(),
                'updated_at' => now()
            ]
        ]);
    }
}
