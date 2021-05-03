<?php

namespace Tests\Feature;

use App\Http\Controllers\FormulaController;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class FinalScorePostTest extends TestCase
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
        $impr = 0;
        $s_updown = 0;
        $z_updown = config('constants.z_value_updown_score');
        $ev_updown = config("constants.expected_value_updown_score");
        $final_score_post = $formula->UpDownScoreWilsonScore($impr,$s_updown,$z_updown, $ev_updown);
        $this->assertEquals(626.028, $final_score_post);
    }

}