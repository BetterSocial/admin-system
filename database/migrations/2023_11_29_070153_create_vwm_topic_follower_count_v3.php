<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class CreateVwmTopicFollowerCountV3 extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::statement("
        CREATE MATERIALIZED VIEW public.vwm_user_topic_follower_count_rank
        AS SELECT user_topic_by_follower_count.topic_id,
            user_topic_by_follower_count.follower_count,
            user_topic_by_follower_count.topic_follower_rank,
            user_topic_by_follower_count.user_id,
            user_topic_by_follower_count.human_id,
            user_topic_by_follower_count.country_code,
            user_topic_by_follower_count.username,
            user_topic_by_follower_count.real_name,
            user_topic_by_follower_count.created_at,
            user_topic_by_follower_count.updated_at,
            user_topic_by_follower_count.last_active_at,
            user_topic_by_follower_count.status,
            user_topic_by_follower_count.profile_pic_path,
            user_topic_by_follower_count.profile_pic_asset_id,
            user_topic_by_follower_count.profile_pic_public_id,
            user_topic_by_follower_count.bio,
            user_topic_by_follower_count.is_banned,
            user_topic_by_follower_count.is_anonymous,
            user_topic_by_follower_count.encrypted,
            user_topic_by_follower_count.allow_anon_dm,
            user_topic_by_follower_count.only_received_dm_from_user_following,
            user_topic_by_follower_count.is_backdoor_user,
            user_topic_by_follower_count.karma_score
        FROM ( SELECT a.topic_id,
                    c.follower_count,
                    row_number() OVER (PARTITION BY a.topic_id ORDER BY c.follower_count DESC) AS topic_follower_rank,
                    b.user_id,
                    b.human_id,
                    b.country_code,
                    b.username,
                    b.real_name,
                    b.created_at,
                    b.updated_at,
                    b.last_active_at,
                    b.status,
                    b.profile_pic_path,
                    b.profile_pic_asset_id,
                    b.profile_pic_public_id,
                    b.bio,
                    b.is_banned,
                    b.is_anonymous,
                    b.encrypted,
                    b.allow_anon_dm,
                    b.only_received_dm_from_user_following,
                    b.is_backdoor_user,
                    b.karma_score
                FROM vwm_user_follower_count c
                    JOIN users b ON c.user_id_followed::text = b.user_id::text
                    JOIN user_topics a ON c.user_id_followed::text = a.user_id::text
                WHERE b.profile_pic_path !~~ '%default-profile-picture%'::text
                GROUP BY a.topic_id, b.user_id, c.follower_count) user_topic_by_follower_count
        WHERE user_topic_by_follower_count.topic_follower_rank <= 11
        ORDER BY
            user_topic_by_follower_count.karma_score DESC,
            user_topic_by_follower_count.topic_id,
            user_topic_by_follower_count.topic_follower_rank
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
        DB::statement("DROP MATERIALIZED VIEW IF EXISTS vwm_user_topic_follower_count_rank");
    }
}
