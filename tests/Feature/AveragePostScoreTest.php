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
        $post_performance_score = 0;
        $count_post = 0;
        $post_score = $formula->AveragePostScore($post_performance_score,$count_post);
        $this->assertEquals(1, $post_score);
    }

    public function test_2(){
        $formula = new FormulaController();
        $post_performance_score = 0;
        $count_post = 10;
        $post_score = $formula->AveragePostScore($post_performance_score,$count_post);
        $this->assertEquals(0, $post_score);
    }

    public function test_3(){
        $formula = new FormulaController();
        $post_performance_score = 10;
        $count_post = 0;
        $post_score = $formula->AveragePostScore($post_performance_score,$count_post);
        $this->assertEquals(2, $post_score);
    }

    public function test_4(){
        $formula = new FormulaController();
        $post_performance_score = 25;
        $count_post = 5;
        $post_score = $formula->AveragePostScore($post_performance_score,$count_post);
        $this->assertEquals(3, $post_score);
    }

    public function test_5(){
        $formula = new FormulaController();
        $post_performance_score = 100;
        $count_post = 20;
        $post_score = $formula->AveragePostScore($post_performance_score,$count_post);
        $this->assertEquals(10, $post_score);
    }

    public function test_6(){
        $formula = new FormulaController();
        $post_performance_score = 500;
        $count_post = 50;
        $post_score = $formula->AveragePostScore($post_performance_score,$count_post);
        $this->assertEquals(50, $post_score);
    }

    public function test_7(){
        $formula = new FormulaController();
        $post_performance_score = 60;
        $count_post = 55;
        $post_score = $formula->AveragePostScore($post_performance_score,$count_post);
        $this->assertEquals(6, $post_score);
    }

    public function test_8(){
        $formula = new FormulaController();
        $post_performance_score = 25000;
        $count_post = 100;
        $post_score = $formula->AveragePostScore($post_performance_score,$count_post);
        $this->assertEquals(2500, $post_score);
    }

    public function test_9(){
        $formula = new FormulaController();
        $post_performance_score = 1125;
        $count_post = 1000;
        $post_score = $formula->AveragePostScore($post_performance_score,$count_post);
        $this->assertEquals(112.5, $post_score);
    }

    public function test_10(){
        $formula = new FormulaController();
        $post_performance_score = 0;
        $count_post = 1;
        $post_score = $formula->AveragePostScore($post_performance_score,$count_post);
        $this->assertEquals(0.9, $post_score);
    }
}
