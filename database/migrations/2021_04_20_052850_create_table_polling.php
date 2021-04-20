<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTablePolling extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('polling', function (Blueprint $table) {
            $table->uuid('polling_id')->primary();
            $table->longText('question')->nullable(false);
            $table->string('user_id',50)->nullable(false);
            $table->boolean('flg_multiple')->default('N');
            $table->timestamp('created_at');
            $table->timestamp('updated_at');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('polling');
    }
}
