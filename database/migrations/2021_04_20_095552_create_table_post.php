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
        Schema::create('posts', function (Blueprint $table) {
            $table->uuid('post_id')->primary();
            $table->string('author_user_id', 50)->nullable(false);
            $table->boolean('anonymous')->default('N');
            $table->uuid('parent_post_id')->nullable(true);
            $table->string('audience_id', 50)->nullable(true);
            $table->string('duration')->nullable(true);
            $table->string('visibility_location_id')->nullable(true);
            $table->bigInteger('topic_id');
            $table->longText('post_content')->nullable(false);
            $table->timestamp('created_at')->default(DB::raw('CURRENT_TIMESTAMP'));
            $table->timestamp('updated_at')->default(DB::raw('CURRENT_TIMESTAMP'));
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('posts');
    }
}
