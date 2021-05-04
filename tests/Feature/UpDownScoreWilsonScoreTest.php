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
        $this->assertEquals(0.82387404, $final_score_post);
    }
    public function test_2()
    {
        $formula = new FormulaController();
        $impr = 1;
        $s_updown = 1;
        $z_updown = config('constants.z_value_updown_score');
        $ev_updown = config("constants.expected_value_updown_score");
        $final_score_post = $formula->UpDownScoreWilsonScore($impr,$s_updown,$z_updown, $ev_updown);
        $this->assertEquals(1.00695716, $final_score_post);
    }
    public function test_3()
    {
        $formula = new FormulaController();
        $impr = 1;
        $s_updown = 0;
        $z_updown = config('constants.z_value_updown_score');
        $ev_updown = config("constants.expected_value_updown_score");
        $final_score_post = $formula->UpDownScoreWilsonScore($impr,$s_updown,$z_updown, $ev_updown);
        $this->assertEquals(0.82387404, $final_score_post);
    }
    
    public function test_4()
    {
        $formula = new FormulaController();
        $impr = 1;
        $s_updown = 1;
        $z_updown = config('constants.z_value_updown_score');
        $ev_updown = config("constants.expected_value_updown_score");
        $final_score_post = $formula->UpDownScoreWilsonScore($impr,$s_updown,$z_updown, $ev_updown);
        $this->assertEquals(1.00695716, $final_score_post);
    }
    public function test_5()
    {
        $formula = new FormulaController();
        $impr = 10;
        $s_updown = 5;
        $z_updown = config('constants.z_value_updown_score');
        $ev_updown = config("constants.expected_value_updown_score");
        $final_score_post = $formula->UpDownScoreWilsonScore($impr,$s_updown,$z_updown, $ev_updown);
        $this->assertEquals(5.25159475, $final_score_post);
    }
    public function test_6()
    {
        $formula = new FormulaController();
        $impr = 25;
        $s_updown = 10;
        $z_updown = config('constants.z_value_updown_score');
        $ev_updown = config("constants.expected_value_updown_score");
        $final_score_post = $formula->UpDownScoreWilsonScore($impr,$s_updown,$z_updown, $ev_updown);
        $this->assertEquals(13.70430999, $final_score_post);
    }
    public function test_7()
    {
        $formula = new FormulaController();
        $impr = 100;
        $s_updown = 20;
        $z_updown = config('constants.z_value_updown_score');
        $ev_updown = config("constants.expected_value_updown_score");
        $final_score_post = $formula->UpDownScoreWilsonScore($impr,$s_updown,$z_updown, $ev_updown);
        $this->assertEquals(33.66881775, $final_score_post);
    }
    public function test_8()
    {
        $formula = new FormulaController();
        $impr = 150;
        $s_updown = 25;
        $z_updown = config('constants.z_value_updown_score');
        $ev_updown = config("constants.expected_value_updown_score");
        $final_score_post = $formula->UpDownScoreWilsonScore($impr,$s_updown,$z_updown, $ev_updown);
        $this->assertEquals(43.23179705, $final_score_post);
    }
    public function test_9()
    {
        $formula = new FormulaController();
        $impr = 250;
        $s_updown = 50;
        $z_updown = config('constants.z_value_updown_score');
        $ev_updown = config("constants.expected_value_updown_score");
        $final_score_post = $formula->UpDownScoreWilsonScore($impr,$s_updown,$z_updown, $ev_updown);
        $this->assertEquals(88.39238883, $final_score_post);
    }
    public function test_10()
    {
        $formula = new FormulaController();
        $impr = 500;
        $s_updown = 100;
        $z_updown = config('constants.z_value_updown_score');
        $ev_updown = config("constants.expected_value_updown_score");
        $final_score_post = $formula->UpDownScoreWilsonScore($impr,$s_updown,$z_updown, $ev_updown);
        $this->assertEquals(179.86207978, $final_score_post);
    }
    public function test_11()
    {
        $formula = new FormulaController();
        $impr = 50;
        $s_updown = 1;
        $z_updown = config('constants.z_value_updown_score');
        $ev_updown = config("constants.expected_value_updown_score");
        $final_score_post = $formula->UpDownScoreWilsonScore($impr,$s_updown,$z_updown, $ev_updown);
        $this->assertEquals(1.69119153, $final_score_post);
    }
    public function test_12()
    {
        $formula = new FormulaController();
        $impr = 50;
        $s_updown = 0.4090909091;
        $z_updown = config('constants.z_value_updown_score');
        $ev_updown = config("constants.expected_value_updown_score");
        $final_score_post = $formula->UpDownScoreWilsonScore($impr,$s_updown,$z_updown, $ev_updown);
        $this->assertEquals(0.77436543, $final_score_post);
    }

}