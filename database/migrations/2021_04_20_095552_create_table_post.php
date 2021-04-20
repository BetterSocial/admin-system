<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTablePost extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('post_comment', function (Blueprint $table) {
            $table->uuid('post_id');
            $table->string('author_user_id',50)->nullable(false);
            $table->boolean('anonymous')->default('N');
            $table->uuid('parent_post_id')->nullable(true);
            $table->string('audience_id',50)->nullable(true);
            $table->string('duration')->nullable(true);
            $table->string('visibility_location_id')->nullable(true);
            $table->bigint('topic_id');
            $table->longText('post_content')->nullable(false);
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
        Schema::dropIfExists('post_comment');
    }
}
