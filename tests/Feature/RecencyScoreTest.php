<?php

namespace Tests\Feature;

use App\Http\Controllers\FormulaController;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class RecencyScoreTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_1(){
        $formula = new FormulaController();
        $age_of_post = 0.902;
        $expiration_setting =  1;
        $post_score = $formula->RecencyScore($age_of_post, $expiration_setting);
        $this->assertEquals(0.993686, $post_score);
    }
    public function test_2(){
        $formula = new FormulaController();
        $age_of_post = 1;
        $expiration_setting =  7;
        $post_score = $formula->RecencyScore($age_of_post, $expiration_setting);
        $this->assertEquals(0.9, $post_score);
    }
    public function test_3(){
        $formula = new FormulaController();
        $age_of_post = 0.4194;
        $expiration_setting = 'forever';
        $post_score = $formula->RecencyScore($age_of_post, $expiration_setting);
        $this->assertEquals(0.763341560927225, $post_score);
    }
    public function test_4(){
        $formula = new FormulaController();
        $age_of_post = 1;
        $expiration_setting =  30;
        $post_score = $formula->RecencyScore($age_of_post, $expiration_setting);
        $this->assertEquals(0.725, $post_score);
    }
    public function test_5(){
        $formula = new FormulaController();
        $age_of_post = 10;
        $expiration_setting =  30;
        $post_score = $formula->RecencyScore($age_of_post, $expiration_setting);
        $this->assertEquals(0.580867301030104, $post_score);
    }
    public function test_6(){
        $formula = new FormulaController();
        $age_of_post = 100;
        $expiration_setting =  1;
        $post_score = $formula->RecencyScore($age_of_post, $expiration_setting);
        $this->assertEquals(0.3, $post_score);
    }
    public function test_7(){
        $formula = new FormulaController();
        $age_of_post = 300;
        $expiration_setting = 'forever';
        $post_score = $formula->RecencyScore($age_of_post, $expiration_setting);
        $this->assertEquals(0.183056117121725, $post_score);
    }
    public function test_8(){
        $formula = new FormulaController();
        $age_of_post = 735;
        $expiration_setting = 'forever';
        $post_score = $formula->RecencyScore($age_of_post, $expiration_setting);
        $this->assertEquals(0.0201041789137587, $post_score);
    }
    public function test_9(){
        $formula = new FormulaController();
        $age_of_post = 736;
        $expiration_setting = 'forever';
        $post_score = $formula->RecencyScore($age_of_post, $expiration_setting);
        $this->assertEquals(0.02, $post_score);
    }
    public function test_10(){
        $formula = new FormulaController();
        $age_of_post = 1000;
        $expiration_setting = 'forever';
        $post_score = $formula->RecencyScore($age_of_post, $expiration_setting);
        $this->assertEquals(0.02, $post_score);
    }

}
