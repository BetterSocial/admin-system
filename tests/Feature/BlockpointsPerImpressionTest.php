<?php

namespace Tests\Feature;

use App\Http\Controllers\FormulaController;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class BlockpointsPerImpressionTest extends TestCase
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
        $bpp_impr_un = $formula->BlockpointsPerImpression(100, 123, config('constants.block_per_post_impression'));
        $this->assertEquals(152.43902439977134  , $bpp_impr_un);
    }

    public function test_2()
    {
        $formula = new FormulaController();
        $bpp_impr_un = $formula->BlockpointsPerImpression(100, 0, config('constants.block_per_post_impression'));
        $this->assertEquals(0, $bpp_impr_un);
    }

    public function test_3(){
        $formula = new FormulaController();
        $bpp_impr_un = $formula->BlockpointsPerImpression(0, 555, config('constants.block_per_post_impression'));
        $this->assertEquals(0, $bpp_impr_un);
    }

    public function test_4(){
        $formula = new FormulaController();
        $bpp_impr_un = $formula->BlockpointsPerImpression(201, 2010, config('constants.block_per_post_impression'));
        $this->assertEquals(18.750000001171877, $bpp_impr_un);
    }

    public function test_5(){
        $formula = new FormulaController();
        $bpp_impr_un = $formula->BlockpointsPerImpression(515, 2505, config('constants.block_per_post_impression'));
        $this->assertEquals(38.54790419402601, $bpp_impr_un);
    }

    public function test_6(){
        $formula = new FormulaController();
        $bpp_impr_un = $formula->BlockpointsPerImpression(5, 250, config('constants.block_per_post_impression'));
        $this->assertEquals(3.75000000023437, $bpp_impr_un);
    }

    public function test_7(){
        $formula = new FormulaController();
        $bpp_impr_un = $formula->BlockpointsPerImpression(10, 1000, config('constants.block_per_post_impression'));
        $this->assertEquals(1.87500000011719, $bpp_impr_un);
    }

    public function test_8(){
        $formula = new FormulaController();
        $bpp_impr_un = $formula->BlockpointsPerImpression(2500, 10000, config('constants.block_per_post_impression'));
        $this->assertEquals(46.87500000292969, $bpp_impr_un);

    }

    public function test_9(){
        $formula = new FormulaController();
        $bpp_impr_un = $formula->BlockpointsPerImpression(2, 7, config('constants.block_per_post_impression'));
        $this->assertEquals(53.57142857477678, $bpp_impr_un);

    }

    public function test_10(){
        $formula = new FormulaController();
        $bpp_impr_un = $formula->BlockpointsPerImpression(10, 20, config('constants.block_per_post_impression'));
        $this->assertEquals(93.75000000585938, $bpp_impr_un);
    }


}
