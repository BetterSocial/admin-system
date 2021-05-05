<?php

namespace Tests\Feature;

use App\Http\Controllers\FormulaController;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class WeightPostLongCommentTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_1()
    {
        
        $formula = new FormulaController();
        $w_longC = config('constants.weight_long_comments');
        $longC = 2;
        $impr = 1;
        $p_longC = $formula->WeightPostLongComments($longC, $impr, $w_longC);
        $this->assertEquals(3, $p_longC);
    }

    public function test_2()
    {
        $w_longC = config('constants.weight_long_comments');
        $formula = new FormulaController();
        $longC = 3;
        $impr = 2;
        $p_longC = $formula->WeightPostLongComments($longC, $impr, $w_longC);
        $this->assertEquals(2.5, $p_longC);
    }

    public function test_3()
    {
        $w_longC = config('constants.weight_long_comments');
        $formula = new FormulaController();
        $longC = 4;
        $impr = 5;
        $p_longC = $formula->WeightPostLongComments($longC, $impr, $w_longC);
        $this->assertEquals(1.8, $p_longC);
    }

    public function test_4()
    {
        $w_longC = config('constants.weight_long_comments');
        $formula = new FormulaController();
        $longC = 6;
        $impr = 10;
        $p_longC = $formula->WeightPostLongComments($longC, $impr, $w_longC);
        $this->assertEquals(1.6, $p_longC);
    }

    public function test_5()
    {
        $w_longC = config('constants.weight_long_comments');
        $formula = new FormulaController();
        $longC = 1;
        $impr = 20;
        $p_longC = $formula->WeightPostLongComments($longC, $impr, $w_longC);
        $this->assertEquals(1.05, $p_longC);
    }

    public function test_6()
    {
        $w_longC = config('constants.weight_long_comments');
        $formula = new FormulaController();
        $longC = 0;
        $impr = 90;
        $p_longC = $formula->WeightPostLongComments($longC, $impr, $w_longC);
        $this->assertEquals(1, $p_longC);
    }

    public function test_7()
    {
        $w_longC = config('constants.weight_long_comments');
        $formula = new FormulaController();
        $longC = 3;
        $impr = 100;
        $p_longC = $formula->WeightPostLongComments($longC, $impr, $w_longC);
        $this->assertEquals(1.03, $p_longC);
    }

    public function test_8()
    {
        $w_longC = config('constants.weight_long_comments');
        $formula = new FormulaController();
        $longC = 2;
        $impr = 250;
        $p_longC = $formula->WeightPostLongComments($longC, $impr, $w_longC);
        $this->assertEquals(1.008, $p_longC);
    }

    public function test_9()
    {
        $w_longC = config('constants.weight_long_comments');
        $formula = new FormulaController();
        $longC = 7;
        $impr = 700;
        $p_longC = $formula->WeightPostLongComments($longC, $impr, $w_longC);
        $this->assertEquals(1.01, $p_longC);
    }

    public function test_10()
    {
        $w_longC = config('constants.weight_long_comments');
        $formula = new FormulaController();
        $longC = 5;
        $impr = 1000;
        $p_longC = $formula->WeightPostLongComments($longC, $impr, $w_longC);
        $this->assertEquals(1.005, $p_longC);
    }


}
