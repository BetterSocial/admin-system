<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUserBlockedDomain extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_blocked_domain', function (Blueprint $table) {
            $table->uuid('user_blocked_domain_id');
            $table->string('user_id_blocker',50);
            $table->bigInteger('domain_page_id');
            $table->json('reason_blocked')->nullable();
            $table->unique(['user_id_blocker', 'domain_page_id']);
            $table->timestamps();
        });

        DB::statement('ALTER TABLE user_blocked_domain ALTER COLUMN user_blocked_domain_id SET DEFAULT uuid_generate_v4 ()');

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('user_blocked_domain');
    }
}
