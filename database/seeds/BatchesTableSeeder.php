<?php

use App\Models\Batch;
use Illuminate\Database\Seeder;

class BatchesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Batch::insert([
            [
                'month' => 'March',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'month' => 'May',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'month' => 'October',
                'created_at' => now(),
                'updated_at' => now()
            ]
        ]);
    }
}
