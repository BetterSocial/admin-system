<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterTableForUuid extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::statement('ALTER TABLE user_blocked_user ALTER COLUMN blocked_action_id SET DEFAULT uuid_generate_v4 ()');
        DB::statement('ALTER TABLE user_blocked_user_history ALTER COLUMN user_id_blocker SET DEFAULT uuid_generate_v4 ()');
        DB::statement('ALTER TABLE user_blocked_user_history ALTER COLUMN user_id_blocked SET DATA TYPE UUID USING user_id_blocked::uuid; ');
        DB::statement('ALTER TABLE user_blocked_user ADD COLUMN reason text');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
