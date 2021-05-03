<?php

namespace Tests\Feature;

use App\Http\Controllers\FormulaController;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class UserScoreTest extends TestCase
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
        $w_y = config('constants.weight_follower_quality');
        $u = $formula->UserScore(0, 1.85, $w_y);

        $this->assertEquals(0, $u);
    }

    public function test_2() {
        $formula = new FormulaController();
        $w_y = config('constants.weight_follower_quality');
        $u = $formula->UserScore(0.727, 1.98, $w_y);

        $this->assertEquals(1.43946, $u);
    }

    public function test_3() {
        $formula = new FormulaController();
        $w_y = config('constants.weight_follower_quality');
        $u = $formula->UserScore(1.1, 1.73, $w_y);

        $this->assertEquals(1.903, $u);
    }

    public function test_4() {
        $formula = new FormulaController();
        $w_y = config('constants.weight_follower_quality');
        $u = $formula->UserScore(2.5, 1.85, $w_y);

        $this->assertEquals(4.625, $u);
    }

    public function test_5() {
        $formula = new FormulaController();
        $w_y = config('constants.weight_follower_quality');
        $u = $formula->UserScore(100, 1.69, $w_y);

        $this->assertEquals(169, $u);
    }

}
