<?php

namespace Tests\Feature;

use App\Http\Controllers\FormulaController;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ApplyMultipleTotalScoreTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */

    /** @test **/
    public function test_1()
    {
        $w_topic = config('constants.weight_post_topic');
        $topic_followed = 1;
        $w_follow = config('constants.weight_post_follows');
        $w_2degree = config('constants.weight_post_2degree');
        $w_link_domain =config('constants.weight_post_linkdomain'); 
        $user_follow_author = TRUE;
        $follow_author_followers= 1;
        $link_post = 0;
        $controller = new FormulaController();
        $response = $controller->ApplyMultipliesToTotalScore($w_topic,$topic_followed,$w_follow,$w_2degree,$w_link_domain,$user_follow_author,$follow_author_followers,$link_post);
        $this->assertEquals(6, $response);
    }
    public function test_2()
    {

        $w_topic = config('constants.weight_post_topic');
        $topic_followed = 5;
        $w_follow = config('constants.weight_post_follows');
        $w_2degree = config('constants.weight_post_2degree');
        $w_link_domain =config('constants.weight_post_linkdomain'); 
        $user_follow_author = FALSE;
        $follow_author_followers= 1;
        $link_post = 1;
        $controller = new FormulaController();
        $response = $controller->ApplyMultipliesToTotalScore($w_topic,$topic_followed,$w_follow,$w_2degree,$w_link_domain,$user_follow_author,$follow_author_followers,$link_post);
        $this->assertEquals(17.66667425, $response);
    }
    public function test_3()
    {

        $w_topic = config('constants.weight_post_topic');
        $topic_followed = 3;
        $w_follow = config('constants.weight_post_follows');
        $w_2degree = config('constants.weight_post_2degree');
        $w_link_domain =config('constants.weight_post_linkdomain'); 
        $user_follow_author = TRUE;
        $follow_author_followers= 0;
        $link_post = 1;
        $controller = new FormulaController();
        $response = $controller->ApplyMultipliesToTotalScore($w_topic,$topic_followed,$w_follow,$w_2degree,$w_link_domain,$user_follow_author,$follow_author_followers,$link_post);
        $this->assertEquals(24.91497814, $response);
    }
    public function test_4()
    {

        $w_topic = config('constants.weight_post_topic');
        $topic_followed = 4;
        $w_follow = config('constants.weight_post_follows');
        $w_2degree = config('constants.weight_post_2degree');
        $w_link_domain =config('constants.weight_post_linkdomain'); 
        $user_follow_author = FALSE;
        $follow_author_followers= 0;
        $link_post = 0;
        $controller = new FormulaController();
        $response = $controller->ApplyMultipliesToTotalScore($w_topic,$topic_followed,$w_follow,$w_2degree,$w_link_domain,$user_follow_author,$follow_author_followers,$link_post);
        $this->assertEquals(4, $response);
    }
    public function test_5()
    {

        $w_topic = config('constants.weight_post_topic');
        $topic_followed = 5;
        $w_follow = config('constants.weight_post_follows');
        $w_2degree = config('constants.weight_post_2degree');
        $w_link_domain =config('constants.weight_post_linkdomain'); 
        $user_follow_author = FALSE;
        $follow_author_followers= 1;
        $link_post = 0;
        $controller = new FormulaController();
        $response = $controller->ApplyMultipliesToTotalScore($w_topic,$topic_followed,$w_follow,$w_2degree,$w_link_domain,$user_follow_author,$follow_author_followers,$link_post);
        $this->assertEquals(7.0666697, $response);
    }
    public function test_6()
    {

        $w_topic = config('constants.weight_post_topic');
        $topic_followed = 2;
        $w_follow = config('constants.weight_post_follows');
        $w_2degree = config('constants.weight_post_2degree');
        $w_link_domain =config('constants.weight_post_linkdomain'); 
        $user_follow_author = TRUE;
        $follow_author_followers= 1;
        $link_post = 1;
        $controller = new FormulaController();
        $response = $controller->ApplyMultipliesToTotalScore($w_topic,$topic_followed,$w_follow,$w_2degree,$w_link_domain,$user_follow_author,$follow_author_followers,$link_post);
        $this->assertEquals(19.98858107, $response);
    }
    public function test_7()
    {

        $w_topic = config('constants.weight_post_topic');
        $topic_followed = 9;
        $w_follow = config('constants.weight_post_follows');
        $w_2degree = config('constants.weight_post_2degree');
        $w_link_domain =config('constants.weight_post_linkdomain'); 
        $user_follow_author = TRUE;
        $follow_author_followers= 0;
        $link_post = 1;
        $controller = new FormulaController();
        $response = $controller->ApplyMultipliesToTotalScore($w_topic,$topic_followed,$w_follow,$w_2degree,$w_link_domain,$user_follow_author,$follow_author_followers,$link_post);
        $this->assertEquals(60, $response);
    }
    public function test_8()
    {

        $w_topic = config('constants.weight_post_topic');
        $topic_followed = 6;
        $w_follow = config('constants.weight_post_follows');
        $w_2degree = config('constants.weight_post_2degree');
        $w_link_domain =config('constants.weight_post_linkdomain'); 
        $user_follow_author = TRUE;
        $follow_author_followers= 0;
        $link_post = 0;
        $controller = new FormulaController();
        $response = $controller->ApplyMultipliesToTotalScore($w_topic,$topic_followed,$w_follow,$w_2degree,$w_link_domain,$user_follow_author,$follow_author_followers,$link_post);
        $this->assertEquals(16.38668636, $response);
    }
    public function test_9()
    {

        $w_topic = config('constants.weight_post_topic');
        $topic_followed = 100;
        $w_follow = config('constants.weight_post_follows');
        $w_2degree = config('constants.weight_post_2degree');
        $w_link_domain =config('constants.weight_post_linkdomain'); 
        $user_follow_author = FALSE;
        $follow_author_followers= 1;
        $link_post = 1;
        $controller = new FormulaController();
        $response = $controller->ApplyMultipliesToTotalScore($w_topic,$topic_followed,$w_follow,$w_2degree,$w_link_domain,$user_follow_author,$follow_author_followers,$link_post);
        $this->assertEquals(3840, $response);
    }
    public function test_10()
    {

        $w_topic = config('constants.weight_post_topic');
        $topic_followed = 12;
        $w_follow = config('constants.weight_post_follows');
        $w_2degree = config('constants.weight_post_2degree');
        $w_link_domain =config('constants.weight_post_linkdomain'); 
        $user_follow_author = TRUE;
        $follow_author_followers= 1;
        $link_post = 1;
        $controller = new FormulaController();
        $response = $controller->ApplyMultipliesToTotalScore($w_topic,$topic_followed,$w_follow,$w_2degree,$w_link_domain,$user_follow_author,$follow_author_followers,$link_post);
        $this->assertEquals(82.76748477, $response);
    }


}