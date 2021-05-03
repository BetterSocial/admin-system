<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTableBlockQuestion extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('block_question', function (Blueprint $table) {
            $table->uuid('block_question_id')->primary();;
            $table->string('question',1024)->nullable(false);
            $table->string('question_type',50)->nullable(false);
            $table->timestamp('created_at');
            $table->timestamp('updated_at');
        });
        DB::statement('ALTER TABLE block_question ALTER COLUMN block_question_id SET DEFAULT uuid_generate_v4 ()');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('block_question');
    }
}
