<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('channel_members', function (Blueprint $table) {
            $table->string('anon_user_info_emoji_code')->nullable(true);
            $table->string('anon_user_info_emoji_name')->nullable(true);
            $table->string('anon_user_info_color_code')->nullable(true);
            $table->string('anon_user_info_color_name')->nullable(true);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('channel_members', function (Blueprint $table) {
            $table->dropColumn('anon_user_info_emoji_code');
            $table->dropColumn('anon_user_info_emoji_name');
            $table->dropColumn('anon_user_info_color_code');
            $table->dropColumn('anon_user_info_color_name');
        });
    }
};
