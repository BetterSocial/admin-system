<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnForChannelContext extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('chat_anon_user_info', function (Blueprint $table) {
            $table->enum('context', ['other profile', 'chat', 'post', 'follow'])->nullable();
            $table->string('initiator')->nullable();
            $table->string('source_id')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('chat_anon_user_info', function (Blueprint $table) {
            $table->dropColumn("context");
            $table->dropColumn("initiator");
            $table->dropColumn("source_id");
        });
    }
}
