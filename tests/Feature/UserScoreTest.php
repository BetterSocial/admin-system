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
        $u1 = 0;
        $y = 1.85;
        $u = $formula->UserScore($u1, $y, $w_y);

        $this->assertEquals(0, $u);
    }

    public function test_2() {
        $formula = new FormulaController();
        $w_y = config('constants.weight_follower_quality');
        $u1 = 0.727;
        $y = 1.98;
        $u = $formula->UserScore($u1, $y, $w_y);

        $this->assertEquals(1.43946, $u);
    }

    public function test_3() {
        $formula = new FormulaController();
        $w_y = config('constants.weight_follower_quality');
        $u1 = 1.1;
        $y = 1.73;
        $u = $formula->UserScore($u1, $y, $w_y);

        $this->assertEquals(1.903, $u);
    }

    public function test_4() {
        $formula = new FormulaController();
        $w_y = config('constants.weight_follower_quality');
        $u1 = 2.5;
        $y = 1.85;
        $u = $formula->UserScore($u1, $y, $w_y);

        $this->assertEquals(4.625, $u);
    }

    public function test_5() {
        $formula = new FormulaController();
        $w_y = config('constants.weight_follower_quality');
        $u1 = 100;
        $y = 1.69;
        $u = $formula->UserScore($u1, $y, $w_y);

        $this->assertEquals(169, $u);
    }
    public function test_6() {
        $formula = new FormulaController();
        $w_y = config('constants.weight_follower_quality');
        $u1 = 1225;
        $y = 1.51;
        $u = $formula->UserScore($u1, $y, $w_y);

        $this->assertEquals(1849.75, $u);
    }
    public function test_7() {
        $formula = new FormulaController();
        $w_y = config('constants.weight_follower_quality');
        $u1 = 2500;
        $y = 1.73;
        $u = $formula->UserScore($u1, $y, $w_y);

        $this->assertEquals(4325, $u);
    }
    public function test_8() {
        $formula = new FormulaController();
        $w_y = config('constants.weight_follower_quality');
        $u1 = 3249;
        $y = 1.68;
        $u = $formula->UserScore($u1, $y, $w_y);

        $this->assertEquals(5458.32, $u);
    }
    public function test_9() {
        $formula = new FormulaController();
        $w_y = config('constants.weight_follower_quality');
        $u1 = 3636;
        $y = 1.86;
        $u = $formula->UserScore($u1, $y, $w_y);

        $this->assertEquals(6762.96, $u);
    }
    public function test_10() {
        $formula = new FormulaController();
        $w_y = config('constants.weight_follower_quality');
        $u1 = 5105;
        $y = 1.98;
        $u = $formula->UserScore($u1, $y, $w_y);

        $this->assertEquals(10107.9, $u);
    }
    public function test_11() {
        $formula = new FormulaController();
        $w_y = config('constants.weight_follower_quality');
        $u1 = 8181;
        $y = 1.85;
        $u = $formula->UserScore($u1, $y, $w_y);

        $this->assertEquals(15134.85, $u);
    }
    public function test_12() {
        $formula = new FormulaController();
        $w_y = config('constants.weight_follower_quality');
        $u1 = 10000;
        $y = 1.98;
        $u = $formula->UserScore($u1, $y, $w_y);

        $this->assertEquals(19800, $u);
    }

}
