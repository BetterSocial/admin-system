<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUserScoreTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_score', function (Blueprint $table) {
            $table->uuid('user_score_id');
            $table->uuid('user_id');
            $table->bigInteger('user_score')->default(0);
            $table->timestamps();
        });

        DB::statement('ALTER TABLE user_score ALTER COLUMN user_score_id SET DEFAULT uuid_generate_v4 ()');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('user_score');
    }
}
