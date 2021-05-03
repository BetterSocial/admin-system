<?php

namespace Tests\Feature;

use App\Http\Controllers\FormulaController;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class UpDownScoreWilsonScoreTest extends TestCase
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
        $impr = 1;
        $s_updown = 0;
        $z_updown = config('constants.z_value_updown_score');
        $ev_updown = config("constants.expected_value_updown_score");
        $final_score_post = $formula->UpDownScoreWilsonScore($impr,$s_updown,$z_updown, $ev_updown);
        $this->assertEquals(0.8239, $final_score_post);
    }
    public function test_2()
    {
        $formula = new FormulaController();
        $impr = 1;
        $s_updown = 1;
        $z_updown = config('constants.z_value_updown_score');
        $ev_updown = config("constants.expected_value_updown_score");
        $final_score_post = $formula->UpDownScoreWilsonScore($impr,$s_updown,$z_updown, $ev_updown);
        $this->assertEquals(1.0070, $final_score_post);
    }
    public function test_3()
    {
        $formula = new FormulaController();
        $impr = 1;
        $s_updown = 0;
        $z_updown = config('constants.z_value_updown_score');
        $ev_updown = config("constants.expected_value_updown_score");
        $final_score_post = $formula->UpDownScoreWilsonScore($impr,$s_updown,$z_updown, $ev_updown);
        $this->assertEquals(0.8239, $final_score_post);
    }
    
    public function test_4()
    {
        $formula = new FormulaController();
        $impr = 1;
        $s_updown = 1;
        $z_updown = config('constants.z_value_updown_score');
        $ev_updown = config("constants.expected_value_updown_score");
        $final_score_post = $formula->UpDownScoreWilsonScore($impr,$s_updown,$z_updown, $ev_updown);
        $this->assertEquals(1.0070, $final_score_post);
    }
    public function test_5()
    {
        $formula = new FormulaController();
        $impr = 10;
        $s_updown = 5;
        $z_updown = config('constants.z_value_updown_score');
        $ev_updown = config("constants.expected_value_updown_score");
        $final_score_post = $formula->UpDownScoreWilsonScore($impr,$s_updown,$z_updown, $ev_updown);
        $this->assertEquals(5.2516, $final_score_post);
    }
    public function test_6()
    {
        $formula = new FormulaController();
        $impr = 25;
        $s_updown = 10;
        $z_updown = config('constants.z_value_updown_score');
        $ev_updown = config("constants.expected_value_updown_score");
        $final_score_post = $formula->UpDownScoreWilsonScore($impr,$s_updown,$z_updown, $ev_updown);
        $this->assertEquals(13.7043, $final_score_post);
    }
    public function test_7()
    {
        $formula = new FormulaController();
        $impr = 100;
        $s_updown = 20;
        $z_updown = config('constants.z_value_updown_score');
        $ev_updown = config("constants.expected_value_updown_score");
        $final_score_post = $formula->UpDownScoreWilsonScore($impr,$s_updown,$z_updown, $ev_updown);
        $this->assertEquals(33.6688, $final_score_post);
    }
    public function test_8()
    {
        $formula = new FormulaController();
        $impr = 150;
        $s_updown = 25;
        $z_updown = config('constants.z_value_updown_score');
        $ev_updown = config("constants.expected_value_updown_score");
        $final_score_post = $formula->UpDownScoreWilsonScore($impr,$s_updown,$z_updown, $ev_updown);
        $this->assertEquals(43.2318, $final_score_post);
    }
    public function test_9()
    {
        $formula = new FormulaController();
        $impr = 250;
        $s_updown = 50;
        $z_updown = config('constants.z_value_updown_score');
        $ev_updown = config("constants.expected_value_updown_score");
        $final_score_post = $formula->UpDownScoreWilsonScore($impr,$s_updown,$z_updown, $ev_updown);
        $this->assertEquals(88.3924, $final_score_post);
    }
    public function test_10()
    {
        $formula = new FormulaController();
        $impr = 500;
        $s_updown = 100;
        $z_updown = config('constants.z_value_updown_score');
        $ev_updown = config("constants.expected_value_updown_score");
        $final_score_post = $formula->UpDownScoreWilsonScore($impr,$s_updown,$z_updown, $ev_updown);
        $this->assertEquals(179.8621, $final_score_post);
    }
    public function test_11()
    {
        $formula = new FormulaController();
        $impr = 50;
        $s_updown = 1;
        $z_updown = config('constants.z_value_updown_score');
        $ev_updown = config("constants.expected_value_updown_score");
        $final_score_post = $formula->UpDownScoreWilsonScore($impr,$s_updown,$z_updown, $ev_updown);
        $this->assertEquals(1.6912, $final_score_post);
    }
    public function test_12()
    {
        $formula = new FormulaController();
        $impr = 50;
        $s_updown = 0.4090909091;
        $z_updown = config('constants.z_value_updown_score');
        $ev_updown = config("constants.expected_value_updown_score");
        $final_score_post = $formula->UpDownScoreWilsonScore($impr,$s_updown,$z_updown, $ev_updown);
        $this->assertEquals(0.7744, $final_score_post);
    }

}