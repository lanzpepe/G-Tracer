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
            'middle_name' => "Mangilala",
            'suffix' => null,
            'birth_date' => "December 26, 1991",
            'gender' => "Male",
            'image_uri' => "http://pbs.twimg.com/profile_images/1038011376071979008/v8YWmSrN_normal.jpg"
        ]);

        $user->createContact([
            'contact_id' => Str::random(),
            'address_line' => "Deca Homes Baywalk Phase 1",
            'city' => "Talisay City",
            'province' => "Cebu",
            'contact_number' => "09262606010",
            'email' => "jme@usjr.edu.ph"
        ]);

        $user->createSocialAccount([
            'provider_id' => "MTQxNDA5MzU3",
            'provider_name' => "Twitter"
        ]);

        $user->createAcademic([
            'academic_id' => Str::random(),
            'degree' => "BS in Information Technology",
            'major' => null,
            'department' => "CICCT",
            'school' => "University of San Jose-Recoletos",
            'school_year' => "2019-2020",
            'batch' => "2020"
        ]);

        $company = Company::create([
            'company_id' => Str::random(),
            'name' => "Alliance Software Inc.",
            'address' => "14/F BuildComm Center, Sumilon Road, Cebu City",
            'contact' => "238-6595"
        ]);

        $user->createEmployment([
            'position' => "Software Engineer",
            'date_employed' => "March 30, 2020",
            'company_id' => $company->company_id
        ]);

        $user = User::create([
            'user_id' => Str::random(),
            'last_name' => "Gimenez",
            'first_name' => "Kent",
            'middle_name' => "Aranas",
            'suffix' => null,
            'birth_date' => "December 26, 1998",
            'gender' => "Male",
            'image_uri' => "http://pbs.twimg.com/profile_images/1038011376071979008/v8YWmSrN_normal.jpg"
        ]);

        $user->createContact([
            'contact_id' => Str::random(),
            'address_line' => "Lipata",
            'city' => "Minglanilla",
            'province' => "Cebu",
            'contact_number' => "09262606010",
            'email' => "kag@usjr.edu.ph"
        ]);

        $user->createSocialAccount([
            'provider_id' => "MSQxMEB6NzU3",
            'provider_name' => "Twitter"
        ]);

        $user->createAcademic([
            'academic_id' => Str::random(),
            'degree' => "BS in Information Technology",
            'major' => null,
            'department' => "CICCT",
            'school' => "University of San Jose-Recoletos",
            'school_year' => "2019-2020",
            'batch' => "2020"
        ]);

        $company = Company::create([
            'company_id' => Str::random(),
            'name' => "Alliance Software Inc.",
            'address' => "14/F BuildComm Center, Sumilon Road, Cebu City",
            'contact' => "238-6595"
        ]);

        $user->createEmployment([
            'position' => "Software Engineer",
            'date_employed' => "March 30, 2020",
            'company_id' => $company->company_id
        ]);
    }
}
