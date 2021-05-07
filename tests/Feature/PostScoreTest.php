<?php

namespace Tests\Feature;

use App\Http\Controllers\FormulaController;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class PostScoreTest extends TestCase
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
        $impr = 1 ;
        $ws_nonBP = 0.996045550500996;
        $ww_nonBP = config('constants.weight_exponential_non_bp');
        $ws_D = 2.58747698;
        $ww_D = config('constants.weight_exponential_d');
        $ws_updown =  0.911187889530622;
        $ww_updown = config('constants.weight_exponential_updown_score');

        $p_pref = $formula->PostScore($impr, $ws_nonBP, $ww_nonBP, $ws_D, $ww_D, $ws_updown, $ww_updown);
        $this->assertEquals(1, $p_pref);
    }

    public function test_2(){
        $formula = new FormulaController();
        $impr = 2 ;
        $ws_nonBP = 0.998510948759491;
        $ww_nonBP = config('constants.weight_exponential_non_bp');
        $ws_D = 2.852906287;
        $ww_D = config('constants.weight_exponential_d');
        $ws_updown =  0.907783700493035;
        $ww_updown = config('constants.weight_exponential_updown_score');

        $p_pref = $formula->PostScore($impr, $ws_nonBP, $ww_nonBP, $ws_D, $ww_D, $ws_updown, $ww_updown);
        $this->assertEquals(1, $p_pref);
    }

    public function test_3(){
        $formula = new FormulaController();
        $impr = 5 ;
        $ws_nonBP = 1;
        $ww_nonBP = config('constants.weight_exponential_non_bp');
        $ws_D = 2.979002625;
        $ww_D = config('constants.weight_exponential_d');
        $ws_updown =  0.904946876502553;
        $ww_updown = config('constants.weight_exponential_updown_score');

        $p_pref = $formula->PostScore($impr, $ws_nonBP, $ww_nonBP, $ws_D, $ww_D, $ws_updown, $ww_updown);
        $this->assertEquals(2.979002625, $p_pref);
    }

    public function test_4(){
        $formula = new FormulaController();
        $impr = 40 ;
        $ws_nonBP = 0.999752870076627;
        $ww_nonBP = config('constants.weight_exponential_non_bp');
        $ws_D = 3.052668053;
        $ww_D = config('constants.weight_exponential_d');
        $ws_updown =  0.902546486814006;
        $ww_updown = config('constants.weight_exponential_updown_score');

        $p_pref = $formula->PostScore($impr, $ws_nonBP, $ww_nonBP, $ws_D, $ww_D, $ws_updown, $ww_updown);
        $this->assertEquals(3.01890371975409, $p_pref);
    }

    public function test_5(){
        $formula = new FormulaController();
        $impr = 200 ;
        $ws_nonBP = 1.00000199800106;
        $ww_nonBP = config('constants.weight_exponential_non_bp');
        $ws_D = 3.10097533;
        $ww_D = config('constants.weight_exponential_d');
        $ws_updown =  0.900489010011657;
        $ww_updown = config('constants.weight_exponential_updown_score');

        $p_pref = $formula->PostScore($impr, $ws_nonBP, $ww_nonBP, $ws_D, $ww_D, $ws_updown, $ww_updown);
        $this->assertEquals(1.34080213687754, $p_pref);
    }

    public function test_6(){
        $formula = new FormulaController();
        $impr = 700 ;
        $ws_nonBP = 1.00016822146342;
        $ww_nonBP = config('constants.weight_exponential_non_bp');
        $ws_D = 3.135095448;
        $ww_D = config('constants.weight_exponential_d');
        $ws_updown =  0.898705863474547;
        $ww_updown = config('constants.weight_exponential_updown_score');

        $p_pref = $formula->PostScore($impr, $ws_nonBP, $ww_nonBP, $ws_D, $ww_D, $ws_updown, $ww_updown);
        $this->assertEquals(1.34424579587913, $p_pref);
    }

    public function test_7(){
        $formula = new FormulaController();
        $impr = 90 ;
        $ws_nonBP = 1.00028702025872;
        $ww_nonBP = config('constants.weight_exponential_non_bp');
        $ws_D = 3.16047802;
        $ww_D = config('constants.weight_exponential_d');
        $ws_updown =  0.897145610220948;
        $ww_updown = config('constants.weight_exponential_updown_score');

        $p_pref = $formula->PostScore($impr, $ws_nonBP, $ww_nonBP, $ws_D, $ww_D, $ws_updown, $ww_updown);
        $this->assertEquals(1.34358383536482, $p_pref);
    }

    public function test_8(){
        $formula = new FormulaController();
        $impr = 0 ;
        $ws_nonBP = 1.00037615642321;
        $ww_nonBP = config('constants.weight_exponential_non_bp');
        $ws_D = 3.180098373;
        $ww_D = config('constants.weight_exponential_d');
        $ws_updown =  0.895768916233208;
        $ww_updown = config('constants.weight_exponential_updown_score');

        $p_pref = $formula->PostScore($impr, $ws_nonBP, $ww_nonBP, $ws_D, $ww_D, $ws_updown, $ww_updown);
        $this->assertEquals(1, $p_pref);
    }

    public function test_9(){
        $formula = new FormulaController();
        $impr = 10 ;
        $ws_nonBP = 1.00044550655697;
        $ww_nonBP = config('constants.weight_exponential_non_bp');
        $ws_D = 3.195718654;
        $ww_D = config('constants.weight_exponential_d');
        $ws_updown =  0.894545188171273;
        $ww_updown = config('constants.weight_exponential_updown_score');

        $p_pref = $formula->PostScore($impr, $ws_nonBP, $ww_nonBP, $ws_D, $ww_D, $ws_updown, $ww_updown);
        $this->assertEquals(3.26041772620744, $p_pref);
    }

    public function test_10(){
        $formula = new FormulaController();
        $impr = 1000 ;
        $ws_nonBP = 1.00050100050367;
        $ww_nonBP = config('constants.weight_exponential_non_bp');
        $ws_D = 3.208448967;
        $ww_D = config('constants.weight_exponential_d');
        $ws_updown =  0.893450273599598;
        $ww_updown = config('constants.weight_exponential_updown_score');

        $p_pref = $formula->PostScore($impr, $ws_nonBP, $ww_nonBP, $ws_D, $ww_D, $ws_updown, $ww_updown);
        $this->assertEquals(1.33243782306076, $p_pref);
    }

}
