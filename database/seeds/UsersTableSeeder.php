<?php

use App\Models\Company;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user = User::create([
            'user_id' => Str::random(),
            'last_name' => "Elano",
            'first_name' => "Jessie",
            'middle_name' => "M",
            'birth_date' => "December 26, 1991",
            'gender' => "Male",
            'image_uri' => "http://pbs.twimg.com/profile_images/1038011376071979008/v8YWmSrN_normal.jpg"
        ]);

        $user->contacts()->create([
            'contact_id' => Str::random(),
            'address_line' => "Deca Homes Baywalk Phase 1",
            'city' => "Talisay City",
            'province' => "Cebu",
            'contact_number' => "09262606010",
            'email' => "jme@usjr.edu.ph"
        ]);

        $user->socialAccount()->create([
            'provider_id' => "64Elb4TJTm",
            'provider_name' => "linkedin.com"
        ]);

        $user->academic()->create([
            'academic_id' => Str::random(),
            'degree' => "BS in Information Technology",
            'major' => null,
            'department' => "CICCT",
            'school' => "University of San Jose-Recoletos",
            'school_year' => "2019-2020",
            'batch' => "March 2020"
        ]);

        $company = Company::create([
            'company_id' => Str::random(),
            'name' => "Accenture",
            'address' => "Filinvest Towers, 4th Floor Cebu IT Park, Cebu City"
        ]);

        $user->employments()->create([
            'job_position' => "Java Developer",
            'date_employed' => "March 30, 2020",
            'company_id' => $company->company_id
        ]);
    }
}
