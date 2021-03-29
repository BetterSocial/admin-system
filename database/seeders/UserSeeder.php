<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //TODO
        DB::table('user')->insert(
            [
                ['name' => 'Kevin','email' => 'kevin@solusiteknologi.co.id', 'email_verified_at'=> Carbon::now()->format('Y-m-d H:i:s'),
                    'password' => '$2y$10$wUeG8t8qqUaqKQMoBU5bledy6.48bv6bAoJ1TkjJ6bgXchP.BQfcK', 'remember_token' => '',
                    'created_at'=> Carbon::now()->format('Y-m-d H:i:s'), 'updated_at'=>Carbon::now()->format('Y-m-d H:i:s')],

                ['name' => 'Reyvin','email' => 'reyvin@solusiteknologi.co.id', 'email_verified_at'=> Carbon::now()->format('Y-m-d H:i:s'),
                    'password' => '$2y$10$wUeG8t8qqUaqKQMoBU5bledy6.48bv6bAoJ1TkjJ6bgXchP.BQfcK', 'remember_token' => '',
                    'created_at'=> Carbon::now()->format('Y-m-d H:i:s'), 'updated_at'=>Carbon::now()->format('Y-m-d H:i:s')],

            ]
        );
    }
}
