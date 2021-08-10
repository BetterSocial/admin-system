<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class AlterTableUserBlockedUserIdType extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::dropIfExists('user_blocked_user');

        Schema::create('user_blocked_user', function (Blueprint $table) {
            $table->uuid('blocked_action_id');
            $table->string('user_id_blocker', 50);
            $table->string('user_id_blocked', 50);
            $table->json('reason_blocked')->nullable();
            $table->unique(['user_id_blocker', 'user_id_blocked']);
        });

        DB::statement('ALTER TABLE user_blocked_user ALTER COLUMN blocked_action_id SET DEFAULT uuid_generate_v4();');
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
