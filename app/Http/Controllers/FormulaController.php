<?php

namespace App\Http\Controllers;


use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Domain;
use DB;
use Illuminate\Support\Facades\Log;

class FormulaController extends Controller
{
    public function BenchmarkPostImpression($dur_min,$dur_marg,$words)
    {
        $value = $dur_min + $dur_marg * $words;
        return $value;
    }

    public function BenchmarkPostImpression1(Request $req)
    {
        $value =$req->dur_min + $req->dur_marg * $req->words;
        return $value;
    }

    public function PostCountScore($total_posts_last_week, $max_amount_post_weekly)
    {

        if($total_posts_last_week == 0)
            $total_posts_last_week = 1;

        return min($max_amount_post_weekly / max($total_posts_last_week,1), 1);

    }

    public function TotalPost() {
        // blm tau dapet dari mana dan proses apa

    }

    public function PostScore($impr, $ws_nonBP,	$ww_nonBP, $ws_D, $ww_D, $ws_updown, $ww_updown) {
        $p_pref = 1;

        if($impr < 5) {
            return $p_pref;
        } elseif ($impr < 50) {
            return $p_pref * ( $ws_nonBP**$ww_nonBP ) * ( $ws_D**$ww_D );
        } else {
            return $p_pref * ( $ws_nonBP**$ww_nonBP ) * ( $ws_D**$ww_D ) * ($ws_updown**$ww_updown);
        }
    }

    public function WeightPostLongComments($LongC, $impr, $w_longC)
    {
        // weight rewarding if a post has long comments (>80char)
        return  (1+($LongC / $impr))**$w_longC;
    }

    public function PostPerformanceScore($p_pref, $p_longC)
    {
        return $p_pref * $p_longC;
    }

    public function UserScoreWithoutFollower($f,$w_f, $b,$w_b, $r, $w_r, $q, $w_q, $a, $w_a)
    {
        return ($f**$w_f) * ($b**$w_b) * ($r**$w_r) * ($q**$w_q) * ($a**$w_a);
    }

    public function UserScore($u1, $y, $w_y)
    {
        return $u1 * $y**$w_y;
    }

    public function BlockpointsPerImpression($total_blocks, $impr, $bpImpr_global){

        if ($impr == 0){
            return 0;
        } else {
            return ($total_blocks / $impr) / $bpImpr_global;
        }
    }

    public function BlockedPerPostImpression($BlockpointsPerImpression)
    {
        return 2 / (1 + 200**($BlockpointsPerImpression**0.4-1));
    }

    public function UpDownScore($impr, $upvote, $downvote, $w_down, $w_n)
    {
        return  ((-$impr * $w_down) + $upvote + ($downvote*$w_down) +
                $w_n * ($impr - $upvote - $downvote)) / ($impr * (1-$w_down));
    }

    public function UpDownScoreWilsonScore($impr, $s_updown, $z_updown, $ev_updown)
    {
        $ev_updown_percentage =  $ev_updown /100;
        $result = number_format((($s_updown+($z_updown**2 / (2*$impr))) / (1+($z_updown**2) / $impr))/$ev_updown_percentage,8, '.', '');
       
        return $result;
    }

    public function PostCharacteristicsScore(){

    }

    public function NonBPScoreWilsonScore($impr, $bp, $z_nonBP,	$EV_nonBP)
    {
        return (((1-($bp/$impr)) + ($z_nonBP**2/(2*$impr))) / (1+($z_nonBP**2)/$impr)) /  $EV_nonBP;
    }

    public function DurationScoreWilsonScore($impr, $duration, $z_value_duration_dist, $duration_distribution_percentage)
    {
        $duration_distribution = $duration_distribution_percentage / 100;
        return (((($duration/$impr) + ($z_value_duration_dist**2/(2*$impr)))/(1+($z_value_duration_dist**2)/$impr))/$duration_distribution);
    }

    public function AveragePostScore($postPerformanceScore, $count_posts)
    {
        //TODO gimana IFErRor nya
        return ( $postPerformanceScore + (10 - min(10,$count_posts)) ) / 10;
    }

    public function MultiplicationFromQualityCriteriaScore($w_edu,$edu_email,$w_email,$w_twitter, $follower_twitter,$email,$w_useratt)
    {
        if($edu_email){
            $verified_edu = $w_edu**1;
        }
        else{
            $verified_edu = $w_edu**0;
        }
        $veridied_email = $w_email**(min(3,$email)**0.25);
        if($follower_twitter > 200){
            $twitter = $w_twitter**1;
        }
        else{
            $twitter = $w_twitter**0;
        }

        $result = $verified_edu *$veridied_email * $twitter *$w_useratt;
        return $result;
    }

    public function FollowersQuality($user_score_without_followers_score, $followers_count)
    {
        //TODO pastikan input nya
        return $user_score_without_followers_score / $followers_count;
    }

    public function DomainScore()
    {
        return 1;
    }

    public function FollowerScore($followers_count)
    {
        return ($followers_count / 150)**(0.05);
    }

    public function FinalScorePost($user_score, $weight_user_score, $p1, $weight_p1, $p2, $weight_p2, $p3, $weight_p3, $prev, $weight_prev)
    {   
        $result = number_format($user_score**$weight_user_score  *  $p1**$weight_p1  * $p2**$weight_p2  * $p3**$weight_p3  *  $prev**$weight_prev, 8, '.', '');
        return  $result;
    }

    public function PreviousInteractionScore($prev_interact, $prev_d, $prev_uc, $prev_pre){
        //p_prev

        if($prev_interact == 'seen'){
            return $prev_pre;
        } elseif ($prev_interact == 'downvote'){
            return $prev_d;
        } elseif ($prev_interact == 'upvote' || $prev_interact == 'comment') {
            return $prev_uc;
        } else
            return 1;   //none interaction

    }
    public function ApplyMultipliesToTotalScore($w_topic,$topic_followed,$w_follow,$w_2degree,$w_link_domain,$user_follow_author,$follow_author_followers,$link_post){
        $constant = 0.5;
        $followed_topic = $w_topic**($topic_followed**$constant);
        if($user_follow_author){
           $calculate =  $followed_topic * $w_follow;
        }
        else if($follow_author_followers == 1){
           $calculate =   $followed_topic * $w_2degree;
        }
        else{
            $calculate =   $followed_topic * 1;
        }
        $result =  $calculate * $w_link_domain**$link_post;
        return number_format($result, 8, '.', '');
    }


    public function RecencyScore($age_of_post, $expiration_setting){

        if($expiration_setting == 1)
            return 1 - 0.007 * $age_of_post;

        elseif($expiration_setting == 7)
            return 1.3 - 0.4 * $age_of_post**0.15;

        elseif($expiration_setting == 30)
            return 0.95 - 0.225 * $age_of_post**0.215;

        elseif($expiration_setting == 'forever')
            return  max(0.02, 0.95 - 0.225 * $age_of_post**0.215);

    }

    public function AgeOfPost(){



    }










}



