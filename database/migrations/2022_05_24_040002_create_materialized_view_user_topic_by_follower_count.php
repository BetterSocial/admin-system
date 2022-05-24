<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CreateMaterializedViewUserTopicByFollowerCount extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::statement("
            CREATE MATERIALIZED VIEW vwm_user_topic_by_follower_count
            AS
            SELECT 
                COUNT(C.user_id_follower) as follower_count,
                D.username, 
                C.user_id_followed,
                F.name as topic_name,
                F.topic_id
            FROM 
                user_follow_user C
            INNER JOIN 
                users D
            ON 
                C.user_id_followed = D.user_id
            INNER JOIN 
                user_topics E
            ON 
                E.user_id = D.user_id
            INNER JOIN
                topics F
            ON 
                E.topic_id = F.topic_id
            GROUP BY 
                C.user_id_followed, 
                D.username,
                F.name,
                F.topic_id
            ORDER BY 
                F.topic_id ASC,
                follower_count DESC
            WITH DATA;
        ");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::statement("DROP MATERIALIZED VIEW IF EXISTS vwm_user_topic_by_follower_count");
    }
}
