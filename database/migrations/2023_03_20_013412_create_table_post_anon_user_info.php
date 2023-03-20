<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTablePostAnonUserInfo extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('post_anon_user_info', function (Blueprint $table) {
            $table->uuid('post_id');
            $table->string('anon_user_id');
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
        Schema::dropIfExists('post_anon_user_info');
    }
}
