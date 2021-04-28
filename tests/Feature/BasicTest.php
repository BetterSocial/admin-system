<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use App\Http\Controllers\FormulaController;
use Illuminate\Support\Facades\Log;
use Tests\TestCase;

class BasicTest extends TestCase
{
    private $FormulaController = FormulaController::class;

    /**
     * A basic feature test example.
     *
     * @return void
     */

    /** @test **/
    public function test_example()
    {

//        $formula = $this->FormulaController::postCountScore(config('constants.recommended_count_post_weekly'),70);


        $config = config('constants.recommended_count_post_weekly');
        $response = $this->get('/');
        $response->assertStatus(302);


        $formula = new FormulaController();
        $postCountScore = $formula->PostCountScore(config('constants.recommended_count_post_weekly'),0);
        $this->assertEquals(1, $postCountScore);


        $upDownScore = $formula->UpdownScore(1,1,0,
            config('constants.weight_downvote'),config('constants.weight_no_vote'));
        $this->assertEquals(1, $upDownScore);






    }
}
