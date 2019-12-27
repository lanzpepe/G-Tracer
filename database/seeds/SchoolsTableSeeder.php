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
        $school = new School();

        $school->id = Str::random();
        $school->name = 'UNIVERSITY OF SAN JOSE-RECOLETOS';

        $school->save();
    }
}
