<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUserFollowDomainHistoryTabel extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_follow_domain_history_tabel', function (Blueprint $table) {
            $table->string('follow_domain_history_id', 50)->primary();
            $table->string('user_id_follower', 50);
            $table->integer('domain_id_followed');
            $table->string('action', 5)->nullable(false);
            $table->string('source', 50)->nullable(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('user_follow_domain_history_tabel');
    }
}
