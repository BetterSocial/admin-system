<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
		DB::table('role')->insert(
			[
				['role_name' => 'Admin','role_type' => 'Admin','created_at'=> Carbon::now()->format('Y-m-d H:i:s'), 'updated_at'=>Carbon::now()->format('Y-m-d H:i:s')],
				['role_name' => 'Editor','role_type' => 'Editor','created_at'=> Carbon::now()->format('Y-m-d H:i:s'), 'updated_at'=>Carbon::now()->format('Y-m-d H:i:s')],
        ['role_name' => 'Viewer','role_type' => 'Viewer','created_at'=> Carbon::now()->format('Y-m-d H:i:s'), 'updated_at'=>Carbon::now()->format('Y-m-d H:i:s')],
        ['role_name' => 'Users','role_type' => 'Users','created_at'=> Carbon::now()->format('Y-m-d H:i:s'), 'updated_at'=>Carbon::now()->format('Y-m-d H:i:s')]
			]
		);
    }
}
