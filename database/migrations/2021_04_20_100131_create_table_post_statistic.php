<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTablePostStatistic extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::dropIfExists('post_statistic');

        Schema::create('post_statistic', function (Blueprint $table) {
            $table->uuid('post_id')->primary();;
            $table->double('view_count')->nullable(false);
            $table->double('upvote_count')->default(0);
            $table->double('downvote_count')->default(0);
            $table->double('block_count')->nullable(true);
            $table->double('shared_count')->nullable(true);
            $table->double('comment_count')->nullable(true);
            $table->timestamp('created_at');
            $table->timestamp('updated_at');
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
