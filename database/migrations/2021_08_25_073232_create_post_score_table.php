<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePostScoreTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        
        Schema::create('post_score', function (Blueprint $table) {
            $table->uuid('post_score_id');
            $table->uuid('feed_id');
            $table->bigInteger('post_score')->default(0);
            $table->timestamps();
        });

        DB::statement('ALTER TABLE post_score ALTER COLUMN post_score_id SET DEFAULT uuid_generate_v4 ()');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('post_score');
    }
}
