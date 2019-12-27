<?php

use App\Models\Admin;
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
        $adminRole = Role::where('name', 'ADMINISTRATOR')->first();
        $deptRole = Role::where('name', 'DEPARTMENT')->first();
        $dept = Department::where('name', 'ICCT')->first();
        $school = School::where('name', 'UNIVERSITY OF SAN JOSE-RECOLETOS')->first();

        $user = new User();
        $user->user_id = Str::random();
        $user->last_name = 'DOE';
        $user->first_name = 'JOHN';
        $user->middle_name = 'F';
        $user->gender = 'MALE';
        $user->birth_date = "12/26/1991";
        $user->save();

        $admin = new Admin();
        $admin->admin_id = Str::random();
        $admin->username = 'admin';
        $admin->password = Hash::make("usjr123");
        $admin->user_id = $user->user_id;
        $admin->save();

        $admin->roles()->attach($adminRole->id);
        $admin->departments()->attach($dept->id);
        $admin->schools()->attach([$school->id]);

        $user = new User();
        $user->user_id = Str::random();
        $user->last_name = 'DOE';
        $user->first_name = 'JANE';
        $user->middle_name = 'A';
        $user->gender = 'MALE';
        $user->birth_date = "12/26/1997";
        $user->save();

        $admin = new Admin();
        $admin->admin_id = Str::random();
        $admin->username = 'janedoe';
        $admin->password = Hash::make("usjr123");
        $admin->user_id = $user->user_id;
        $admin->save();

        $admin->roles()->attach([$deptRole->id]);
        $admin->departments()->attach($dept->id);
        $admin->schools()->attach([$school->id]);
    }
}
