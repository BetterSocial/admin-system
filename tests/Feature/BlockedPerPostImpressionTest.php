<?php

namespace Tests\Feature;

use App\Http\Controllers\FormulaController;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class BlockedPerPostImpressionTest extends TestCase
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
        $blockpointsPerImpression = 0;
        $b = $formula->BlockedPerPostImpression($blockpointsPerImpression);
        $this->assertEquals(1.99004975124378, $b);
    }

    public function test_2()
    {
        $formula = new FormulaController();
        $blockpointsPerImpression = 0.5;
        $b = $formula->BlockedPerPostImpression($blockpointsPerImpression);
        $this->assertEquals(1.56590087272225, $b);
    }

    public function test_3()
    {
        $formula = new FormulaController();
        $blockpointsPerImpression = 1;
        $b = $formula->BlockedPerPostImpression($blockpointsPerImpression);
        $this->assertEquals(1, $b);
    }

    public function test_4()
    {
        $formula = new FormulaController();
        $blockpointsPerImpression = 1.87500000011719;
        $b = $formula->BlockedPerPostImpression($blockpointsPerImpression);
        $this->assertEquals(0.360491316311436, $b);
    }

    public function test_5()
    {
        $formula = new FormulaController();
        $blockpointsPerImpression = 3.75000000023438;
        $b = $formula->BlockedPerPostImpression($blockpointsPerImpression);
        $this->assertEquals(0.0486563156547223, $b);
    }

    public function test_6()
    {
        $formula = new FormulaController();
        $blockpointsPerImpression = 10;
        $b = $formula->BlockedPerPostImpression($blockpointsPerImpression);
        $this->assertEquals(0.0006637275064381490, $b);
    }

    public function test_7()
    {
        $formula = new FormulaController();
        $blockpointsPerImpression = 18.75;
        $b = $formula->BlockedPerPostImpression($blockpointsPerImpression);
        $this->assertEquals( 0.0000147830604641901, $b);
    }

    public function test_8()
    {
        $formula = new FormulaController();
        $blockpointsPerImpression = 40;
        $b = $formula->BlockedPerPostImpression($blockpointsPerImpression);
        $this->assertEquals(0.000000034564021830582, $b);
    }

    public function test_9()
    {
        $formula = new FormulaController();
        $blockpointsPerImpression = 50;
        $b = $formula->BlockedPerPostImpression($blockpointsPerImpression);
        
        $this->assertEquals(0.00000000397, $b);
    }

    public function test_10()
    {
        $formula = new FormulaController();
        $blockpointsPerImpression = 93.75;
        $b = $formula->BlockedPerPostImpression($blockpointsPerImpression);
        $this->assertEquals(0, $b);
    }

}
