<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateChannelMessagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('channel_messages', function (Blueprint $table) {
            $table->id();
            $table->uuid('message_id')->nullable(false);
            $table->string('channel_id')->references('channel_id')->on('channels')->onDelete('cascade')->nullable(false);
            $table->string('user_id')->references('user_id')->on('users')->onDelete('cascade')->nullable(false);
            $table->string('message')->nullable(false);
            $table->boolean('is_read_by_admin')->default(false);
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
        Schema::dropIfExists('channel_messages');
    }
}
