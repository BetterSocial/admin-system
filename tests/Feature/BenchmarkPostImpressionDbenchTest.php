<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Http\Controllers\FormulaController;

class BenchmarkPostImpressionDbenchTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    /** @test **/
    public function TestImpressionScore()
    {
        $dur_min = 2500;
        $dur_marg = 400;
        $words = 30;
        $controller = new FormulaController();
        $response = $controller->BenchmarkPostImpression($dur_min,$dur_marg,$words);
    
        $this->assertEquals(14500, $response);
    }

    /** @test **/
    public function TestImpressionScoreEnv()
    {
        $response = $this->call('POST', '/impression1', ['dur_min' =>config('constants.duration_minimum_post'),'dur_marg' =>config('constants.duration_marginal_per_word'),'words'=>30 ])->getContent();
        $this->assertEquals('14500', $response);
    }
}
