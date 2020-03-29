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
        Role::insert([
            [
                'name' => config('constants.roles.admin'),
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'name' => config('constants.roles.dept'),
                'created_at' => now(),
                'updated_at' => now()
            ]
        ]);
    }
}
