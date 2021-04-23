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
    Route::get('/dashboard', "HomeController@index");
    /*
     *  topics
     */
    Route::get('/topics/index', function() {
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
    Route::POST('/show/topics', 'TopicsController@showTopics')->name('add.topics');



    /*
     * Locations
     */
    Route::post('/locations/data', 'LocationsController@getData')->name('masterLocations.data');

    Route::post('/locations/add', 'LocationsController@addLocations')->name('masterLocations.add');

    Route::get('/locations/index', function() {
        $data = [
            'category_name' => 'locations',
            'page_name' => 'locations',
            'has_scrollspy' => 0,
            'scrollspy_offset' => '',

        ];
        return view('pages.locations.locations')->with($data);
    });

    Route::get('/create-locations', function() {
        // $category_name = '';
        $data = [
            'category_name' => 'forms',
            'page_name' => 'create-locations',
            'has_scrollspy' => 1,
            'scrollspy_offset' => 100,

        ];
        return view('pages.locations.form_add_locations')->with($data);
    });
    Route::POST('/show/location', 'LocationsController@showLocation');




    /*
     * Users
     */
    Route::get('/view-users', function() {
        // $category_name = '';
        $data = [
            'category_name' => 'viewUsers',
            'page_name' => 'view Users',
            'has_scrollspy' => 0,
            'scrollspy_offset' => '',

        ];
        // $pageName = 'widgets';
        return view('pages.users.user')->with($data);
    });
    Route::POST('/users/data', 'UsersAppController@getData')->name('masterUsers.data');
    Route::GET('/download-csv', 'UsersAppController@downloadCsv')->name('download');


    /*
     *  Users Detail
     */
    Route::GET('/user-detail', 'UsersAppController@userDetail');
    Route::GET('/user-detail-view', 'UsersAppController@userDetailView');
    Route::POST('/update-status', 'UsersAppController@updateStatus');

    //User Follow Data Topic
    Route::get('/follow-topics','UserFollowController@index');
    
    // Route::POST("/topic-detail","UserFollowController@topicDetail");
    Route::POST("/user/topic","UserFollowController@getList");


   
    Route::GET("/user-follow-detail","UserFollowController@userFollowDetail");
    Route::POST("/user/follow/list","UserFollowController@getUserFollowList");
    
    Route::GET("/change-password","HomeController@changePasswordIndex");

    Route::POST("/change-password", "Auth\ChangePasswordController@index")->name('change.password');

    Route::GET("/user-show-post-list","ShowPostListController@index");
    Route::POST("/user-show-post-list/data","ShowPostListController@getData");

    Route::GET("/sample-getstream","SampleGetStream@index");



    /*
    *Domain
    */
    Route::get('/domain/index', function() {
        // $category_name = '';
        $data = [
            'category_name' => 'domain',
            'page_name' => 'domain list',
            'has_scrollspy' => 0,
            'scrollspy_offset' => '',

        ];
        // $pageName = 'widgets';
        return view('pages.domain.domain')->with($data);
    });


    Route::get('/news/index', function() {
        // $category_name = '';
        $data = [
            'category_name' => 'domain',
            'page_name' => 'news-link',
            'has_scrollspy' => 0,
            'scrollspy_offset' => '',

        ];
        // $pageName = 'widgets';
        return view('pages.news.news')->with($data);
    });

    Route::POST('/domain/data', 'DomainController@getData');
    Route::GET('/domain/form-logo', 'DomainController@formEdit');
    Route::POST('/domain/add-logo', 'DomainController@saveLogo');
    
    Route::GET('/news-link', 'NewsController@readAsJson');

    Route::POST('/news/data', 'NewsController@getData');


    //Polling
    Route::get('/polling/index', function() {
        // $category_name = '';
        $data = [
            'category_name' => 'polling',
            'page_name' => 'polling-list',
            'has_scrollspy' => 0,
            'scrollspy_offset' => '',

        ];
        // $pageName = 'widgets';
        return view('pages.polling.polling')->with($data);
    });

    Route::POST('/polling/data', 'PollingController@getData');
    Route::GET('/polling/detail', 'PollingController@pollingDetail');

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
    return redirect('/dashboard');
});

Route::get('/forgot-password', function() {
    // $category_name = 'auth';
    $data = [
        'category_name' => 'auth',
        'page_name' => 'auth_boxed',
        'has_scrollspy' => 0,
        'scrollspy_offset' => '',
    ];
    // $pageName = 'auth_boxed';
    return view('auth.passwords.email')->with($data);
});





//TODO hapus custom url reset-forget

Route::post('/forgot-password-email-verification', 'ResetPasswordController@index')->name('forgot.password.confirm');

Route::get('/reset-password/{token}', function ($token) {
    $data = [
        'category_name' => 'auth',
        'page_name' => 'auth_boxed',
        'has_scrollspy' => 0,
        'scrollspy_offset' => '',
        'token' => $token
    ];

    return view('auth.passwords.reset')->with($data);
//    return view('auth.passwords.reset', ['token' => $token], ['page_name' => 'test']);
})->name('password.reset');

Route::post('/reset-password', 'ResetPasswordController@resetPassword')->name('reset.password.update');

