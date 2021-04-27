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

    public function PostCountScore($max_amount_post_weekly, $total_posts_last_week)
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
            return $p_pref * ( $ws_nonBP^$ww_nonBP ) * ( $ws_D^$ww_D );
        } else {
            return $p_pref * ( $ws_nonBP^$ww_nonBP ) * ( $ws_D^$ww_D ) * ($ws_updown^$ww_updown);
        }

    }

    public function WeightPostLongComments($LongC, $impr, $w_longC)
    {
        // weight rewarding if a post has long comments (>80char)
        return  (1+($LongC / $impr))^$w_longC;
    }

    public function PostPerformanceScore($p_pref, $p_longC)
    {
        return $p_pref * $p_longC;
    }

    public function UserScoreWithoutFollower($f,$w_f, $b,$w_b, $q, $w_q, $a, $w_a)
    {
        return ($f^$w_f) * ($b^$w_b) * ($q^$w_q) * ($a^$w_a);
    }

    public function UserScore($u1, $y, $w_y)
    {
        return $u1 * $y^$w_y;
    }

    public function BlockpointsPerImpression($total_blocks, $impr, $bpImpr_global){

        if ($impr == 0){
            return 0;
        } else {
            return ($total_blocks / $impr) / $bpImpr_global;
        }
    }

    public function UpdownScore($impr, $upvote, $downvote, $w_down, $w_n)
    {
        return  ((-$impr * $w_down) + $upvote + ($downvote*$w_down) +
                $w_n * ($impr - $upvote - $downvote)) / ($impr * (1-$w_down));
    }

    public function UpDownScoreWilsonScore($impr, $s_updown, $z_updown, $ev_updown)
    {
        return (($s_updown+($z_updown^2 / (2*$impr))) / (1+($z_updown^2) / $impr))/$ev_updown;
    }

    public function NonBPScoreWilsonScore($impr, $bp, $z_nonBP,	$EV_nonBP)
    {
        return (((1-($bp/$impr)) + ($z_nonBP^2/(2*$impr))) / (1+($z_nonBP^2)/$impr)) /  $EV_nonBP;
    }

    public function DurationScoreWilsonScore($impr, $duration, $z_value_duration_dist, $duration_distribution)
    {
        return (((($duration/$impr) + ($z_value_duration_dist^2/(2*$impr)))/(1+($z_value_duration_dist^2)/$impr))/$duration_distribution);
    }

    public function FinalScorePost()
    {
        //TODO reyvin
        //T_t = u^w_u  *  p1^w_p1  * p2^w_p2  * p3^w_p3  *  prev^w_prev"

    }

    public  function AveragePostScore()
    {
        //TODO reyvin
        //(IFERROR ∑p3 (last 10 posts) + (10-MIN(10,Count(posts so far)) / 10)"
    }

    public function MultiplicationFromQualityCriteriaScore($method, $parameters)
    {
        //TODO reyvin
    }

    public function QualityFollowers()
    {
        //TODO reyvin
    }










}



