<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterTablePostVotedBlockedShared extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::statement('ALTER TABLE post_upvoted ALTER COLUMN post_id SET DATA TYPE UUID USING post_id::uuid;');
        DB::statement('ALTER TABLE post_downvoted ALTER COLUMN post_id SET DATA TYPE UUID USING post_id::uuid;');
        DB::statement('ALTER TABLE post_blocked ALTER COLUMN post_id SET DATA TYPE UUID USING post_id::uuid;');
        DB::statement('ALTER TABLE post_shared ALTER COLUMN post_id SET DATA TYPE UUID USING post_id::uuid;');



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
