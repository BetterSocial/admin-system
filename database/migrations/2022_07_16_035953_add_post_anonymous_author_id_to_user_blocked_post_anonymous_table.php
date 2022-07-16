<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddPostAnonymousAuthorIdToUserBlockedPostAnonymousTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('user_blocked_post_anonymous', function (Blueprint $table) {
            $table->string('post_anonymous_author_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('user_blocked_post_anonymous', function (Blueprint $table) {
            $table->dropColumn('post_anonymous_author_id');
        });
    }
}
