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
        $total_blocks = 100;
        $impr = 123;
        $bpImpr_global = config('constants.block_per_post_impression');
        $bpp_impr_un = $formula->BlockpointsPerImpression( $total_blocks, $impr, $bpImpr_global);
        $this->assertEquals(152.43902439977134  , $bpp_impr_un);
    }

    public function test_2()
    {
        $formula = new FormulaController();
        $total_blocks = 100;
        $impr = 0;
        $bpImpr_global = config('constants.block_per_post_impression');
        $bpp_impr_un = $formula->BlockpointsPerImpression( $total_blocks, $impr, $bpImpr_global);
        $this->assertEquals(0, $bpp_impr_un);
    }

    public function test_3(){
        $formula = new FormulaController();
        $total_blocks = 0;
        $impr = 555;
        $bpImpr_global = config('constants.block_per_post_impression');
        $bpp_impr_un = $formula->BlockpointsPerImpression( $total_blocks, $impr, $bpImpr_global);
        $this->assertEquals(0, $bpp_impr_un);
    }

    public function test_4(){
        $formula = new FormulaController();
        $total_blocks = 201;
        $impr = 2010;
        $bpImpr_global = config('constants.block_per_post_impression');
        $bpp_impr_un = $formula->BlockpointsPerImpression( $total_blocks, $impr, $bpImpr_global);
        $this->assertEquals(18.750000001171877, $bpp_impr_un);
    }

    public function test_5(){
        $formula = new FormulaController();
        $total_blocks = 515;
        $impr = 2505;
        $bpImpr_global = config('constants.block_per_post_impression');
        $bpp_impr_un = $formula->BlockpointsPerImpression( $total_blocks, $impr, $bpImpr_global);
        $this->assertEquals(38.54790419402601, $bpp_impr_un);
    }

    public function test_6(){
        $formula = new FormulaController();
        $total_blocks = 5;
        $impr = 250;
        $bpImpr_global = config('constants.block_per_post_impression');
        $bpp_impr_un = $formula->BlockpointsPerImpression( $total_blocks, $impr, $bpImpr_global);
        
        $this->assertEquals(3.75000000023437, $bpp_impr_un);
    }

    public function test_7(){
        $formula = new FormulaController();
        $total_blocks = 10;
        $impr = 1000;
        $bpImpr_global = config('constants.block_per_post_impression');
        $bpp_impr_un = $formula->BlockpointsPerImpression( $total_blocks, $impr, $bpImpr_global);
        $this->assertEquals(1.87500000011719, $bpp_impr_un);
    }

    public function test_8(){
        $formula = new FormulaController();
        $total_blocks = 2500;
        $impr = 10000;
        $bpImpr_global = config('constants.block_per_post_impression');
        $bpp_impr_un = $formula->BlockpointsPerImpression( $total_blocks, $impr, $bpImpr_global);
        $this->assertEquals(46.87500000292969, $bpp_impr_un);

    }

    public function test_9(){
        $formula = new FormulaController();
        $total_blocks = 2;
        $impr = 7;
        $bpImpr_global = config('constants.block_per_post_impression');
        $bpp_impr_un = $formula->BlockpointsPerImpression( $total_blocks, $impr, $bpImpr_global);
        $this->assertEquals(53.57142857477678, $bpp_impr_un);

    }

    public function test_10(){
        $formula = new FormulaController();
        $total_blocks = 10;
        $impr = 20;
        $bpImpr_global = config('constants.block_per_post_impression');
        $bpp_impr_un = $formula->BlockpointsPerImpression( $total_blocks, $impr, $bpImpr_global);
        $this->assertEquals(93.75000000585938, $bpp_impr_un);
    }


}
