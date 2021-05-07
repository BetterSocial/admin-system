<?php

namespace Tests\Feature;

use App\Http\Controllers\FormulaController;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class TotalPostTest extends TestCase
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
        $total_post = $formula->TotalPost(0);

        $this->assertEquals(1, $total_post);
    }

    public function test_2(){
        $formula = new FormulaController();
        $total_post = $formula->TotalPost(1);

        $this->assertEquals(1, $total_post);
    }

    public function test_3(){
        $formula = new FormulaController();
        $total_post = $formula->TotalPost(2);

        $this->assertEquals(2, $total_post);
    }

    public function test_4(){
        $formula = new FormulaController();
        $total_post = $formula->TotalPost(3);

        $this->assertEquals(3, $total_post);
    }

    public function test_5(){
        $formula = new FormulaController();
        $total_post = $formula->TotalPost(7);

        $this->assertEquals(7, $total_post);
    }

    public function test_6(){
        $formula = new FormulaController();
        $total_post = $formula->TotalPost(2);

        $this->assertEquals(2, $total_post);
    }

    public function test_7(){
        $formula = new FormulaController();
        $total_post = $formula->TotalPost(5);

        $this->assertEquals(5, $total_post);
    }

    public function test_8(){
        $formula = new FormulaController();
        $total_post = $formula->TotalPost(100);

        $this->assertEquals(100, $total_post);
    }

    public function test_9(){
        $formula = new FormulaController();
        $total_post = $formula->TotalPost(200);

        $this->assertEquals(200, $total_post);
    }

    public function test_10(){
        $formula = new FormulaController();
        $total_post = $formula->TotalPost(300);

        $this->assertEquals(300, $total_post);
    }

}
