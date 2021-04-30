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
        $w_longC = config('constants.weight_long_comments');
        $formula = new FormulaController();
        $p_longC = $formula->WeightPostLongComments(2, 1, $w_longC);
        $this->assertEquals(3, $p_longC);
    }

    public function test_2()
    {
        $w_longC = config('constants.weight_long_comments');
        $formula = new FormulaController();
        $p_longC = $formula->WeightPostLongComments(3, 2, $w_longC);
        $this->assertEquals(2.5, $p_longC);
    }

    public function test_3()
    {
        $w_longC = config('constants.weight_long_comments');
        $formula = new FormulaController();
        $p_longC = $formula->WeightPostLongComments(4, 5, $w_longC);
        $this->assertEquals(1.8, $p_longC);
    }

    public function test_4()
    {
        $w_longC = config('constants.weight_long_comments');
        $formula = new FormulaController();
        $p_longC = $formula->WeightPostLongComments(6, 10, $w_longC);
        $this->assertEquals(1.6, $p_longC);
    }

    public function test_5()
    {
        $w_longC = config('constants.weight_long_comments');
        $formula = new FormulaController();
        $p_longC = $formula->WeightPostLongComments(1, 20, $w_longC);
        $this->assertEquals(1.05, $p_longC);
    }

    public function test_6()
    {
        $w_longC = config('constants.weight_long_comments');
        $formula = new FormulaController();
        $p_longC = $formula->WeightPostLongComments(0, 90, $w_longC);
        $this->assertEquals(1, $p_longC);
    }

    public function test_7()
    {
        $w_longC = config('constants.weight_long_comments');
        $formula = new FormulaController();
        $p_longC = $formula->WeightPostLongComments(3, 100, $w_longC);
        $this->assertEquals(1.03, $p_longC);
    }

    public function test_8()
    {
        $w_longC = config('constants.weight_long_comments');
        $formula = new FormulaController();
        $p_longC = $formula->WeightPostLongComments(2, 250, $w_longC);
        $this->assertEquals(1.008, $p_longC);
    }

    public function test_9()
    {
        $w_longC = config('constants.weight_long_comments');
        $formula = new FormulaController();
        $p_longC = $formula->WeightPostLongComments(7, 700, $w_longC);
        $this->assertEquals(1.01, $p_longC);
    }

    public function test_10()
    {
        $w_longC = config('constants.weight_long_comments');
        $formula = new FormulaController();
        $p_longC = $formula->WeightPostLongComments(5, 1000, $w_longC);
        $this->assertEquals(1.005, $p_longC);
    }


}
