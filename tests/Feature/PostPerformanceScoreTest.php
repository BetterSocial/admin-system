<?php

namespace Tests\Feature;

use App\Http\Controllers\FormulaController;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class PostPerformanceScoreTest extends TestCase
{

    private function formula()
    {
        $formula = new FormulaController();
        return $formula;
    }

    public function test_1()
    {
        $score = $this->formula()->PostPerformanceScore(1, 3);
        $this->assertEquals(3, $score);
    }

    public function test_2()
    {
        $score = $this->formula()->PostPerformanceScore(1, 2.5);
        $this->assertEquals(2.5, $score);
    }

    public function test_3()
    {
        $score = $this->formula()->PostPerformanceScore(2.89156559871079, 1.8);
        $this->assertEquals(5.204818078, $score);
    }

    public function test_4()
    {
        $score = $this->formula()->PostPerformanceScore(3.0189, 1.15);
        $this->assertEquals(3.471739278, $score);
    }

    public function test_5()
    {
        $score = $this->formula()->PostPerformanceScore(1.3408, 1);
        $this->assertEquals(1.3408, $score);
    }

    public function test_6()
    {
        $score = $this->formula()->PostPerformanceScore(1.3442, 1.001428571);
        $this->assertEquals(1.346166147, $score);
    }

    public function test_7()
    {
        $score = $this->formula()->PostPerformanceScore(1.3436, 1.222222222);
        $this->assertEquals(1.642158021, $score);
    }

    public function test_8()
    {
        $score = $this->formula()->PostPerformanceScore(1, 0);
        $this->assertEquals(0, $score);
    }

    public function test_9()
    {
        $score = $this->formula()->PostPerformanceScore(3.4377, 1.4);
        $this->assertEquals(4.81278, $score);
    }

    public function test_10()
    {
        $score = $this->formula()->PostPerformanceScore(1.2116, 1.005);
        $this->assertEquals(1.217658, $score);
    }

}
