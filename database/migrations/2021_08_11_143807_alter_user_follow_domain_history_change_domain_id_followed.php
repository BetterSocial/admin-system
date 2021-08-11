<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterUserFollowDomainHistoryChangeDomainIdFollowed extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('user_follow_domain_history', function (Blueprint $table) {
            $table->string('domain_id_followed', 50)->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('user_follow_domain_history', function (Blueprint $table) {
            $table->integer('domain_id_followed');
        });
    }
}
