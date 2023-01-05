<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUserPostCommentTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_post_comment', function (Blueprint $table) {
            $table->uuid('id');
            $table->uuid('post_id')->nullable(false);
            $table->uuid('comment_id')->nullable(false);
            $table->uuid('author_user_id')->nullable(false);
            $table->uuid('commenter_user_id')->nullable(false);
            $table->string('comment')->nullable(true);
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
        Schema::dropIfExists('user_post_comment');
    }
}
