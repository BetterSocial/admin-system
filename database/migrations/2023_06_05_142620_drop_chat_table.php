<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class DropChatTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::dropIfExists('chat');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::create('chat', function (Blueprint $table) {
            $table->uuid('chat_id');
            $table->uuid('user_id');
            $table->string('channel_id');
            $table->text('message');
            $table->timestamps();
        });
    }
}
