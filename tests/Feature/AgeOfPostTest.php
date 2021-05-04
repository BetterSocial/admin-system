<?php

namespace Tests\Feature;

use App\Http\Controllers\FormulaController;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class AgeOfPostTest extends TestCase
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
        $post_time = $formula->AgeOfPost(1,"4/28/2021 7:00:00", "4/28/2021 9:00:00");
        $this->assertEquals(1, $post_time);
    }

    public function test_2(){
        $formula = new FormulaController();
        $post_time = $formula->AgeOfPost(1,"4/28/2021 7:00:00", "4/28/2021 12:00:00");
        $this->assertEquals(1, $post_time);
    }
    public function test_3(){
        $formula = new FormulaController();
        $post_time = $formula->AgeOfPost(1,"4/28/2021 7:00:00", "4/29/2021 13:00:00");
        $this->assertEquals(1, $post_time);
    }

    public function test_4(){
        $formula = new FormulaController();
        $post_time = $formula->AgeOfPost(1,"4/28/2021 7:00:00", "4/30/2021 7:00:00");
        $this->assertEquals(1, $post_time);
    }

    // TODO test sampai 10 item


}
