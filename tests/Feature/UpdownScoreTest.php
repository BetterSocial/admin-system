<?php

namespace Tests\Feature;

use App\Http\Controllers\FormulaController;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class UpdownScoreTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
//    public function test_error()
//    {
//        $formula = new FormulaController();
//        $upDownScore = $formula->UpdownScore(0,0,0,
//            config('constants.weight_downvote'),config('constants.weight_no_vote'));
//        $this->assertEquals(1, $upDownScore);
//    }


    /** @test **/
    public function test_4() {
        $formula = new FormulaController();
        $upDownScore = $formula->UpdownScore(1,0,1,
            config('constants.weight_downvote'),config('constants.weight_no_vote'));
        $this->assertEquals(0, $upDownScore);
    }

    public function test_5() {
        $formula = new FormulaController();
        $upDownScore = $formula->UpdownScore(1,1,0,
            config('constants.weight_downvote'),config('constants.weight_no_vote'));
        $this->assertEquals(1, $upDownScore);
    }

    public function test_9() {
        $formula = new FormulaController();
        $upDownScore = $formula->UpdownScore(750, 500, 10,
            config('constants.weight_downvote'),config('constants.weight_no_vote'));
        $this->assertEquals(0.8339393939, $upDownScore);
    }

    public function test_11() {
        $formula = new FormulaController();
        $upDownScore = $formula->UpdownScore(2, 1, 1,
            config('constants.weight_downvote'),config('constants.weight_no_vote'));
        $this->assertEquals(0.5, $upDownScore);
    }

    public function test_15() {
        $formula = new FormulaController();
        $upDownScore = $formula->UpdownScore(100,0,0,
            config('constants.weight_downvote'),config('constants.weight_no_vote'));
        $this->assertEquals(0.5227272727, $upDownScore);
    }

    public function test_16() {
        $formula = new FormulaController();
        $upDownScore = $formula->UpdownScore(100, 50, 50,
            config('constants.weight_downvote'),config('constants.weight_no_vote'));
        $this->assertEquals(0.5, $upDownScore);
    }


}
