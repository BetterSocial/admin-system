<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// Route::get('/', function () {
//     return view('welcome');
// });


Route::group(['middleware' => 'auth'] , function() {

    // $this->middleware

    Route::get('/analytics', function() {
        // $category_name = '';
        $data = [
            'category_name' => 'dashboard',
            'page_name' => 'analytics',
            'has_scrollspy' => 0,
            'scrollspy_offset' => '',
        ];
        // $pageName = 'analytics';
        return view('dashboard2')->with($data);
    });

    Route::get('/sales', function() {
        // $category_name = '';
        $data = [
            'category_name' => 'dashboard',
            'page_name' => 'sales',
            'has_scrollspy' => 0,
            'scrollspy_offset' => '',
        ];
        // $pageName = 'sales';
        return view('dashboard')->with($data);
    });
    
    Route::get('/topics-index', function() {
        \Log::debug("MSMASMASMASMA");
        $data = [
            'category_name' => 'topics',
            'page_name' => 'topics',
            'has_scrollspy' => 0,
            'scrollspy_offset' => '',

        ];
        return view('pages.topic.topics')->with($data);
    });

    Route::get('/create-topics', function() {
        // $category_name = '';
        $data = [
            'category_name' => 'forms',
            'page_name' => 'create-topics',
            'has_scrollspy' => 1,
            'scrollspy_offset' => 100,

        ];
        // $pageName = 'bootstrap_basic';
        return view('pages.topic.form_add_topics')->with($data);
    });
    Route::POST('/topics/data', 'TopicsController@getData')->name('masterTopics.data');
    Route::POST('/add/topics', 'TopicsController@addTopics')->name('add.topics');
    
    // Locations
    Route::POST('/locations/data', 'LocationsController@getData')->name('masterLocations.data');

    Route::get('/locations', function() {
        // $category_name = '';
        $data = [
            'category_name' => 'locations',
            'page_name' => 'locations',
            'has_scrollspy' => 0,
            'scrollspy_offset' => '',

        ];
        // $pageName = 'widgets';
        return view('pages.locations.locations')->with($data);
    });
});

Auth::routes();

Route::get('/', 'HomeController@index');


Route::get('/register', function() {
    return redirect('/login');
});
Route::get('/password/reset', function() {
    return redirect('/login');
});

Route::get('/', function() {
    return redirect('/sales');
});


