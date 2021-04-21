<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;


class SpattyRoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Reset cached roles and permissions
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        // this can be done as separate statements
        $role = Role::create(['name' => 'viewer']);

        $role = Role::create(['name' => 'editor']);

        $role = Role::create(['name' => 'admin']);
    }
}
