<?php

namespace Database\Seeders;

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
        // \App\Models\User::factory(10)->create();
        $this->call(DomainSeeder::class);
//        $this->call(RoleSeeder::class);
        $this->call(UsersAdminSeeder::class);
        $this->call(SpattyRoleSeeder::class);
        $this->call(SpattyAssignRoleUser::class);

    }
}
