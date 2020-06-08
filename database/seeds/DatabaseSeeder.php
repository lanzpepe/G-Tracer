<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call([
            SchoolsTableSeeder::class,
            DepartmentsTableSeeder::class,
            SchoolYearsTableSeeder::class,
            BatchesTableSeeder::class,
            RolesTableSeeder::class,
            AdminsTableSeeder::class,
            GendersTableSeeder::class,
            RanksTableSeeder::class,
            // UsersTableSeeder::class
        ]);
}
}
