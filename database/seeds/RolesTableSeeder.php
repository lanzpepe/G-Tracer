<?php

use App\Models\Role;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;

class RolesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $role = new Role();

        $role->id = Str::random();
        $role->name = config('constants.roles.admin');
        $role->save();

        $role = new Role();

        $role->id = Str::random();
        $role->name = config('constants.roles.dept');
        $role->save();
    }
}
