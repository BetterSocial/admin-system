<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class UserAdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {   
        DB::table('users_admin')->truncate();
		DB::table('users_admin')->insert([
                ['name' => 'Bastian','email' => 'bastian@bettersocial.org','password'=>bcrypt('bettersocial'),'created_at'=> Carbon::now()->format('Y-m-d H:i:s'), 'updated_at'=>Carbon::now()->format('Y-m-d H:i:s')],
                ['name' => 'Ali Irawan','email' => 'aliirawan@bettersocial.org','password'=>bcrypt('bettersocial'),'created_at'=> Carbon::now()->format('Y-m-d H:i:s'), 'updated_at'=>Carbon::now()->format('Y-m-d H:i:s')],
                ['name' => 'Dede Su','email' => 'dedesu@bettersocial.org','password'=>bcrypt('bettersocial'),'created_at'=> Carbon::now()->format('Y-m-d H:i:s'), 'updated_at'=>Carbon::now()->format('Y-m-d H:i:s')],
                ['name' => 'Nyoman','email' => 'nyoman@bettersocial.org','password'=>bcrypt('bettersocial'),'created_at'=> Carbon::now()->format('Y-m-d H:i:s'), 'updated_at'=>Carbon::now()->format('Y-m-d H:i:s')],
                ['name' => 'Budi','email' => 'budi@bettersocial.org','password'=>bcrypt('bettersocial'),'created_at'=> Carbon::now()->format('Y-m-d H:i:s'), 'updated_at'=>Carbon::now()->format('Y-m-d H:i:s')],
                ['name' => 'Amril','email' => 'amril@bettersocial.org','password'=>bcrypt('bettersocial'),'created_at'=> Carbon::now()->format('Y-m-d H:i:s'), 'updated_at'=>Carbon::now()->format('Y-m-d H:i:s')],
                ['name' => 'Putu','email' => 'putu@bettersocial.org','password'=>bcrypt('bettersocial'),'created_at'=> Carbon::now()->format('Y-m-d H:i:s'), 'updated_at'=>Carbon::now()->format('Y-m-d H:i:s')],
                ['name' => 'Usup','email' => 'usup@bettersocial.org','password'=>bcrypt('bettersocial'),'created_at'=> Carbon::now()->format('Y-m-d H:i:s'), 'updated_at'=>Carbon::now()->format('Y-m-d H:i:s')],
                ['name' => 'Kevin','email' => 'kevin@bettersocial.org','password'=>bcrypt('bettersocial'),'created_at'=> Carbon::now()->format('Y-m-d H:i:s'), 'updated_at'=>Carbon::now()->format('Y-m-d H:i:s')],
                ['name' => 'Reyvin','email' => 'reyvin@bettersocial.org','password'=>bcrypt('bettersocial'),'created_at'=> Carbon::now()->format('Y-m-d H:i:s'), 'updated_at'=>Carbon::now()->format('Y-m-d H:i:s')],


                ]
		);
    }
}
