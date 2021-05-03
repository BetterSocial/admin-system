<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTableQuestionAnswer extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('question_answer', function (Blueprint $table) {
            $table->uuid('question_answer_id')->primary();;
            $table->uuid('question_id')->nullable(false);
            $table->string('question_type',50)->nullable(false);
            $table->timestamp('created_at');
            $table->timestamp('updated_at');
        });
        DB::statement('ALTER TABLE question_answer ALTER COLUMN question_answer_id SET DEFAULT uuid_generate_v4 ()');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('question_answer');
    }
}
