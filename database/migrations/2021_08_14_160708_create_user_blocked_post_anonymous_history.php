<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUserBlockedPostAnonymousHistory extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_blocked_post_anonymous_history', function (Blueprint $table) {
            $table->string('user_blocked_post_anonymous_history_id', 50)->primary();
            $table->uuid('user_id_blocker', 50);
            $table->uuid('post_anonymous_id_blocked');
            $table->string('action', 5);
            $table->string('source', 50);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('user_blocked_post_anonymous_history');
    }
}
