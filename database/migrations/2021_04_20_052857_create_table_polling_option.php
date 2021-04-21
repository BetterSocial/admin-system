<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTablePollingOption extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('polling_option', function (Blueprint $table) {
            $table->uuid('polling_option_id')->primary();
            $table->uuid('polling_id')->nullable(false);
            $table->longText('option')->nullable(false);
            $table->bigInteger('counter')->default(0);;
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
        Schema::dropIfExists('polling_option');
    }
}
