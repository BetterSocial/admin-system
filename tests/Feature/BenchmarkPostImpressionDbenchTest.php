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
    public function TestImpressionScore1()
    {
        $dur_min = 2500;
        $dur_marg = 400;
        $words = 30;
        $controller = new FormulaController();
        $response = $controller->BenchmarkPostImpression($dur_min,$dur_marg,$words);

        $this->assertEquals(14500, $response);
    }
    /** @test **/
    public function TestImpressionScore2()
    {
        $response = $this->call('POST', '/impression1', ['dur_min' =>config('constants.duration_minimum_post'),'dur_marg' =>config('constants.duration_marginal_per_word'),'words'=>30 ])->getContent();
        $this->assertEquals(14500, $response);
    }
     /** @test **/
    public function TestImpressionScore3()
    {
        $response = $this->call('POST', '/impression1', ['dur_min' =>config('constants.duration_minimum_post'),'dur_marg' =>config('constants.duration_marginal_per_word'),'words'=>200 ])->getContent();
        $this->assertEquals('82500', $response);
    }
     /** @test **/
    public function TestImpressionScore4()
    {
        $response = $this->call('POST', '/impression1', ['dur_min' =>config('constants.duration_minimum_post'),'dur_marg' =>config('constants.duration_marginal_per_word'),'words'=>300 ])->getContent();
        $this->assertEquals('122500', $response);
    }
     /** @test **/
    public function TestImpressionScore5()
    {
        $response = $this->call('POST', '/impression1', ['dur_min' =>config('constants.duration_minimum_post'),'dur_marg' =>config('constants.duration_marginal_per_word'),'words'=>120 ])->getContent();
        $this->assertEquals('50500', $response);
    }
     /** @test **/
    public function TestImpressionScore6()
    {
        $response = $this->call('POST', '/impression1', ['dur_min' =>config('constants.duration_minimum_post'),'dur_marg' =>config('constants.duration_marginal_per_word'),'words'=>80 ])->getContent();
        $this->assertEquals('34500', $response);
    }
     /** @test **/
    public function TestImpressionScore7()
    {
        $response = $this->call('POST', '/impression1', ['dur_min' =>config('constants.duration_minimum_post'),'dur_marg' =>config('constants.duration_marginal_per_word'),'words'=>2 ])->getContent();
        $this->assertEquals('3300', $response);
    }
     /** @test **/
    public function TestImpressionScore8()
    {
        $response = $this->call('POST', '/impression1', ['dur_min' =>config('constants.duration_minimum_post'),'dur_marg' =>config('constants.duration_marginal_per_word'),'words'=>89 ])->getContent();
        $this->assertEquals('38100', $response);
    }
     /** @test **/
    public function TestImpressionScore9()
    {
        $response = $this->call('POST', '/impression1', ['dur_min' =>config('constants.duration_minimum_post'),'dur_marg' =>config('constants.duration_marginal_per_word'),'words'=>182 ])->getContent();
        $this->assertEquals('75300', $response);
    }
     /** @test **/
    public function TestImpressionScore10()
    {
        $response = $this->call('POST', '/impression1', ['dur_min' =>config('constants.duration_minimum_post'),'dur_marg' =>config('constants.duration_marginal_per_word'),'words'=>19 ])->getContent();
        $this->assertEquals('10100', $response);
    }

}
