<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUserLocationTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_location', function (Blueprint $table) {
            $table->bigIncrements('user_location_id')->nullable(false);
            $table->string('user_id',50);
            $table->bigInteger('location_id');
            $table->timestamp('created_at');
            $table->timestamp('updated_at');
            $table->unique(['user_id', 'location_id']);

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('user_location');
    }
}
