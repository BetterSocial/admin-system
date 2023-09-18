<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class DropVwmUserFollowerCountV1 extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::statement("DROP MATERIALIZED VIEW IF EXISTS vwm_user_follower_count");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        // Create materialized view v1
        DB::statement("
            CREATE MATERIALIZED VIEW vwm_user_follower_count
            AS 
            SELECT
                A.user_id_followed,
                COUNT(A.user_id_follower) as follower_count
            FROM user_follow_user A
            GROUP BY A.user_id_followed
            WITH DATA
        ");
    }
}
