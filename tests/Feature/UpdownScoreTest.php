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

    /** @test **/
    public function test_1() {
        $formula = new FormulaController();
        $impr = 1;
        $upvote = 1;
        $downvote = 1;
        $w_down = config('constants.weight_downvote');
        $w_n = config('constants.weight_no_vote');
        $upDownScore = $formula->UpdownScore($impr,$upvote,$downvote,$w_down,$w_n);
        $this->assertEquals(0.4772727273, $upDownScore);
    }

    public function test_2() {
        $formula = new FormulaController();
        $impr = 2;
        $upvote = 2;
        $downvote = 1;
        $w_down = config('constants.weight_downvote');
        $w_n = config('constants.weight_no_vote');
        $upDownScore = $formula->UpdownScore($impr,$upvote,$downvote,$w_down,$w_n);
        $this->assertEquals(0.7386363636, $upDownScore);
    }

    public function test_3() {
        $formula = new FormulaController();
        $impr = 1;
        $upvote = 1;
        $downvote = 0;
        $w_down = config('constants.weight_downvote');
        $w_n = config('constants.weight_no_vote');
        $upDownScore = $formula->UpdownScore($impr,$upvote,$downvote,$w_down,$w_n);
        $this->assertEquals(1, $upDownScore);
    }

    public function test_4() {
        $formula = new FormulaController();
        $impr = 1;
        $upvote = 0;
        $downvote = 1;
        $w_down = config('constants.weight_downvote');
        $w_n = config('constants.weight_no_vote');
        $upDownScore = $formula->UpdownScore($impr,$upvote,$downvote,$w_down,$w_n);
        $this->assertEquals(0, $upDownScore);
    }

    public function test_5() {
        $formula = new FormulaController();
        $impr = 1;
        $upvote = 1;
        $downvote = 0;
        $w_down = config('constants.weight_downvote');
        $w_n = config('constants.weight_no_vote');
        $upDownScore = $formula->UpdownScore($impr,$upvote,$downvote,$w_down,$w_n);
        $this->assertEquals(1, $upDownScore);
    }

    public function test_6() {
        $formula = new FormulaController();
        $impr = 1;
        $upvote = 1;
        $downvote = 1;
        $w_down = config('constants.weight_downvote');
        $w_n = config('constants.weight_no_vote');
        $upDownScore = $formula->UpdownScore($impr,$upvote,$downvote,$w_down,$w_n);
        $this->assertEquals(0.4772727273, $upDownScore);
    }

    public function test_7() {
        $formula = new FormulaController();
        $impr = 10;
        $upvote = 2;
        $downvote = 5;
        $w_down = config('constants.weight_downvote');
        $w_n = config('constants.weight_no_vote');
        $upDownScore = $formula->UpdownScore($impr,$upvote,$downvote,$w_down,$w_n);
        $this->assertEquals(0.3568181818, $upDownScore);
    }

    public function test_8() {
        $formula = new FormulaController();
        $impr = 50;
        $upvote = 10;
        $downvote = 20;
        $w_down = config('constants.weight_downvote');
        $w_n = config('constants.weight_no_vote');
        $upDownScore = $formula->UpdownScore($impr,$upvote,$downvote,$w_down,$w_n);
        $this->assertEquals(0.4090909091, $upDownScore);
    }

    public function test_9() {
        $formula = new FormulaController();
        $impr = 750;
        $upvote = 500;
        $downvote = 10;
        $w_down = config('constants.weight_downvote');
        $w_n = config('constants.weight_no_vote');
        $upDownScore = $formula->UpdownScore($impr,$upvote,$downvote,$w_down,$w_n);
        $this->assertEquals(0.8339393939, $upDownScore);
    }

    public function test_10() {
        $formula = new FormulaController();
        $impr = 3000;
        $upvote = 25;
        $downvote = 2000;
        $w_down = config('constants.weight_downvote');
        $w_n = config('constants.weight_no_vote');
        $upDownScore = $formula->UpdownScore($impr,$upvote,$downvote,$w_down,$w_n);
        $this->assertEquals(0.178219697, $upDownScore);
    }

    public function test_11() {
        $formula = new FormulaController();
        $impr = 2;
        $upvote = 1;
        $downvote = 1;
        $w_down = config('constants.weight_downvote');
        $w_n = config('constants.weight_no_vote');
        $upDownScore = $formula->UpdownScore($impr,$upvote,$downvote,$w_down,$w_n);
        $this->assertEquals(0.5, $upDownScore);
    }


    public function test_12() {
        $formula = new FormulaController();
        $impr = 50;
        $upvote = 50;
        $downvote = 0;
        $w_down = config('constants.weight_downvote');
        $w_n = config('constants.weight_no_vote');
        $upDownScore = $formula->UpdownScore($impr,$upvote,$downvote,$w_down,$w_n);
        $this->assertEquals(1, $upDownScore);
    }

    public function test_13() {
        $formula = new FormulaController();
        $impr = 1;
        $upvote = 0;
        $downvote = 0;
        $w_down = config('constants.weight_downvote');
        $w_n = config('constants.weight_no_vote');
        $upDownScore = $formula->UpdownScore($impr,$upvote,$downvote,$w_down,$w_n);
        $this->assertEquals(0.5227272727, $upDownScore);
    }

    public function test_14() {
        $formula = new FormulaController();
        $impr = 10;
        $upvote = 0;
        $downvote = 0;
        $w_down = config('constants.weight_downvote');
        $w_n = config('constants.weight_no_vote');
        $upDownScore = $formula->UpdownScore($impr,$upvote,$downvote,$w_down,$w_n);
        $this->assertEquals(0.5227272727, $upDownScore);
    }

    public function test_15() {
        $formula = new FormulaController();
        $impr = 100;
        $upvote = 0;
        $downvote = 0;
        $w_down = config('constants.weight_downvote');
        $w_n = config('constants.weight_no_vote');
        $upDownScore = $formula->UpdownScore($impr,$upvote,$downvote,$w_down,$w_n);
        $this->assertEquals(0.5227272727, $upDownScore);
    }

    public function test_16() {
        $formula = new FormulaController();
        $impr = 100;
        $upvote = 50;
        $downvote = 50;
        $w_down = config('constants.weight_downvote');
        $w_n = config('constants.weight_no_vote');
        $upDownScore = $formula->UpdownScore($impr,$upvote,$downvote,$w_down,$w_n);
        $this->assertEquals(0.5, $upDownScore);
    }


}
