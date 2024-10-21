<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateChannelMemberTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('channel_members', function (Blueprint $table) {
            $table->id();
            $table->string('channel_id')->references('channel_id')->on('channel')->onDelete('cascade')->nullable(false);
            $table->string('user_id')->references('user_id')->on('users')->onDelete('cascade')->nullable(false);
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
        Schema::dropIfExists('channel_members');
    }
}
