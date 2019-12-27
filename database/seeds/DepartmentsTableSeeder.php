<?php

use App\Models\Department;
use App\Models\School;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class DepartmentsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $school = School::where('name', 'UNIVERSITY OF SAN JOSE-RECOLETOS')->first();

        $dept = new Department();
        $dept->id = Str::random();
        $dept->name = 'ICCT';
        $dept->save();
        $dept->schools()->attach([$school->id]);
    }
}
