<?php

use App\Models\Batch;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

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
            'id' => Str::random(),
            'name' => 'MARCH'
        ]);

        Batch::create([
            'id' => Str::random(),
            'name' => 'OCTOBER'
        ]);
    }
}
