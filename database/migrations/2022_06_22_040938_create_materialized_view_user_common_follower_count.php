<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CreateMaterializedViewUserCommonFollowerCount extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::statement("
            CREATE MATERIALIZED VIEW vwm_user_common_follower_count
            AS
            SELECT 
                    A.user_id_followed as source,
                    B.user_id_followed as target,
                    COUNT(*) AS common
                FROM
                    (SELECT DISTINCT user_id_followed FROM user_follow_user) AS A
                CROSS JOIN
                    (SELECT DISTINCT user_id_followed FROM user_follow_user) AS B 
                JOIN user_follow_user as AF
                    ON A.user_id_followed = AF.user_id_followed
                JOIN user_follow_user as BF
                    ON B.user_id_followed = BF.user_id_followed
                AND AF.user_id_follower = BF.user_id_follower
                WHERE A.user_id_followed != B.user_id_followed
                GROUP BY A.user_id_followed, B.user_id_followed
                ORDER BY common DESC, A.user_id_followed
            WITH DATA"
        );
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::statement("DROP IF EXISTS vwm_user_common_follower_count");
    }
}
