<?php

namespace Tests\Feature;

use App\Http\Controllers\FormulaController;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class FollowersQualityTest extends TestCase
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
        $follower_score = $formula->FollowersQuality(40.70,22);
        $this->assertEquals(1.85, $follower_score);

    }

    public function test_2()
    {
        $formula = new FormulaController();
        $follower_score = $formula->FollowersQuality(55.44,28);
        $this->assertEquals(1.98, $follower_score);
    }

    public function test_3()
    {
        $formula = new FormulaController();
        $follower_score = $formula->FollowersQuality(38.87,23);
        $this->assertEquals(1.69, $follower_score);
    }

    public function test_4()
    {
        $formula = new FormulaController();
        $follower_score = $formula->FollowersQuality(73.99,49);
        $this->assertEquals(1.51, $follower_score);
    }

    public function test_5()
    {
        $formula = new FormulaController();
        $follower_score = $formula->FollowersQuality(50.17,29);
        $this->assertEquals(1.73, $follower_score);
    }

    public function test_6()
    {
        $formula = new FormulaController();
        $follower_score = $formula->FollowersQuality(100.80,60);
        $this->assertEquals(1.68, $follower_score);
    }

    public function test_7()
    {
        $formula = new FormulaController();
        $follower_score = $formula->FollowersQuality(24.18,13);
        $this->assertEquals(1.86, $follower_score);
    }

    public function test_8()
    {
        $formula = new FormulaController();
        $follower_score = $formula->FollowersQuality(25.74,13);
        $this->assertEquals(1.98, $follower_score);
    }

    public function test_9()
    {
        $formula = new FormulaController();
        $follower_score = $formula->FollowersQuality(20.41,13);
        $this->assertEquals(1.57, $follower_score);
    }

    public function test_10()
    {
        $formula = new FormulaController();
        $follower_score = $formula->FollowersQuality(20.16,12);
        $this->assertEquals(1.68, $follower_score);
    }


}
