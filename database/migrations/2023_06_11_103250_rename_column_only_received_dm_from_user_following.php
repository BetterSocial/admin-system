<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class RenameColumnOnlyReceivedDmFromUserFollowing extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->renameColumn('onlyReceivedAnonDmFromUserFollowing', 'onlyReceivedDmFromUserFollowing');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->renameColumn('onlyReceivedDmFromUserFollowing', 'onlyReceivedAnonDmFromUserFollowing');
        });
    }
}
