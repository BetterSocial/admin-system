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
    public function test_2()
    {
        $formula = new FormulaController();
        $w_f = config('constants.weight_follower');
        $w_b = config('constants.weight_blocked_p_impression');
        $w_r = config('constants.weight_average_post_score');
        $w_q = config('constants.weight_qualitative_criteria');
        $w_a = config('constants.weight_account_age');
        $f = 10;
        $b = 0;
        $r = 10;
        $q = 0;
        $a = 0.63;
        $u1 = $formula->UserScoreWithoutFollower($f,$w_f,$b,$w_b,$r, $w_r, $q,$w_q,$a,$w_a);

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
        $f = 20;
        $b = 5;
        $r = 0;
        $q = 20;
        $a = 0.64;
        $u1 = $formula->UserScoreWithoutFollower($f,$w_f,$b,$w_b,$r, $w_r, $q,$w_q,$a,$w_a);

        $this->assertEquals(0, $u1);
    }
    public function test_4()
    {
        $formula = new FormulaController();
        $w_f = config('constants.weight_follower');
        $w_b = config('constants.weight_blocked_p_impression');
        $w_r = config('constants.weight_average_post_score');
        $w_q = config('constants.weight_qualitative_criteria');
        $w_a = config('constants.weight_account_age');
        $f = 25;
        $b = 10;
        $r = 20;
        $q = 0;
        $a = 0.63;
        $u1 = $formula->UserScoreWithoutFollower($f,$w_f,$b,$w_b,$r, $w_r, $q,$w_q,$a,$w_a);

        $this->assertEquals(0, $u1);
    }
    public function test_5()
    {
        $formula = new FormulaController();
        $w_f = config('constants.weight_follower');
        $w_b = config('constants.weight_blocked_p_impression');
        $w_r = config('constants.weight_average_post_score');
        $w_q = config('constants.weight_qualitative_criteria');
        $w_a = config('constants.weight_account_age');
        $f = 40;
        $b = 15;
        $r = 25;
        $q = 40;
        $a = 0.63;
        $u1 = $formula->UserScoreWithoutFollower($f,$w_f,$b,$w_b,$r, $w_r, $q,$w_q,$a,$w_a);

        $this->assertEquals(378000, $u1);
    }
    public function test_6()
    {
        $formula = new FormulaController();
        $w_f = config('constants.weight_follower');
        $w_b = config('constants.weight_blocked_p_impression');
        $w_r = config('constants.weight_average_post_score');
        $w_q = config('constants.weight_qualitative_criteria');
        $w_a = config('constants.weight_account_age');
        $f = 0.869;
        $b = 0.0001194;
        $r = 1.001;
        $q = 1.27118;
        $a = 0.64;
        $u1 = $formula->UserScoreWithoutFollower($f,$w_f,$b,$w_b,$r, $w_r, $q,$w_q,$a,$w_a);

        $this->assertEquals(0.0000844977619232947, $u1);
    }
    public function test_7()
    {
        $formula = new FormulaController();
        $w_f = config('constants.weight_follower');
        $w_b = config('constants.weight_blocked_p_impression');
        $w_r = config('constants.weight_average_post_score');
        $w_q = config('constants.weight_qualitative_criteria');
        $w_a = config('constants.weight_account_age');
        $f = 0.891;
        $b = 1.9900498;
        $r = 0.945;
        $q = 1.27118;
        $a = 0.63;
        $u1 = $formula->UserScoreWithoutFollower($f,$w_f,$b,$w_b,$r, $w_r, $q,$w_q,$a,$w_a);

        $this->assertEquals(1.34190279622587, $u1);
    }
    public function test_8()
    {
        $formula = new FormulaController();
        $w_f = config('constants.weight_follower');
        $w_b = config('constants.weight_blocked_p_impression');
        $w_r = config('constants.weight_average_post_score');
        $w_q = config('constants.weight_qualitative_criteria');
        $w_a = config('constants.weight_account_age');
        $f = 0.894;
        $b = 1.9900498;
        $r = 1.026;
        $q = 1.68;
        $a = 0.63;
        $u1 = $formula->UserScoreWithoutFollower($f,$w_f,$b,$w_b,$r, $w_r, $q,$w_q,$a,$w_a);

        $this->assertEquals(1.93196233509427, $u1);
    }
    public function test_9()
    {
        $formula = new FormulaController();
        $w_f = config('constants.weight_follower');
        $w_b = config('constants.weight_blocked_p_impression');
        $w_r = config('constants.weight_average_post_score');
        $w_q = config('constants.weight_qualitative_criteria');
        $w_a = config('constants.weight_account_age');
        $f = 0.888;
        $b = 1.9900498;
        $r = 0.907;
        $q = 1.68;
        $a = 0.64;
        $u1 = $formula->UserScoreWithoutFollower($f,$w_f,$b,$w_b,$r, $w_r, $q,$w_q,$a,$w_a);

        $this->assertEquals(1.72334985953550, $u1);
    }

    public function test_10()
    {
        $formula = new FormulaController();
        $w_f = config('constants.weight_follower');
        $w_b = config('constants.weight_blocked_p_impression');
        $w_r = config('constants.weight_average_post_score');
        $w_q = config('constants.weight_qualitative_criteria');
        $w_a = config('constants.weight_account_age');
        $f = 0.878;
        $b = 1.9900498;
        $r = 1;
        $q = 1.2;
        $a = 0.63;
        $u1 = $formula->UserScoreWithoutFollower($f,$w_f,$b,$w_b,$r, $w_r, $q,$w_q,$a,$w_a);

        $this->assertEquals(1.32093137564640, $u1);
    }
    public function test_11()
    {
        $formula = new FormulaController();
        $w_f = config('constants.weight_follower');
        $w_b = config('constants.weight_blocked_p_impression');
        $w_r = config('constants.weight_average_post_score');
        $w_q = config('constants.weight_qualitative_criteria');
        $w_a = config('constants.weight_account_age');
        $f = 0.894;
        $b = 1.9900498;
        $r = 1;
        $q = 1.27118;
        $a = 0.63;
        $u1 = $formula->UserScoreWithoutFollower($f,$w_f,$b,$w_b,$r, $w_r, $q,$w_q,$a,$w_a);

        $this->assertEquals(1.42478411371318, $u1);
    }


    public function test_12()
    {
        $formula = new FormulaController();
        $w_f = config('constants.weight_follower');
        $w_b = config('constants.weight_blocked_p_impression');
        $w_r = config('constants.weight_average_post_score');
        $w_q = config('constants.weight_qualitative_criteria');
        $w_a = config('constants.weight_account_age');
        $f = 0.869;
        $b = 1.9900498;
        $r = 1;
        $q = 1;
        $a = 0.64;
        $u1 = $formula->UserScoreWithoutFollower($f,$w_f,$b,$w_b,$r, $w_r, $q,$w_q,$a,$w_a);

        $this->assertEquals(1.1067860967680, $u1);
    }


    public function test_13()
    {
        $formula = new FormulaController();
        $w_f = config('constants.weight_follower');
        $w_b = config('constants.weight_blocked_p_impression');
        $w_r = config('constants.weight_average_post_score');
        $w_q = config('constants.weight_qualitative_criteria');
        $w_a = config('constants.weight_account_age');
        $f = 0.894;
        $b = 1.9900498;
        $r = 1;
        $q = 2.54237;
        $a = 0.64;
        $u1 = $formula->UserScoreWithoutFollower($f,$w_f,$b,$w_b,$r, $w_r, $q,$w_q,$a,$w_a);

        $this->assertEquals(2.89481085540048, $u1);
    }


    public function test_14()
    {
        $formula = new FormulaController();
        $w_f = config('constants.weight_follower');
        $w_b = config('constants.weight_blocked_p_impression');
        $w_r = config('constants.weight_average_post_score');
        $w_q = config('constants.weight_qualitative_criteria');
        $w_a = config('constants.weight_account_age');
        $f = 0.894;
        $b = 1.9900498;
        $r = 1;
        $q = 1.77966;
        $a = 0.65;
        $u1 = $formula->UserScoreWithoutFollower($f,$w_f,$b,$w_b,$r, $w_r, $q,$w_q,$a,$w_a);

        $this->assertEquals(2.05803074892922, $u1);
    }


    public function test_15()
    {
        $formula = new FormulaController();
        $w_f = config('constants.weight_follower');
        $w_b = config('constants.weight_blocked_p_impression');
        $w_r = config('constants.weight_average_post_score');
        $w_q = config('constants.weight_qualitative_criteria');
        $w_a = config('constants.weight_account_age');
        $f = 0.878;
        $b = 1.9900498;
        $r = 1;
        $q = 2.54237;
        $a = 0.63;
        $u1 = $formula->UserScoreWithoutFollower($f,$w_f,$b,$w_b,$r, $w_r, $q,$w_q,$a,$w_a);

        $this->assertEquals(2.7985802512517, $u1);
    }


}
