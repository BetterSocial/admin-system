<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
class CreateUserBlockedUserHistoryTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_blocked_user_history', function (Blueprint $table) {
            $table->string('user_id_blocker',50);
            $table->string('user_id_blocked',50);
            $table->string('action',5);            
            $table->string('source',50);            
        });
    }
    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('user_blocked_user_history');
    }
}
