<?php

namespace Tests\Feature;

use App\Http\Controllers\FormulaController;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class AveragePostScoreTest extends TestCase
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
        $post_score = $formula->AveragePostScore(0,0);
        $this->assertEquals(1, $post_score);
    }

    public function test_2(){
        $formula = new FormulaController();
        $post_score = $formula->AveragePostScore(0,10);
        $this->assertEquals(0, $post_score);
    }

    public function test_3(){
        $formula = new FormulaController();
        $post_score = $formula->AveragePostScore(10,0);
        $this->assertEquals(2, $post_score);
    }

    public function test_4(){
        $formula = new FormulaController();
        $post_score = $formula->AveragePostScore(25,5);
        $this->assertEquals(2, $post_score);
    }

    public function test_5(){
        $formula = new FormulaController();
        $post_score = $formula->AveragePostScore(100,20);
        $this->assertEquals(10, $post_score);
    }

    public function test_6(){}

    public function test_7(){}

    public function test_8(){}

    public function test_9(){}

    public function test_10(){}
}
