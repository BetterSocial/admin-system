<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use App\Http\Controllers\FormulaController;
use Illuminate\Support\Facades\Log;
use Tests\TestCase;

class PostCountScoreTest extends TestCase
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
        $postCountScore = $formula->PostCountScore(0,config('constants.recommended_count_post_weekly'));
        $this->assertEquals(1, $postCountScore);
    }

    public  function test_2() {
        $formula = new FormulaController();
        $postCountScore = $formula->PostCountScore(2,config('constants.recommended_count_post_weekly'));
        $this->assertEquals(1, $postCountScore);
    }

    public  function test_7() {
        $formula = new FormulaController();
        $postCountScore = $formula->PostCountScore(7,config('constants.recommended_count_post_weekly'));
        $this->assertEquals(1, $postCountScore);
    }

    public  function test_10() {
        $formula = new FormulaController();
        $postCountScore = $formula->PostCountScore(10,config('constants.recommended_count_post_weekly'));
        $this->assertEquals(0.7, $postCountScore);
    }

    public  function test_70() {
        $formula = new FormulaController();
        $postCountScore = $formula->PostCountScore(70,config('constants.recommended_count_post_weekly'));
        $this->assertEquals(0.1, $postCountScore);
    }



}
