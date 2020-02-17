<?php

use App\Models\AcademicYear;
use Illuminate\Database\Seeder;

class AcademicYearsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        AcademicYear::create([
            'school_year' => '2014-2015',
            'first_batch' => 'October 2014',
            'second_batch' => 'March 2015'
        ]);

        AcademicYear::create([
            'school_year' => '2015-2016',
            'first_batch' => 'October 2015',
            'second_batch' => 'March 2016'
        ]);

        AcademicYear::create([
            'school_year' => '2016-2017',
            'first_batch' => 'October 2016',
            'second_batch' => 'March 2017'
        ]);

        AcademicYear::create([
            'school_year' => '2017-2018',
            'first_batch' => 'October 2017',
            'second_batch' => 'March 2018'
        ]);

        AcademicYear::create([
            'school_year' => '2018-2019',
            'first_batch' => 'October 2018',
            'second_batch' => 'March 2019'
        ]);

        AcademicYear::create([
            'school_year' => '2019-2020',
            'first_batch' => 'October 2019',
            'second_batch' => 'March 2020'
        ]);
    }
}
