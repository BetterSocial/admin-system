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
            $table->string('post_id',50)->primary()->nullable(false);;
            $table->bigIncrements('view_count');
            $table->bigIncrements('upvote_count');
            $table->bigIncrements('downvote_count');
            $table->bigIncrements('block_count');
            $table->bigIncrements('shared_count');
            $table->bigIncrements('comment_count');
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
