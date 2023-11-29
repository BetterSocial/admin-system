<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class DropVwmTopicFollowerCountV2 extends Migration
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
        FROM (
            SELECT
                A.topic_id,
                C.follower_count as follower_count,
                ROW_NUMBER() OVER(
                    PARTITION BY A.topic_id
                    ORDER BY C.follower_count DESC
                ) AS topic_follower_rank,
                B.*
            FROM
                vwm_user_follower_count C
            INNER JOIN
                users B
            ON C.user_id_followed = B.user_id
            INNER JOIN
                user_topics A
            ON
                C.user_id_followed = A.user_id
						WHERE B.profile_pic_path NOT LIKE '%default-profile-picture%'
            GROUP BY
                A.topic_id,
                B.user_id,
                C.follower_count
            ) AS user_topic_by_follower_count
        WHERE
            user_topic_by_follower_count.topic_follower_rank <= 11
        ORDER BY
            user_topic_by_follower_count.topic_id ASC,
            user_topic_by_follower_count.topic_follower_rank ASC
        WITH DATA
        ");
    }
}
