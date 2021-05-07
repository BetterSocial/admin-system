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
        $user_score_without_followers_score = 40.70;
        $followers_count = 22;
        $follower_score = $formula->FollowersQuality( $user_score_without_followers_score,$followers_count);
        $this->assertEquals(1.85, $follower_score);

    }

    public function test_2()
    {
        $formula = new FormulaController();
        $user_score_without_followers_score = 55.44;
        $followers_count = 28;
        $follower_score = $formula->FollowersQuality( $user_score_without_followers_score,$followers_count);
        $this->assertEquals(1.98, $follower_score);
    }

    public function test_3()
    {
        $formula = new FormulaController();
        $user_score_without_followers_score = 38.87;
        $followers_count = 23;
        $follower_score = $formula->FollowersQuality( $user_score_without_followers_score,$followers_count);
        $this->assertEquals(1.69, $follower_score);
    }

    public function test_4()
    {
        $formula = new FormulaController();
        $user_score_without_followers_score = 73.99;
        $followers_count = 49;
        $follower_score = $formula->FollowersQuality( $user_score_without_followers_score,$followers_count);
        $this->assertEquals(1.51, $follower_score);
    }

    public function test_5()
    {
        $formula = new FormulaController();
        $user_score_without_followers_score = 50.17;
        $followers_count = 29;
        $follower_score = $formula->FollowersQuality( $user_score_without_followers_score,$followers_count);
        $this->assertEquals(1.73, $follower_score);
    }

    public function test_6()
    {
        $formula = new FormulaController();
        $user_score_without_followers_score = 100.80;
        $followers_count = 60;
        $follower_score = $formula->FollowersQuality( $user_score_without_followers_score,$followers_count);
        $this->assertEquals(1.68, $follower_score);
    }

    public function test_7()
    {
        $formula = new FormulaController();
        $user_score_without_followers_score = 24.18;
        $followers_count = 13;
        $follower_score = $formula->FollowersQuality( $user_score_without_followers_score,$followers_count);
        $this->assertEquals(1.86, $follower_score);
    }

    public function test_8()
    {
        $formula = new FormulaController();

        $user_score_without_followers_score = 25.74;
        $followers_count = 13;
        $follower_score = $formula->FollowersQuality( $user_score_without_followers_score,$followers_count);
        $this->assertEquals(1.98, $follower_score);
    }

    public function test_9()
    {
        $formula = new FormulaController();
        $user_score_without_followers_score = 20.41;
        $followers_count = 13;
        $follower_score = $formula->FollowersQuality( $user_score_without_followers_score,$followers_count);
        $this->assertEquals(1.57, $follower_score);
    }

    public function test_10()
    {
        $formula = new FormulaController();
        $user_score_without_followers_score = 20.16;
        $followers_count = 12;
        $follower_score = $formula->FollowersQuality( $user_score_without_followers_score,$followers_count);
        
        $this->assertEquals(1.68, $follower_score);
    }


}
