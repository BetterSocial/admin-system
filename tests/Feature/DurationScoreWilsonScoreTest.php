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
        $impr = 20;
        $duration = 11;
        $formula = new FormulaController();
        $ws_d = $formula->DurationScoreWilsonScore($impr, $duration ,$z_value_d,$expected_value_d);

        $this->assertEquals(1.82684606759571, $ws_d);
    }

    public function test_4(){
        $z_value_d = config('constants.z_value_d');
        $expected_value_d = config('constants.expected_value_d');
        $formula = new FormulaController();
        $impr = 110;
        $duration = 11;
        $formula = new FormulaController();
        $ws_d = $formula->DurationScoreWilsonScore($impr, $duration ,$z_value_d,$expected_value_d);

        $this->assertEquals(0.34307974611196, $ws_d);
    }

    public function test_5(){
        $z_value_d = config('constants.z_value_d');
        $expected_value_d = config('constants.expected_value_d');
        $impr = 200;
        $duration = 16;
        $formula = new FormulaController();
        $ws_d = $formula->DurationScoreWilsonScore($impr, $duration ,$z_value_d,$expected_value_d);
        $this->assertEquals(0.272313795793702, $ws_d);
    }

    public function test_6(){
        $z_value_d = config('constants.z_value_d');
        $expected_value_d = config('constants.expected_value_d');
        $impr = 576;
        $duration = 24;
        $formula = new FormulaController();
        $ws_d = $formula->DurationScoreWilsonScore($impr, $duration ,$z_value_d,$expected_value_d);

        $this->assertEquals(0.14103430939131, $ws_d);
    }

    public function test_7(){
        $z_value_d = config('constants.z_value_d');
        $expected_value_d = config('constants.expected_value_d');
        $impr = 75;
        $duration = 25;
        $formula = new FormulaController();
        $ws_d = $formula->DurationScoreWilsonScore($impr, $duration ,$z_value_d,$expected_value_d);

        $this->assertEquals(1.11704700347360, $ws_d);
    }

    public function test_8(){
        $z_value_d = config('constants.z_value_d');
        $expected_value_d = config('constants.expected_value_d');
        $impr = 200;
        $duration = 71;
        $formula = new FormulaController();
        $ws_d = $formula->DurationScoreWilsonScore($impr, $duration ,$z_value_d,$expected_value_d);
        $this->assertEquals(1.18528293743671, $ws_d);
    }

    public function test_9(){
        $z_value_d = config('constants.z_value_d');
        $expected_value_d = config('constants.expected_value_d');
        $impr = 300;
        $duration = 158;
        $formula = new FormulaController();
        $ws_d = $formula->DurationScoreWilsonScore($impr, $duration ,$z_value_d,$expected_value_d);

        $this->assertEquals(1.75531620181067, $ws_d);
    }

    public function test_10(){
        $z_value_d = config('constants.z_value_d');
        $expected_value_d = config('constants.expected_value_d');
        $impr = 400;
        $duration = 212;
        $formula = new FormulaController();
        $ws_d = $formula->DurationScoreWilsonScore($impr, $duration ,$z_value_d,$expected_value_d);

        $this->assertEquals(1.76646457590047, $ws_d);
    }

}
