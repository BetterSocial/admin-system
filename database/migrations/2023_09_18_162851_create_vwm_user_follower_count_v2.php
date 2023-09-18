<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CreateVwmUserFollowerCountV2 extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::statement("
            CREATE MATERIALIZED VIEW vwm_user_follower_count
            AS 
            SELECT
                B.user_id as user_id_followed,
                COUNT(A.user_id_follower) as follower_count
            FROM user_follow_user A
            RIGHT OUTER JOIN users B 
            ON A.user_id_followed = B.user_id
            WHERE B.encrypted IS NULL
            GROUP BY A.user_id_followed, B.user_id
            WITH DATA
        ");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::statement("DROP MATERIALIZED VIEW IF EXISTS vwm_user_follower_count");
    }
}
