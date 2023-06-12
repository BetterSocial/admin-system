<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateChatAnonUserInfoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('chat_anon_user_info', function (Blueprint $table) {
            $table->uuid('chat_id');
            $table->string('channel_id');
            $table->uuid('target_user_id');
            $table->uuid('my_anon_user_id');
            $table->string('anon_user_info_color_name');
            $table->string('anon_user_info_color_code');
            $table->string('anon_user_info_emoji_name');
            $table->string('anon_user_info_emoji_code');
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
        Schema::dropIfExists('chat_anon_user_info');
    }
}
