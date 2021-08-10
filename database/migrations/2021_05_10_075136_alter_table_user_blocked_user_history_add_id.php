<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class AlterTableUserBlockedUserHistoryAddId extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::dropIfExists('user_blocked_user_history');

        Schema::create('user_blocked_user_history', function (Blueprint $table) {
            $table->uuid('user_blocked_user_history_id');
            $table->string('user_id_blocker', 50);
            $table->string('user_id_blocked', 50);
            $table->string('action', 5);
            $table->string('source', 50);
        });
        DB::statement('ALTER TABLE user_blocked_user_history ALTER COLUMN user_blocked_user_history_id SET DEFAULT uuid_generate_v4();');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('user_blocked_user_history');
    }
}
