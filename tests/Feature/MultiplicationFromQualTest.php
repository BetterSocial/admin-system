<?php

namespace Tests\Feature;

use App\Http\Controllers\FormulaController;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class MultiplicationFromQualTest extends TestCase
{
     /**
     * A basic feature test example.
     *
     * @return void
     */

     /** @test **/
     public function test_1()
     {
        $w_edu = config('constants.weight_address_edu');
        $edu_email = TRUE;
        $w_email = config('constants.weight_address_work');
        $w_twitter = config('constants.weight_twitter');
        $follower_twitter = 200;
        $email = 2.00;
        $w_useratt = 2.00;
        $formula = new FormulaController();
        $Multiplication = $formula->MultiplicationFromQualityCriteriaScore($w_edu, $edu_email,$w_email, $w_twitter,$follower_twitter,$email,$w_useratt);
        $this->assertEquals(3.47793076695, $Multiplication);
     }
     
     public function test_2()
     {
        $w_edu = config('constants.weight_address_edu');
        $edu_email = FALSE;
        $w_email = config('constants.weight_address_work');
        $w_twitter = config('constants.weight_twitter');
        $follower_twitter = 150;
        $email = 0.00;
        $w_useratt = 1;
        $formula = new FormulaController();
        $Multiplication = $formula->MultiplicationFromQualityCriteriaScore($w_edu, $edu_email,$w_email, $w_twitter,$follower_twitter,$email,$w_useratt);
        $this->assertEquals(1, $Multiplication);
     }

     public function test_3()
     {
        $w_edu = config('constants.weight_address_edu');
        $edu_email = TRUE;
        $w_email = config('constants.weight_address_work');
        $w_twitter = config('constants.weight_twitter');
        $follower_twitter = 90;
        $email = 3.00;
        $w_useratt = 2.5;
        $formula = new FormulaController();
        $Multiplication = $formula->MultiplicationFromQualityCriteriaScore($w_edu, $edu_email,$w_email, $w_twitter,$follower_twitter,$email,$w_useratt);
        $this->assertEquals(4.44914361412, $Multiplication);
     }

     public function test_4()
     {
        $w_edu = config('constants.weight_address_edu');
        $edu_email = TRUE;
        $w_email = config('constants.weight_address_work');
        $w_twitter = config('constants.weight_twitter');
        $follower_twitter = 230;
        $email = 3.00;
        $w_useratt = 1;
        $formula = new FormulaController();
        $Multiplication = $formula->MultiplicationFromQualityCriteriaScore($w_edu, $edu_email,$w_email, $w_twitter,$follower_twitter,$email,$w_useratt);
        $this->assertEquals(3.55931489130, $Multiplication);
     }

     public function test_5()
     {
        $w_edu = config('constants.weight_address_edu');
        $edu_email = FALSE;
        $w_email = config('constants.weight_address_work');
        $w_twitter = config('constants.weight_twitter');
        $follower_twitter = 28;
        $email = 2.00;
        $w_useratt = 0.001;
        $formula = new FormulaController();
        $Multiplication = $formula->MultiplicationFromQualityCriteriaScore($w_edu, $edu_email,$w_email, $w_twitter,$follower_twitter,$email,$w_useratt);
        $this->assertEquals(0.00124211813, $Multiplication);
     }

     public function test_6()
     {
        $w_edu = config('constants.weight_address_edu');
        $edu_email = FALSE;
        $w_email = config('constants.weight_address_work');
        $w_twitter = config('constants.weight_twitter');
        $follower_twitter = 300;
        $email = 1.00;
        $w_useratt = 10;
        $formula = new FormulaController();
        $Multiplication = $formula->MultiplicationFromQualityCriteriaScore($w_edu, $edu_email,$w_email, $w_twitter,$follower_twitter,$email,$w_useratt);
        $this->assertEquals(24, $Multiplication);
     }

     public function test_7()
     {
        $w_edu = config('constants.weight_address_edu');
        $edu_email = FALSE;
        $w_email = config('constants.weight_address_work');
        $w_twitter = config('constants.weight_twitter');
        $follower_twitter = 210;
        $email = 2.00;
        $w_useratt = 2.5;
        $formula = new FormulaController();
        $Multiplication = $formula->MultiplicationFromQualityCriteriaScore($w_edu, $edu_email,$w_email, $w_twitter,$follower_twitter,$email,$w_useratt);
        $this->assertEquals(6.21059065527, $Multiplication);
     }

     public function test_8()
     {
        $w_edu = config('constants.weight_address_edu');
        $edu_email = TRUE;
        $w_email = config('constants.weight_address_work');
        $w_twitter = config('constants.weight_twitter');
        $follower_twitter = 180;
        $email = 2.00;
        $w_useratt = 2.00;
        $formula = new FormulaController();
        $Multiplication = $formula->MultiplicationFromQualityCriteriaScore($w_edu, $edu_email,$w_email, $w_twitter,$follower_twitter,$email,$w_useratt);
        $this->assertEquals(3.47793076695, $Multiplication);
     }

     public function test_9()
     {
        $w_edu = config('constants.weight_address_edu');
        $edu_email = TRUE;
        $w_email = config('constants.weight_address_work');
        $w_twitter = config('constants.weight_twitter');
        $follower_twitter = 201;
        $email = 0.00;
        $w_useratt = 1;
        $formula = new FormulaController();
        $Multiplication = $formula->MultiplicationFromQualityCriteriaScore($w_edu, $edu_email,$w_email, $w_twitter,$follower_twitter,$email,$w_useratt);
        $this->assertEquals(2.80000000000, $Multiplication);
     }

     public function test_10()
     {
        $w_edu = config('constants.weight_address_edu');
        $edu_email = FALSE;
        $w_email = config('constants.weight_address_work');
        $w_twitter = config('constants.weight_twitter');
        $follower_twitter = 209;
        $email = 1.00;
        $w_useratt = 10;
        $formula = new FormulaController();
        $Multiplication = $formula->MultiplicationFromQualityCriteriaScore($w_edu, $edu_email,$w_email, $w_twitter,$follower_twitter,$email,$w_useratt);
        $this->assertEquals(24.00000000000, $Multiplication);
     }


}