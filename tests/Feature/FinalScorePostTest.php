<?php

namespace Tests\Feature;

use App\Http\Controllers\FormulaController;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class FinalScorePostTest extends TestCase
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
        $user_score_u = 10;
        $weight_user_score = config('constants.weight_user_score_u');
        $p1 = 12;
        $weight_p1 = config('constants.weight_postscore1');
        $p2 = 3.477930767;
        $weight_p2 = config('constants.weight_postscore2');
        $p3 = 3;
        $weight_p3 = config('constants.weight_postscore3');
        $prev = 0.5;
        $weight_prev = config('constants.weight_previous_interaction');
        $final_score_post = $formula->FinalScorePost($user_score_u,$weight_user_score,$p1,$weight_p1,
        $p2,$weight_p2,$p3,$weight_p3,$prev, $weight_prev);
        $this->assertEquals(626.027538050851, $final_score_post);
    }

    public function test_2()
    {
        $formula = new FormulaController();
        $user_score_u = 2;
        $weight_user_score = config('constants.weight_user_score_u');
        $p1 = 83.22970108;
        $weight_p1 = config('constants.weight_postscore1');
        $p2 = 1;
        $weight_p2 = config('constants.weight_postscore2');
        $p3 = 2.5;
        $weight_p3 = config('constants.weight_postscore3');
        $prev = 0.8;
        $weight_prev = config('constants.weight_previous_interaction');
        $final_score_post = $formula->FinalScorePost($user_score_u,$weight_user_score,$p1,$weight_p1,
        $p2,$weight_p2,$p3,$weight_p3,$prev, $weight_prev);
        $this->assertEquals(332.91880432, $final_score_post);
    }

    public function test_3()
    {
        $formula = new FormulaController();
        $user_score_u = 3;
        $weight_user_score = config('constants.weight_user_score_u');
        $p1 = 82.7674847697271;
        $weight_p1 = config('constants.weight_postscore1');
        $p2 = 4.449143614;
        $weight_p2 = config('constants.weight_postscore2');
        $p3 = 5.204818078;
        $weight_p3 = config('constants.weight_postscore3');
        $prev = 0.5;
        $weight_prev = config('constants.weight_previous_interaction');
        $final_score_post = $formula->FinalScorePost($user_score_u,$weight_user_score,$p1,$weight_p1,
        $p2,$weight_p2,$p3,$weight_p3,$prev, $weight_prev);
        $this->assertEquals(2874.96787067, $final_score_post);
    }

    public function test_4()
    {
        $formula = new FormulaController();
        $user_score_u = 4;
        $weight_user_score = config('constants.weight_user_score_u');
        $p1 = 16;
        $weight_p1 = config('constants.weight_postscore1');
        $p2 = 3.559314891;
        $weight_p2 = config('constants.weight_postscore2');
        $p3 = 3.471735;
        $weight_p3 = config('constants.weight_postscore3');
        $prev = 1;
        $weight_prev = config('constants.weight_previous_interaction');
        $final_score_post = $formula->FinalScorePost($user_score_u,$weight_user_score,$p1,$weight_p1,
        $p2,$weight_p2,$p3,$weight_p3,$prev, $weight_prev);
        $this->assertEquals(790.84787738, $final_score_post);
    }

    public function test_5()
    {
        $formula = new FormulaController();
        $user_score_u = 5;
        $weight_user_score = config('constants.weight_user_score_u');
        $p1 = 33.2918804324306;
        $weight_p1 = config('constants.weight_postscore1');
        $p2 = 0.001242118131;
        $weight_p2 = config('constants.weight_postscore2');
        $p3 = 1.3408;
        $weight_p3 = config('constants.weight_postscore3');
        $prev = 0.05;
        $weight_prev = config('constants.weight_previous_interaction');
        $final_score_post = $formula->FinalScorePost($user_score_u,$weight_user_score,$p1,$weight_p1,
        $p2,$weight_p2,$p3,$weight_p3,$prev, $weight_prev);
        $this->assertEquals(0.01386134, $final_score_post);
    }

    public function test_6()
    {
        $formula = new FormulaController();
        $user_score_u = 6;
        $weight_user_score = config('constants.weight_user_score_u');
        $p1 = 53.2724497598701;
        $weight_p1 = config('constants.weight_postscore1');
        $p2 = 24;
        $weight_p2 = config('constants.weight_postscore2');
        $p3 = 1.346120285;
        $weight_p3 = config('constants.weight_postscore3');
        $prev = 0.5;
        $weight_prev = config('constants.weight_previous_interaction');
        $final_score_post = $formula->FinalScorePost($user_score_u,$weight_user_score,$p1,$weight_p1,
        $p2,$weight_p2,$p3,$weight_p3,$prev, $weight_prev);
        $this->assertEquals(5163.20101878, $final_score_post);
    }

    public function test_7()
    {
        $formula = new FormulaController();
        $user_score_u = 90;
        $weight_user_score = config('constants.weight_user_score_u');
        $p1 = 480;
        $weight_p1 = config('constants.weight_postscore1');
        $p2 = 6.210590655;
        $weight_p2 = config('constants.weight_postscore2');
        $p3 = 1.642177777;
        $weight_p3 = config('constants.weight_postscore3');
        $prev = 0.05;
        $weight_prev = config('constants.weight_previous_interaction');
        $final_score_post = $formula->FinalScorePost($user_score_u,$weight_user_score,$p1,$weight_p1,
        $p2,$weight_p2,$p3,$weight_p3,$prev, $weight_prev);
        $this->assertEquals(22029.61095165, $final_score_post);
    }

    public function test_8()
    {
        $formula = new FormulaController();
        $user_score_u = 0;
        $weight_user_score = config('constants.weight_user_score_u');
        $p1 = 89.50782993;
        $weight_p1 = config('constants.weight_postscore1');
        $p2 = 3.477930767;
        $weight_p2 = config('constants.weight_postscore2');
        $p3 = 0;
        $weight_p3 = config('constants.weight_postscore3');
        $prev = 0.8;
        $weight_prev = config('constants.weight_previous_interaction');
        $final_score_post = $formula->FinalScorePost($user_score_u,$weight_user_score,$p1,$weight_p1,
        $p2,$weight_p2,$p3,$weight_p3,$prev, $weight_prev);
        $this->assertEquals(0.00000000, $final_score_post);
    }

    public function test_9()
    {
        $formula = new FormulaController();
        $user_score_u = 199;
        $weight_user_score = config('constants.weight_user_score_u');
        $p1 = 3932160;
        $weight_p1 = config('constants.weight_postscore1');
        $p2 = 2.8;
        $weight_p2 = config('constants.weight_postscore2');
        $p3 = 4.81278;
        $weight_p3 = config('constants.weight_postscore3');
        $prev = 1;
        $weight_prev = config('constants.weight_previous_interaction');
        $final_score_post = $formula->FinalScorePost($user_score_u,$weight_user_score,$p1,$weight_p1,
        $p2,$weight_p2,$p3,$weight_p3,$prev, $weight_prev);
        $this->assertEquals(10544798823.87460000, $final_score_post);
    }

    public function test_10()
    {
        $formula = new FormulaController();
        $user_score_u = 102;
        $weight_user_score = config('constants.weight_user_score_u');
        $p1 = 913.3942047;
        $weight_p1 = config('constants.weight_postscore1');
        $p2 = 24;
        $weight_p2 = config('constants.weight_postscore2');
        $p3 = 1.217658;
        $weight_p3 = config('constants.weight_postscore3');
        $prev = 0.8;
        $weight_prev = config('constants.weight_previous_interaction');
        $final_score_post = $formula->FinalScorePost($user_score_u,$weight_user_score,$p1,$weight_p1,
        $p2,$weight_p2,$p3,$weight_p3,$prev, $weight_prev);
        $this->assertEquals(2178135.92773064, $final_score_post);
    }


}
