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
        $school = School::where('name', 'University of San Jose - Recoletos')->first();

        $dept = Department::create([
            'id' => Str::random(),
            'name' => 'ICCT',
            'logo' => rawurlencode('logos/department/University of San Jose - Recoletos/ICCT.png')
        ]);

        $dept->schools()->attach([$school->id]);
    }
}
