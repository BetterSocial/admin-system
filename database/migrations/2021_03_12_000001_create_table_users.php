<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->string('user_id',50)->primary()->nullable(false);
            $table->string('human_id',70);
            $table->string('country_code',3);
            $table->string('username',50);
            $table->string('real_name',50);
            $table->timestamp('created_at');
            $table->timestamp('updated_at');
            $table->timestamp('last_active_at');
            $table->string('profile_pic_path',255);
            $table->string('status',1);
            $table->unique(['human_id', 'username']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
    }
}
