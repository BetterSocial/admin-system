<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
class CreateUserFollowUserTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_follow_user', function (Blueprint $table) {
            $table->string('follow_action_id',50)->nullable(false);
            $table->string('user_id_follower',50);
            $table->string('user_id_followed',50);
            $table->unique(['user_id_follower', 'user_id_followed']);
        });
    }
    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('user_follow_user');
    }
}
