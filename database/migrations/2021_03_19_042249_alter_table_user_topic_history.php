<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterTableUserTopicHistory extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // DB::statement('ALTER TABLE user_topic_history RENAME COLUMN location_id TO topic_id ');
        Schema::table('user_topic_history', function (Blueprint $table) {
            Schema::rename('location_id', 'topic_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
