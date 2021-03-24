<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePostBlocked extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('post_blocked', function (Blueprint $table) {
            $table->string('post_id',255)->primary()->nullable(false);
            $table->string('user_id',50);
            $table->timestamp('created_at');
            $table->timestamp('updated_at');
            $table->unique(['post_id', 'user_id']);
            $table->foreign('user_id')->references('user_id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('post_blocked');
    }
}
