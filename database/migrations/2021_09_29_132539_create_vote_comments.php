<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CreateVoteComments extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // Schema::create('vote_comments', function (Blueprint $table) {
        //     $table->id();
        //     $table->timestamps();
        // });
        Schema::create('vote_comments', function (Blueprint $table) {
            $table->uuid('id');
            $table->uuid('comment_id');
            $table->uuid('user_id');
            $table->string('status');
            $table->timestamps();
        });

        DB::statement('ALTER TABLE vote_comments ALTER COLUMN id SET DEFAULT uuid_generate_v4 ()');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('vote_comments');
    }
}
