<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddCredderLastCheckedToDomainPage extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('domain_page', function (Blueprint $table) {
            $table->date('credder_last_checked')->after('credder_score')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('domain_page', function (Blueprint $table) {
            $table->dropColumn('credder_last_checked');
        });
    }
}
