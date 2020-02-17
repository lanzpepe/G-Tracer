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
            AcademicYearsTableSeeder::class,
            RolesTableSeeder::class,
            AdminsTableSeeder::class,
            GendersTableSeeder::class
            /* GraduatesTableSeeder::class,
            UsersTableSeeder::class, */
        ]);
    }
}
