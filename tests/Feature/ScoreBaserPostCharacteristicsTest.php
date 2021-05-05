<?php

namespace Tests\Feature;

use App\Http\Controllers\FormulaController;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ScoreBaserPostCharacteristicsTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_1()
    {
        $formula = new FormulaController();
        $rec = 1;
        $w_rec = config('constants.weight_recency_score');
        $att = 3;
        $w_att = config('constants.weight_attribute_jobs');
        $d = 91;
        $w_d = config('constants.weight_domain_score'); 
        $p = 4;
        $w_p =  config('constants.weight_post_count'); 
        $post_link = TRUE;

        $score = $formula->ScoreBasedPostCharacteristics($rec,$w_rec, $att,$w_att,$d,$w_d,$p,$w_p,$post_link);

        $this->assertEquals(273, $score);
    }
    public function test_2()
    {
        $formula = new FormulaController();
        $rec = 32;
        $w_rec = config('constants.weight_recency_score');
        $att = 2;
        $w_att = config('constants.weight_attribute_jobs');
        $d = 5;
        $w_d = config('constants.weight_domain_score'); 
        $p = 32;
        $w_p =  config('constants.weight_post_count'); 
        $post_link = FALSE;

        $score = $formula->ScoreBasedPostCharacteristics($rec,$w_rec, $att,$w_att,$d,$w_d,$p,$w_p,$post_link);

        $this->assertEquals(2048, $score);
    }
    public function test_3()
    {
        $formula = new FormulaController();
        $rec = 213;
        $w_rec = config('constants.weight_recency_score');
        $att = 5;
        $w_att = config('constants.weight_attribute_jobs');
        $d = 6;
        $w_d = config('constants.weight_domain_score'); 
        $p = 3;
        $w_p =  config('constants.weight_post_count'); 
        $post_link = TRUE;

        $score = $formula->ScoreBasedPostCharacteristics($rec,$w_rec, $att,$w_att,$d,$w_d,$p,$w_p,$post_link);

        $this->assertEquals(6390, $score);
    }
    public function test_4()
    {
        $formula = new FormulaController();
        $rec = 2;
        $w_rec = config('constants.weight_recency_score');
        $att = 7;
        $w_att = config('constants.weight_attribute_jobs');
        $d = 2;
        $w_d = config('constants.weight_domain_score'); 
        $p = 2;
        $w_p =  config('constants.weight_post_count'); 
        $post_link = FALSE;

        $score = $formula->ScoreBasedPostCharacteristics($rec,$w_rec, $att,$w_att,$d,$w_d,$p,$w_p,$post_link);

        $this->assertEquals(28, $score);
    }
    public function test_5()
    {
        $formula = new FormulaController();
        $rec = 23;
        $w_rec = config('constants.weight_recency_score');
        $att = 4;
        $w_att = config('constants.weight_attribute_jobs');
        $d = 3;
        $w_d = config('constants.weight_domain_score'); 
        $p = 1;
        $w_p =  config('constants.weight_post_count'); 
        $post_link = TRUE;

        $score = $formula->ScoreBasedPostCharacteristics($rec,$w_rec, $att,$w_att,$d,$w_d,$p,$w_p,$post_link);

        $this->assertEquals(276, $score);
    }
    public function test_6()
    {
        $formula = new FormulaController();
        $rec = 5;
        $w_rec = config('constants.weight_recency_score');
        $att = 8;
        $w_att = config('constants.weight_attribute_jobs');
        $d = 123;
        $w_d = config('constants.weight_domain_score'); 
        $p = 5;
        $w_p =  config('constants.weight_post_count'); 
        $post_link = TRUE;

        $score = $formula->ScoreBasedPostCharacteristics($rec,$w_rec, $att,$w_att,$d,$w_d,$p,$w_p,$post_link);

        $this->assertEquals(4920, $score);
    }
    public function test_7()
    {
        $formula = new FormulaController();
        $rec = 6;
        $w_rec = config('constants.weight_recency_score');
        $att = 9;
        $w_att = config('constants.weight_attribute_jobs');
        $d = 10;
        $w_d = config('constants.weight_domain_score'); 
        $p = 65;
        $w_p =  config('constants.weight_post_count'); 
        $post_link = FALSE;

        $score = $formula->ScoreBasedPostCharacteristics($rec,$w_rec, $att,$w_att,$d,$w_d,$p,$w_p,$post_link);

        $this->assertEquals(3510, $score);
    }
    public function test_8()
    {
        $formula = new FormulaController();
        $rec = 7;
        $w_rec = config('constants.weight_recency_score');
        $att = 10;
        $w_att = config('constants.weight_attribute_jobs');
        $d = 2;
        $w_d = config('constants.weight_domain_score'); 
        $p = 3;
        $w_p =  config('constants.weight_post_count'); 
        $post_link = FALSE;

        $score = $formula->ScoreBasedPostCharacteristics($rec,$w_rec, $att,$w_att,$d,$w_d,$p,$w_p,$post_link);

        $this->assertEquals(210, $score);
    }
    public function test_9()
    {
        $formula = new FormulaController();
        $rec = 2;
        $w_rec = config('constants.weight_recency_score');
        $att = 11;
        $w_att = config('constants.weight_attribute_jobs');
        $d = 3;
        $w_d = config('constants.weight_domain_score'); 
        $p = 7;
        $w_p =  config('constants.weight_post_count'); 
        $post_link = FALSE;

        $score = $formula->ScoreBasedPostCharacteristics($rec,$w_rec, $att,$w_att,$d,$w_d,$p,$w_p,$post_link);

        $this->assertEquals(154, $score);
    }
    public function test_10()
    {
        $formula = new FormulaController();
        $rec = 9;
        $w_rec = config('constants.weight_recency_score');
        $att = 23;
        $w_att = config('constants.weight_attribute_jobs');
        $d = 4;
        $w_d = config('constants.weight_domain_score'); 
        $p = 8;
        $w_p =  config('constants.weight_post_count'); 
        $post_link = TRUE;

        $score = $formula->ScoreBasedPostCharacteristics($rec,$w_rec, $att,$w_att,$d,$w_d,$p,$w_p,$post_link);

        $this->assertEquals(828, $score);
    }

}