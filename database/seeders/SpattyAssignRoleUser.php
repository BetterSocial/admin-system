<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class SpattyAssignRoleUser extends Seeder
{

    public function run()
    {

        $user = User::where('email','superadmin@bettersocial.org')->first();
        $user->assignRole('admin');

        $user = User::where('email','viewer@bettersocial.org')->first();
        $user->assignRole('viewer');


        $user = User::where('email','bastian@bettersocial.org')->first();
        $user->assignRole('editor');
        $user = User::where('email','aliirawan@bettersocial.org')->first();
        $user->assignRole('editor');
        $user = User::where('email','dedesu@bettersocial.org')->first();
        $user->assignRole('editor');
        $user = User::where('email','nyoman@bettersocial.org')->first();
        $user->assignRole('editor');
        $user = User::where('email','budi@bettersocial.org')->first();
        $user->assignRole('editor');
        $user = User::where('email','amril@bettersocial.org')->first();
        $user->assignRole('editor');
        $user = User::where('email','putu@bettersocial.org')->first();
        $user->assignRole('editor');
        $user = User::where('email','usup@bettersocial.org')->first();
        $user->assignRole('editor');
        $user = User::where('email','kevin@bettersocial.org')->first();
        $user->assignRole('editor');
        $user = User::where('email','reyvin@bettersocial.org')->first();
        $user->assignRole('editor');




    }
}
