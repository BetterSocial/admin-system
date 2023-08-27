<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddParentCommentAndAnonymousTableComments extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('user_post_comment', function (Blueprint $table) {
            $table->uuid('parent_comment_id')->after('post_id')->nullable(true);
            $table->boolean('is_anonymous')->after('commenter_user_id')->default(false);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('user_post_comment', function (Blueprint $table) {
            $table->dropColumn('parent_comment_id');
            $table->dropColumn('is_anonymous');
        });
    }
}
