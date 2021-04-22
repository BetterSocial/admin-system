<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterTableUuid extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::statement('CREATE EXTENSION IF NOT EXISTS "uuid-ossp"');
        DB::statement('ALTER TABLE posts ALTER COLUMN post_id SET DEFAULT uuid_generate_v4 ()');
        DB::statement('ALTER TABLE polling ALTER COLUMN polling_id SET DEFAULT uuid_generate_v4 ()');
        DB::statement('ALTER TABLE polling_option ALTER COLUMN polling_option_id SET DEFAULT uuid_generate_v4 ()');
        DB::statement('ALTER TABLE log_polling ALTER COLUMN log_polling_id SET DEFAULT uuid_generate_v4 ()');

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
