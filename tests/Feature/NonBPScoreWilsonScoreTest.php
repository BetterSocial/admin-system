<?php

namespace Tests\Feature;

use App\Http\Controllers\FormulaController;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class NonBPScoreWilsonScoreTest extends TestCase
{

    private function formula()
    {
        $formula = new FormulaController();
        return $formula;
    }

    private function zValueNonBp()
    {
        return config('constants.z_value_non_bp');
    }

    private function expectedValueNonBP()
    {
        return config('constants.expected_value_non_bp');
    }

    public function test_1()
    {
        $z_nonBP = $this->zValueNonBp();
        $EV_nonBP = $this->expectedValueNonBP();
        $score = $this->formula()->NonBPScoreWilsonScore(5, 5, $z_nonBP, $EV_nonBP);
        $this->assertEquals(0.000999002995, $score);
    }

    public function test_2()
    {
        $z_nonBP = $this->zValueNonBp();
        $EV_nonBP = $this->expectedValueNonBP();
        $score = $this->formula()->NonBPScoreWilsonScore(10, 20, $z_nonBP, $EV_nonBP);
        $this->assertEquals(0.5005005005, $score);
    }

    public function test_3()
    {
        $z_nonBP = $this->zValueNonBp();
        $EV_nonBP = $this->expectedValueNonBP();
        $score = $this->formula()->NonBPScoreWilsonScore(50, 20, $z_nonBP, $EV_nonBP);
        $this->assertEquals(-1.5005010007508757, $score);
    }

    public function test_4()
    {
        $z_nonBP = $this->zValueNonBp();
        $EV_nonBP = $this->expectedValueNonBP();
        $score = $this->formula()->NonBPScoreWilsonScore(50, 100, $z_nonBP, $EV_nonBP);
        $this->assertEquals(0.5005005005, $score);
    }

    public function test_5()
    {
        $z_nonBP = $this->zValueNonBp();
        $EV_nonBP = $this->expectedValueNonBP();
        $score = $this->formula()->NonBPScoreWilsonScore(40, 200, $z_nonBP, $EV_nonBP);
        $this->assertEquals(0.8007857865, $score);
    }

    public function test_6()
    {
        $z_nonBP = $this->zValueNonBp();
        $EV_nonBP = $this->expectedValueNonBP();
        $score = $this->formula()->NonBPScoreWilsonScore(10, 700, $z_nonBP, $EV_nonBP);
        $this->assertEquals(0.9866940411, $score);
    }

    public function test_7()
    {
        $z_nonBP = $this->zValueNonBp();
        $EV_nonBP = $this->expectedValueNonBP();
        $score = $this->formula()->NonBPScoreWilsonScore(0, 90, $z_nonBP, $EV_nonBP);
        $this->assertEquals(1.000945396, $score);
    }

    public function test_8()
    {
        $z_nonBP = $this->zValueNonBp();
        $EV_nonBP = $this->expectedValueNonBP();
        $score = $this->formula()->NonBPScoreWilsonScore(2, 10, $z_nonBP, $EV_nonBP);
        $this->assertEquals(0.8005008005, $score);
    }

    public function test_9()
    {
        $z_nonBP = $this->zValueNonBp();
        $EV_nonBP = $this->expectedValueNonBP();
        $score = $this->formula()->NonBPScoreWilsonScore(10, 10, $z_nonBP, $EV_nonBP);
        $this->assertEquals(0.0005000005, $score);
    }

    public function test_10()
    {
        $z_nonBP = $this->zValueNonBp();
        $EV_nonBP = $this->expectedValueNonBP();
        $score = $this->formula()->NonBPScoreWilsonScore(100, 1000, $z_nonBP, $EV_nonBP);
        $this->assertEquals(0.9008968969, $score);
    }

}
