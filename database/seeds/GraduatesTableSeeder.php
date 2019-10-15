<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class GraduatesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('graduates')->insert([
            [
                'graduate_id' => Str::random(),
                'last_name' => "Tayong",
                'first_name' => "Zachervin",
                'middle_name' => "L",
                'suffix' => null,
                'gender' => "Male",
                'degree' => "BS Information Technology",
                'major' => null,
                'department' => "CICCT",
                'school' => "University of San Jose-Recoletos",
                'school_year' => "2019-2020",
                'batch' => "2020",
                'image_uri' => null,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'graduate_id' => Str::random(),
                'last_name' => "Gimenez",
                'first_name' => "Kent",
                'middle_name' => "A",
                'suffix' => null,
                'gender' => "Male",
                'degree' => "BS Computer Science",
                'major' => null,
                'department' => "CICCT",
                'school' => "University of San Jose-Recoletos",
                'school_year' => "2019-2020",
                'batch' => "2020",
                'image_uri' => null,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'graduate_id' => Str::random(),
                'last_name' => "Barde",
                'first_name' => "Julius",
                'middle_name' => "A",
                'suffix' => null,
                'gender' => "Male",
                'degree' => "BS Information System",
                'major' => null,
                'department' => "CICCT",
                'school' => "University of San Jose-Recoletos",
                'school_year' => "2019-2020",
                'batch' => "2020",
                'image_uri' => null,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'graduate_id' => Str::random(),
                'last_name' => "Barde",
                'first_name' => "Julie",
                'middle_name' => "A",
                'suffix' => null,
                'gender' => "Female",
                'degree' => "BS Business Administration",
                'major' => "Financial Management",
                'department' => "Commerce",
                'school' => "University of San Jose-Recoletos",
                'school_year' => "2019-2020",
                'batch' => "2020",
                'image_uri' => null,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'graduate_id' => Str::random(),
                'last_name' => "Labrada",
                'first_name' => "Criel",
                'middle_name' => "G",
                'suffix' => null,
                'gender' => "Male",
                'degree' => "BS Business Administration",
                'major' => "Marketing Management",
                'department' => "Commerce",
                'school' => "University of Cebu",
                'school_year' => "2019-2020",
                'batch' => "2020",
                'image_uri' => null,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'graduate_id' => Str::random(),
                'last_name' => "Labrada",
                'first_name' => "Cirila",
                'middle_name' => "V",
                'suffix' => null,
                'gender' => "Female",
                'degree' => "BS Accountancy",
                'major' => null,
                'department' => "Commerce",
                'school' => "University of San Carlos",
                'school_year' => "2019-2020",
                'batch' => "2020",
                'image_uri' => null,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'graduate_id' => Str::random(),
                'last_name' => "Cabural",
                'first_name' => "Khent Mae",
                'middle_name' => "V",
                'suffix' => null,
                'gender' => "Female",
                'degree' => "BS Information Technology",
                'major' => null,
                'department' => "CICCT",
                'school' => "University of San Jose-Recoletos",
                'school_year' => "2019-2020",
                'batch' => "2020",
                'image_uri' => null,
                'created_at' => now(),
                'updated_at' => now()
            ]
        ]);
    }
}
