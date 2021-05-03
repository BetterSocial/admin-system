<?php

namespace Tests\Feature;

use App\Http\Controllers\FormulaController;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class PrevInteractionScoreTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_1()
    {
        $prev_d = config('constants.multiplier_downvoted_previous_post');
        $prev_uc = config('constants.multiplier_upvoted_or_comment_previous_post');
        $prev_pre = config('constants.multiplier_seen_previous_post');
        $formula = new FormulaController();
        $p_prev = $formula->PreviousInteractionScore('seen', $prev_d, $prev_uc, $prev_pre);

        $this->assertEquals(0.5, $p_prev);
    }

    public function test_2(){
        $prev_d = config('constants.multiplier_downvoted_previous_post');
        $prev_uc = config('constants.multiplier_upvoted_or_comment_previous_post');
        $prev_pre = config('constants.multiplier_seen_previous_post');
        $formula = new FormulaController();
        $p_prev = $formula->PreviousInteractionScore('comment', $prev_d, $prev_uc, $prev_pre);

        $this->assertEquals(0.8, $p_prev);
    }

    public function test_3(){
        $prev_d = config('constants.multiplier_downvoted_previous_post');
        $prev_uc = config('constants.multiplier_upvoted_or_comment_previous_post');
        $prev_pre = config('constants.multiplier_seen_previous_post');
        $formula = new FormulaController();
        $p_prev = $formula->PreviousInteractionScore('seen', $prev_d, $prev_uc, $prev_pre);

        $this->assertEquals(0.5, $p_prev);
    }

    public function test_4(){
        $prev_d = config('constants.multiplier_downvoted_previous_post');
        $prev_uc = config('constants.multiplier_upvoted_or_comment_previous_post');
        $prev_pre = config('constants.multiplier_seen_previous_post');
        $formula = new FormulaController();
        $p_prev = $formula->PreviousInteractionScore('none', $prev_d, $prev_uc, $prev_pre);

        $this->assertEquals(1, $p_prev);
    }

    public function test_5(){
        $prev_d = config('constants.multiplier_downvoted_previous_post');
        $prev_uc = config('constants.multiplier_upvoted_or_comment_previous_post');
        $prev_pre = config('constants.multiplier_seen_previous_post');
        $formula = new FormulaController();
        $p_prev = $formula->PreviousInteractionScore('downvote', $prev_d, $prev_uc, $prev_pre);

        $this->assertEquals(0.05, $p_prev);
    }

    public function test_6(){
        $prev_d = config('constants.multiplier_downvoted_previous_post');
        $prev_uc = config('constants.multiplier_upvoted_or_comment_previous_post');
        $prev_pre = config('constants.multiplier_seen_previous_post');
        $formula = new FormulaController();
        $p_prev = $formula->PreviousInteractionScore('seen', $prev_d, $prev_uc, $prev_pre);

        $this->assertEquals(0.5, $p_prev);
    }

    public function test_7(){
        $prev_d = config('constants.multiplier_downvoted_previous_post');
        $prev_uc = config('constants.multiplier_upvoted_or_comment_previous_post');
        $prev_pre = config('constants.multiplier_seen_previous_post');
        $formula = new FormulaController();
        $p_prev = $formula->PreviousInteractionScore('downvote', $prev_d, $prev_uc, $prev_pre);

        $this->assertEquals(0.05, $p_prev);
    }

    public function test_8(){
        $prev_d = config('constants.multiplier_downvoted_previous_post');
        $prev_uc = config('constants.multiplier_upvoted_or_comment_previous_post');
        $prev_pre = config('constants.multiplier_seen_previous_post');
        $formula = new FormulaController();
        $p_prev = $formula->PreviousInteractionScore('upvote', $prev_d, $prev_uc, $prev_pre);

        $this->assertEquals(0.8, $p_prev);
    }

    public function test_9(){
        $prev_d = config('constants.multiplier_downvoted_previous_post');
        $prev_uc = config('constants.multiplier_upvoted_or_comment_previous_post');
        $prev_pre = config('constants.multiplier_seen_previous_post');
        $formula = new FormulaController();
        $p_prev = $formula->PreviousInteractionScore('none', $prev_d, $prev_uc, $prev_pre);

        $this->assertEquals(1, $p_prev);
    }

    public function test_10(){
        $prev_d = config('constants.multiplier_downvoted_previous_post');
        $prev_uc = config('constants.multiplier_upvoted_or_comment_previous_post');
        $prev_pre = config('constants.multiplier_seen_previous_post');
        $formula = new FormulaController();
        $p_prev = $formula->PreviousInteractionScore('upvote', $prev_d, $prev_uc, $prev_pre);

        $this->assertEquals(0.8, $p_prev);
    }
}
