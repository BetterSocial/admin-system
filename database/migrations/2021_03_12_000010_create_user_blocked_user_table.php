<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
class CreateUserBlockedUserTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_blocked_user', function (Blueprint $table) {
            $table->string('blocked_action_id',50);
            $table->string('user_id_blocker',50);
            $table->string('user_id_blocked',50);
            $table->json('reason_blocked')->nullable(true);
            $table->unique(['user_id_blocker', 'user_id_blocked']);
        });
    }
    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('user_blocked_user');
    }
}
