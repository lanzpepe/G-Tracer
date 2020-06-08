<?php

use App\Models\School;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class SchoolsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        School::create([
            'id' => Str::random(),
            'name' => 'University of San Jose - Recoletos',
            'logo' => rawurlencode('logos/school/University of San Jose - Recoletos.png')
        ]);
    }
}
