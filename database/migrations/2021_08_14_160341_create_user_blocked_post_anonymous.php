<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUserBlockedPostAnonymous extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_blocked_post_anonymous', function (Blueprint $table) {
            $table->string('blocked_action_id', 50)->primary();
            $table->uuid('user_id_blocker');
            $table->uuid('user_id_blocked');
            $table->json('reason_blocked')->nullable();
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
        Schema::dropIfExists('user_blocked_post_anonymous');
    }
}
