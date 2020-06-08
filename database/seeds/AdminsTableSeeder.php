<?php

use App\Models\Department;
use App\Models\Role;
use App\Models\School;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class AdminsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $adminRole = Role::where('name', config('constants.roles.admin'))->first();
        $dept = Department::where('name', 'ICCT')->first();
        $school = School::where('name', 'University of San Jose - Recoletos')->first();

        $user = User::create([
            'user_id' => Str::uuid(),
            'last_name' => 'Doe',
            'first_name' => 'John',
            'middle_name' => 'F',
            'gender' => 'Male',
            'birth_date' => 'February 14, 1991'
        ]);

        $user->admin()->create([
            'admin_id' => Str::uuid(),
            'username' => 'admin',
            'password' => Hash::make('usjr123'),
            'user_id' => $user->user_id
        ]);

        $user->admin->roles()->attach($adminRole->id);
        $user->admin->departments()->attach($dept->id);
        $user->admin->schools()->attach($school->id);
    }
}
