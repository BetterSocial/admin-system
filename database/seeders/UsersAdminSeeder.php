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
                ['name' => 'Bastian','email' => 'bastian@better.com','password'=>bcrypt('bettersocial'),'created_at'=> Carbon::now()->format('Y-m-d H:i:s'), 'updated_at'=>Carbon::now()->format('Y-m-d H:i:s')],
                ['name' => 'Ali Irawan','email' => 'aliirawan@better.com','password'=>bcrypt('bettersocial'),'created_at'=> Carbon::now()->format('Y-m-d H:i:s'), 'updated_at'=>Carbon::now()->format('Y-m-d H:i:s')],
                ['name' => 'Dede Su','email' => 'dedesu@better.com','password'=>bcrypt('bettersocial'),'created_at'=> Carbon::now()->format('Y-m-d H:i:s'), 'updated_at'=>Carbon::now()->format('Y-m-d H:i:s')],
                ['name' => 'Nyoman','email' => 'nyoman@better.com','password'=>bcrypt('bettersocial'),'created_at'=> Carbon::now()->format('Y-m-d H:i:s'), 'updated_at'=>Carbon::now()->format('Y-m-d H:i:s')],
                ['name' => 'Budi','email' => 'budi@better.com','password'=>bcrypt('bettersocial'),'created_at'=> Carbon::now()->format('Y-m-d H:i:s'), 'updated_at'=>Carbon::now()->format('Y-m-d H:i:s')],
                ['name' => 'Amril','email' => 'amril@better.com','password'=>bcrypt('bettersocial'),'created_at'=> Carbon::now()->format('Y-m-d H:i:s'), 'updated_at'=>Carbon::now()->format('Y-m-d H:i:s')],
                ['name' => 'Putu','email' => 'putu@better.com','password'=>bcrypt('bettersocial'),'created_at'=> Carbon::now()->format('Y-m-d H:i:s'), 'updated_at'=>Carbon::now()->format('Y-m-d H:i:s')],
                ['name' => 'Usup','email' => 'usup@better.com','password'=>bcrypt('bettersocial'),'created_at'=> Carbon::now()->format('Y-m-d H:i:s'), 'updated_at'=>Carbon::now()->format('Y-m-d H:i:s')],
                ['name' => 'Kevin','email' => 'kevin@better.com','password'=>bcrypt('bettersocial'),'created_at'=> Carbon::now()->format('Y-m-d H:i:s'), 'updated_at'=>Carbon::now()->format('Y-m-d H:i:s')],
                ['name' => 'Reyvin','email' => 'reyvin@better.com','password'=>bcrypt('bettersocial'),'created_at'=> Carbon::now()->format('Y-m-d H:i:s'), 'updated_at'=>Carbon::now()->format('Y-m-d H:i:s')],


                ]
		);
    }
}
