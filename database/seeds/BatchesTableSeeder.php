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
        Batch::create([
            'name' => 'March'
        ]);

        Batch::create([
            'name' => 'October'
        ]);
    }
}
