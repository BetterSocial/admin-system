<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class DropVwmUserTopicFollowerCountRank extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::statement("DROP MATERIALIZED VIEW IF EXISTS vwm_user_topic_follower_count_rank");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::statement("
            CREATE MATERIALIZED VIEW vwm_user_topic_follower_count_rank
            AS
            SELECT
                *
            FROM
            (
                SELECT
                    B.location_id,
                    A.follower_count,
                    RANK() OVER(
                        PARTITION BY B.location_id
                        ORDER BY A.follower_count DESC
                    ) as follower_rank,
                    C.*
                FROM 
                    vwm_user_follower_count A
                INNER JOIN
                    user_location B
                ON 
                    A.user_id_followed = B.user_id
                INNER JOIN
                    users C
                ON C.user_id = A.user_id_followed
            ) user_location_follower_rank
            WHERE follower_rank <= 5
            WITH DATA"
        );
    }
}