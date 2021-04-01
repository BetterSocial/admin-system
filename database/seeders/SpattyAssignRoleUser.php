<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class SpattyAssignRoleUser extends Seeder
{

    public function run()
    {

        $user = User::where('email','kevin@bettersocial.org')->first();
        $user->assignRole('admin');

        $user = User::where('email','reyvin@bettersocial.org')->first();
        $user->assignRole('editor');

        $user = User::where('email','nyoman@bettersocial.org')->first();
        $user->assignRole('viewer');


    }
}
