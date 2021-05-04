<?php

namespace Tests\Feature;

use App\Http\Controllers\FormulaController;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class DurationScoreWilsonScoreTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */

    /** @test **/
    public function test_1()
    {
        $z_value_d = config('constants.z_value_d');
        $expected_value_d = config('constants.expected_value_d');
        $formula = new FormulaController();
        $ws_d = $formula->DurationScoreWilsonScore(30,3,$z_value_d,$expected_value_d);

        $this->assertEquals(0.36838688737423, $ws_d);
    }

    public function test_2(){
        $z_value_d = config('constants.z_value_d');
        $expected_value_d = config('constants.expected_value_d');
        $formula = new FormulaController();

        $ws_d = $formula->DurationScoreWilsonScore(20,9,$z_value_d,$expected_value_d);

        $this->assertEquals(1.50648726573763, $ws_d);
    }

    public function test_3(){
        $z_value_d = config('constants.z_value_d');
        $expected_value_d = config('constants.expected_value_d');
        $formula = new FormulaController();

        $ws_d = $formula->DurationScoreWilsonScore(20,11,$z_value_d,$expected_value_d);

        $this->assertEquals(1.82684606759571, $ws_d);
    }

    public function test_4(){
        $z_value_d = config('constants.z_value_d');
        $expected_value_d = config('constants.expected_value_d');
        $formula = new FormulaController();

        $ws_d = $formula->DurationScoreWilsonScore(110,11,$z_value_d,$expected_value_d);

        $this->assertEquals(0.34307974611196, $ws_d);
    }

    public function test_5(){
        $z_value_d = config('constants.z_value_d');
        $expected_value_d = config('constants.expected_value_d');
        $formula = new FormulaController();

        $ws_d = $formula->DurationScoreWilsonScore(200,16,$z_value_d,$expected_value_d);

        $this->assertEquals(0.272313795793702, $ws_d);
    }

    public function test_6(){
        $z_value_d = config('constants.z_value_d');
        $expected_value_d = config('constants.expected_value_d');
        $formula = new FormulaController();

        $ws_d = $formula->DurationScoreWilsonScore(576,24,$z_value_d,$expected_value_d);

        $this->assertEquals(0.14103430939131, $ws_d);
    }

    public function test_7(){
        $z_value_d = config('constants.z_value_d');
        $expected_value_d = config('constants.expected_value_d');
        $formula = new FormulaController();

        $ws_d = $formula->DurationScoreWilsonScore(75, 25,$z_value_d,$expected_value_d);

        $this->assertEquals(1.11704700347360, $ws_d);
    }

    public function test_8(){
        $z_value_d = config('constants.z_value_d');
        $expected_value_d = config('constants.expected_value_d');
        $formula = new FormulaController();

        $ws_d = $formula->DurationScoreWilsonScore(200,71,$z_value_d,$expected_value_d);

        $this->assertEquals(1.18528293743671, $ws_d);
    }

    public function test_9(){
        $z_value_d = config('constants.z_value_d');
        $expected_value_d = config('constants.expected_value_d');
        $formula = new FormulaController();

        $ws_d = $formula->DurationScoreWilsonScore(300,158,$z_value_d,$expected_value_d);

        $this->assertEquals(1.75531620181067, $ws_d);
    }

    public function test_10(){
        $z_value_d = config('constants.z_value_d');
        $expected_value_d = config('constants.expected_value_d');
        $formula = new FormulaController();

        $ws_d = $formula->DurationScoreWilsonScore(400,212,$z_value_d,$expected_value_d);

        $this->assertEquals(1.76646457590047, $ws_d);
    }

}
