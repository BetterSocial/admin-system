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
        Schema::create('chatAnonUserInfo', function (Blueprint $table) {
            $table->uuid('chat_id');
            $table->string('channelId');
            $table->uuid('targetUserId');
            $table->uuid('myAnonUserId');
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
        Schema::dropIfExists('chatAnonUserInfo');
    }
}
