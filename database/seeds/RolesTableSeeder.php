<?php

use App\Models\Role;
use Illuminate\Database\Seeder;

class RolesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Role::create([
            'name' => config('constants.roles.admin')
        ]);

        Role::create([
            'name' => config('constants.roles.dept')
        ]);
    }
}
