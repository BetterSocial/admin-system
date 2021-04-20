<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTableLogPolling extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('log_polling', function (Blueprint $table) {
            $table->uuid('log_polling_id')->primary();
            $table->uuid('polling_option_id')->nullable(false);
            $table->uuid('polling_id')->nullable(false);
            $table->string('user_id',50)->nullable(false);
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
        Schema::dropIfExists('log_polling');
    }
}
