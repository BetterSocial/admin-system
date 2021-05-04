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
    public function test_()
    {
        $formula = new FormulaController();
        $post_time = $formula->AgeOfPost(1,"04/28/2021 07:00:00", "04/28/2021 07:00:00");
//        $this->assertEquals(14500, $post_time);


    }
}
