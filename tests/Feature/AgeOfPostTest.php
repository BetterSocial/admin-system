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
        $expiration_setting = 1;
        $post_datetime = "4/28/2021 7:00:00";
        $now_datetime = "4/28/2021 9:00:00";
        $post_time = $formula->AgeOfPost($expiration_setting, $post_datetime, $now_datetime);
        $this->assertEquals(1, $post_time);
    }

    public function test_2(){
        $formula = new FormulaController();
        $expiration_setting = 1;
        $post_datetime = "4/28/2021 7:00:00";
        $now_datetime = "4/28/2021 9:00:00";
        $post_time = $formula->AgeOfPost($expiration_setting, $post_datetime, $now_datetime);
        $this->assertEquals(1, $post_time);
    }

    public function test_3(){
        $formula = new FormulaController();
        $expiration_setting = 1;
        $post_datetime = "4/28/2021 7:00:00";
        $now_datetime = "4/29/2021 13:00:00";
        $post_time = $formula->AgeOfPost($expiration_setting, $post_datetime, $now_datetime);
        $this->assertEquals(1, $post_time);
    }

    public function test_4(){
        $formula = new FormulaController();
        $expiration_setting = 1;
        $post_datetime = "4/28/2021 7:00:00";
        $now_datetime = "4/30/2021 7:00:00";
        $post_time = $formula->AgeOfPost($expiration_setting, $post_datetime, $now_datetime);
        $this->assertEquals(1, $post_time);
    }

    public function test_5(){
        $formula = new FormulaController();
        $expiration_setting = 7;
        $post_datetime = "4/28/2021 7:00:00";
        $now_datetime = "4/28/2021 19:00:00";
        $post_time = $formula->AgeOfPost($expiration_setting, $post_datetime, $now_datetime);
        $this->assertEquals(1, $post_time);
    }

    public function test_6(){
        $formula = new FormulaController();
        $expiration_setting = 7;
        $post_datetime = "4/28/2021 7:00:00";
        $now_datetime = "5/3/2021 7:00:00";
        $post_time = $formula->AgeOfPost($expiration_setting, $post_datetime, $now_datetime);
        $this->assertEquals(5, $post_time);
    }

    public function test_7(){
        $formula = new FormulaController();
        $expiration_setting = 7;
        $post_datetime = "4/28/2021 7:00:00";
        $now_datetime = "5/7/2021 7:00:00";
        $post_time = $formula->AgeOfPost($expiration_setting, $post_datetime, $now_datetime);
        $this->assertEquals(7, $post_time);
    }

    public function test_8(){
        $formula = new FormulaController();
        $expiration_setting = 30;
        $post_datetime = "4/28/2021 7:00:00";
        $now_datetime = "5/27/2021 7:00:00";
        $post_time = $formula->AgeOfPost($expiration_setting, $post_datetime, $now_datetime);
        $this->assertEquals(29, $post_time);
    }

    public function test_9(){
        $formula = new FormulaController();
        $expiration_setting = 30;
        $post_datetime = "4/28/2021 7:00:00";
        $now_datetime = "5/29/2021 7:00:00";
        $post_time = $formula->AgeOfPost($expiration_setting, $post_datetime, $now_datetime);
        $this->assertEquals(30, $post_time);
    }

    public function test_10(){
        $formula = new FormulaController();
        $expiration_setting = 'forever';
        $post_datetime = "4/28/2021 7:00:00";
        $now_datetime = "5/31/2021 7:00:00";
        $post_time = $formula->AgeOfPost($expiration_setting, $post_datetime, $now_datetime);
        $this->assertEquals(33, $post_time);
    }

}
