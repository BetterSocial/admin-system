<?php

return [
    'get_stream_key' => env('GET_STREAM_KEY'),
    'get_stream_secret' => env('GET_STREAM_SECRET'),

    //p1 PostScore 1 (User & Post specific)
    'weight_post_topic'=>env('W_TOPIC',2),
    'weight_post_follows'=>env('W_FOLLOWS',3),
    'weight_post_2degree'=> env('W_2DEGREE',1.5),
    'weight_post_linkdomain'=> env('W_LINKDOMAIN',2.5),
    'weight_post_domainpost'=> env('W_DOMAINPOST',3),
    'weight_post_domainpost2nd'=> env('W_DOMAINPOST2ND',1.3),

    //p2 PostScore stable factors
    'weight_recency_score' => env('W_REC',1),
    'weight_post_count' => env('W_P',1),
    'recommended_maximum_of_weekly_post' => env('P_REC',7),
    'weight_anonymous_post' => env('W_ANON',0.8),
    'weight_post_has_topic' => env('W_HASTOPIC',1.05),
    'weight_post_has_link' => env('W_HASLINK',1.2),
    'weight_post_short' => env('W_SHORT',0.6),
    'weight_post_long' => env('W_LONG',1.2),
    'weight_geo_zip' => env('W_ZIP',2),
    'weight_geo_neighborhood' => env('W_NHOOD',2),
    'weight_geo_city' => env('W_CITY',1.6),
    'weight_geo_state' => env('W_STATE',1.2),
    'weight_geo_country' => env('W_GLOBAL',0.8),
    'weight_geo_global' => env('W_GLOBAL',0.8),
    'weight_privacy_public' => env('W_PUBLIC',0.8),
    'weight_privacy_following' => env('W_FOLLOWING',1.3),

    //p3 (Post Performance + Comments)
//    W_LONGC=1
//    Z_NONBP=0.1
//    Z_UPDOWN=3
//    Z_D=0.9
//    EV_NONBP=99.90%
//    EV_UPDOWN=54.62%
//    EV_D=30.00%
//    WW_NONBP=45
//    WW_UPDOWN=8
//    WW_D=1
//    W_DOWN=-1.2
//    W_N=-0.05
//    DUR_MIN=2500
//    DUR_MARG=400

    'weight_long_comments' => env('W_LONGC',1),
    'z_value_non_bp' => env('Z_NONBP',0.1),
    'z_value_updown_score' => env('Z_UPDOWN',3),
    'z_value_d' => env('Z_D',0.9),
    'expected_value_non_bp' => env('EV_NONBP','99.90%'),
    'expected_value_updown_score' => env('EV_UPDOWN','54.62%'),
    'expected_value_d' => env('EV_D','30.00%'),
    'weight_exponential_non_bp' => env('WW_NONBP',45),
    'weight_exponential_updown_score' => env('WW_UPDOWN',8),
    'weight_exponential_d' => env('WW_D',1),
    'weight_downvote' => env('W_DOWN',-1.2),
    'weight_no_vote' => env('W_N',-0.05),
    'duration_minimum_post' => env('DUR_MIN',2500),
    'duration_marginal_per_word' => env('DUR_MARG',400),

    //Previous interactions with this post
    'multiplier_downvoted_previous_post' => env('PREV_D',0.05),
    'multiplier_upvoted_or_comment_previous_post' => env('PREV_UC',0.8),
    'multiplier_seen_previous_post' => env('PREV_PRE',0.5),

    //Reaction_weights
    'recommended_upvotes_per_user_in_7days' => env('U_REC',50),
    '' => env('D_REC',50),
    '' => env('B_REC',4),

    //Total Score T_t
    'weight_user_score_u' => env('W_U',1),
    '' => env('W_P1',1),
    '' => env('W_P2',1),
    '' => env('W_P3',1),
    '' => env('W_PREV',1),

    //User Score u
    'weight_address_edu' => env('W_EDU',1.4),
    'weight_address_work' => env('W_EMAIL',1.2),
    'weight_twitter' => env('W_TWITTER',2),
    'weight_follower' => env('W_F',1),
    'weight_blocked_p_impression' => env('W_B',1),
    'weight_average_post_score' => env('W_R',1),
    'weight_qualitative_criteria' => env('W_Q',1),
    'weight_account_age' => env('W_A',1),
    'weight_follower_quality' => env('W_Y',1),
    'block_per_post_impression' => env('BPIMPR_GLOBAL',0.005333333333),
    'weight_attribute_jobs' => env('W_ATT',1),



];
