<?php

use App\Events\TwitterFriendsSaved;
use App\Models\Company;
use App\Models\Graduate;
use App\Models\Response;
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
        $graduate = Graduate::where('last_name', 'Gimenez')->where('first_name', 'Kent')->first();

        if ($graduate) {
            $user = User::create([
                'user_id' => Str::uuid(),
                'last_name' => "Gimenez",
                'first_name' => "Kent",
                'middle_name' => "A",
                'gender' => "Male",
                'birth_date' => "December 26, 1998",
                'image_uri' => "http://pbs.twimg.com/profile_images/1209730731385114625/t8sEryQf_normal.jpg"
            ]);

            $graduate->contacts()->update([
                'user_id' => $user->user_id,
                'contact_number' => '09262606010',
                'email' => 'kintoy@usjr.edu.ph'
            ]);

            $graduate->academic->update(['user_id' => $user->user_id]);

            $user->socialAccounts()->create([
                'id' => Str::random(),
                'provider_id' => '245323291',
                'provider_name' => 'twitter.com',
                'profile_url' => 'twitter.com/adonthinkso'
            ]);

            $company = Company::create([
                'company_id' => Str::random(),
                'name' => "Advanced World Systems",
                'address' => "Cebu IT Park, Lahug, Cebu City, Cebu"
            ]);

            $user->companies()->attach([
                $company->company_id => [
                    'job_position' => "Java Developer",
                    'date_employed' => "March 30, 2020"
                ]
            ]);

            $response = Response::create([
                'id' => Str::random(),
                'company_name' => "Advanced World Systems",
                'company_address' => "Cebu IT Park, Lahug, Cebu City, Cebu",
                'job_position' => "Java Developer",
                'date_employed' => "March 30, 2020",
                'remarks' => "Respondent"
            ]);

            $user->graduates()->syncWithoutDetaching([
                $graduate->graduate_id => ['response_id' => $response->id]
            ]);

            event(new TwitterFriendsSaved($user));
        }
    }
}
