<?php

namespace Tests\Feature;

use App\Http\Controllers\FormulaController;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class UserScoreWithoutFollowerTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */

    /** @test **/
    public function test_1()
    {
        $formula = new FormulaController();
        $w_f = config('constants.weight_follower');
        $w_b = config('constants.weight_blocked_p_impression');
        $w_r = config('constants.weight_average_post_score');
        $w_q = config('constants.weight_qualitative_criteria');
        $w_a = config('constants.weight_account_age');
        $u1 = $formula->UserScoreWithoutFollower(0,$w_f,0,$w_b, 0, $w_r, 0,$w_q,0,$w_a);

        $this->assertEquals(0, $u1);
    }

    public function test_3()
    {
        $formula = new FormulaController();
        $w_f = config('constants.weight_follower');
        $w_b = config('constants.weight_blocked_p_impression');
        $w_r = config('constants.weight_average_post_score');
        $w_q = config('constants.weight_qualitative_criteria');
        $w_a = config('constants.weight_account_age');
        $u1 = $formula->UserScoreWithoutFollower(20,$w_f,5,$w_b, 0, $w_r,20,$w_q,0.64,$w_a);

        $this->assertEquals(0, $u1);
    }

    public function test_10()
    {
        $formula = new FormulaController();
        $w_f = config('constants.weight_follower');
        $w_b = config('constants.weight_blocked_p_impression');
        $w_r = config('constants.weight_average_post_score');
        $w_q = config('constants.weight_qualitative_criteria');
        $w_a = config('constants.weight_account_age');
        $u1 = $formula->UserScoreWithoutFollower(0.878,$w_f,1.9900498,$w_b,1,$w_r,1.2,$w_q,0.63,$w_a);

        $this->assertEquals(1.3209313756464, $u1);
    }

    public function test_12()
    {
        $formula = new FormulaController();
        $w_f = config('constants.weight_follower');
        $w_b = config('constants.weight_blocked_p_impression');
        $w_r = config('constants.weight_average_post_score');
        $w_q = config('constants.weight_qualitative_criteria');
        $w_a = config('constants.weight_account_age');
        $u1 = $formula->UserScoreWithoutFollower(0.869,$w_f,1.9900498,$w_b,1,$w_r,1,$w_q,0.64,$w_a);

        $this->assertEquals(1.1067860967679999, $u1);
    }


}
