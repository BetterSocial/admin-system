<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddValueToContextEnumInChatAnonUserInfo extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::statement("ALTER TABLE chat_anon_user_info MODIFY COLUMN context ENUM('other profile', 'chat', 'post', 'follow', 'auto message')");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::statement("ALTER TABLE chat_anon_user_info MODIFY COLUMN context ENUM('other profile', 'chat', 'post', 'follow')");
    }
}
