<?php

use App\Models\Year;
use Illuminate\Database\Seeder;

class YearsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Year::insert([
            [
                'year' => '2010',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'year' => '2011',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'year' => '2012',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'year' => '2013',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'year' => '2014',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'year' => '2015',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'year' => '2016',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'year' => '2017',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'year' => '2018',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'year' => '2019',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'year' => '2020',
                'created_at' => now(),
                'updated_at' => now()
            ]
        ]);
    }
}
