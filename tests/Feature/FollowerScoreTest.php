<?php

namespace Tests\Feature;

use App\Http\Controllers\FormulaController;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class FollowerScoreTest extends TestCase
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
        $followers_count = 0;
        $follower_score = $formula->FollowerScore($followers_count);
        $this->assertEquals(0, $follower_score);
    }
    public function test_2()
    {
        $formula = new FormulaController();
        $followers_count = 1;
        $follower_score = $formula->FollowerScore($followers_count);
        $this->assertEquals(0.7783867544, $follower_score);
    }
    public function test_3()
    {
        $formula = new FormulaController();
        $followers_count = 8;
        $follower_score = $formula->FollowerScore($followers_count);
        $this->assertEquals(0.8636741801, $follower_score);
    }
    public function test_4()
    {
        $formula = new FormulaController();
        $followers_count = 12;
        $follower_score = $formula->FollowerScore($followers_count);
        $this->assertEquals(0.8813623601, $follower_score);
    }
    public function test_5()
    {
        $formula = new FormulaController();
        $followers_count = 25;
        $follower_score = $formula->FollowerScore($followers_count);
        $this->assertEquals(0.9143078268, $follower_score);
    }
    public function test_6()
    {
        $formula = new FormulaController();
        $followers_count = 90;
        $follower_score = $formula->FollowerScore($followers_count);
        $this->assertEquals(0.974782138, $follower_score);
    }
    public function test_7()
    {
        $formula = new FormulaController();
        $followers_count = 100;
        $follower_score = $formula->FollowerScore($followers_count);
        $this->assertEquals(0.9799308653, $follower_score);
    }
    public function test_8()
    {
        $formula = new FormulaController();
        $followers_count = 150;
        $follower_score = $formula->FollowerScore($followers_count);
        $this->assertEquals(1, $follower_score);
    }
    public function test_9()
    {
        $formula = new FormulaController();
        $followers_count = 300;
        $follower_score = $formula->FollowerScore($followers_count);
        $this->assertEquals(1.0352649238413776, $follower_score);
    }
    public function test_10()
    {
        $formula = new FormulaController();
        $followers_count = 1500;
        $follower_score = $formula->FollowerScore($followers_count);
        $this->assertEquals(1.1220184543019633, $follower_score);
    }



}
