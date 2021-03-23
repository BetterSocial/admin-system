<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePostStatistic extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('post_statistic', function (Blueprint $table) {
            $table->string('post_id',50)->primary()->nullable(false);
            $table->bigInteger('view_count');
            $table->bigInteger('upvote_count');
            $table->bigInteger('downvote_count');
            $table->bigInteger('block_count');
            $table->bigInteger('shared_count');
            $table->bigInteger('comment_count');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('post_statistic');
    }
}
