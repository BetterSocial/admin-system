<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterTableUserFollowUserAddIsAnonField extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('user_follow_user', function (Blueprint $table) {
            $table->boolean('is_anonymous')->nullable()->default(false);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('user_follow_user', function (Blueprint $table) {
            $table->dropColumn("is_anonymous");
        });
    }
}
