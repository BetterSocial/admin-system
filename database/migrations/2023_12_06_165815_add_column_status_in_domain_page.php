<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class AddColumnStatusInDomainPage extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::statement("CREATE TYPE status AS ENUM ('show', 'hide')");


        DB::statement("ALTER TABLE domain_page ADD COLUMN status status NOT NULL DEFAULT 'show'");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('domain_page', function (Blueprint $table) {
            $table->dropColumn('status');
        });

        DB::statement('DROP TYPE status');
    }
}
