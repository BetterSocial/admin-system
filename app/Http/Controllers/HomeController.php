<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Topics;
use App\Models\UserApps;
use App\Models\Locations;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $totalTopic = Topics::count();
        $totalUser = UserApps::count();
        $totalLocation = Locations::count();
        \Log::debug($totalTopic);
        \Log::debug($totalUser);
        \Log::debug($totalLocation);
        return view('dashboard',[
            'category_name' => 'dashboard',
            'page_name' => 'dashboard',
            'has_scrollspy' => 0,
            'scrollspy_offset' => '',
            'total_topic' =>$totalTopic,
            'total_user' =>$totalUser,
            'total_location' =>$totalLocation,
        ]);
    }

    public function changePasswordIndex(){
        return view('auth.passwords.change_password', [
            'category_name' => 'auth',
            'page_name' => 'Change Password',
            'has_scrollspy' => 0,
            'scrollspy_offset' => '',
        ]);
    }
}
