<?php

use App\Http\Controllers\CreateTopicController;
use App\Http\Controllers\DomainController;
use App\Http\Controllers\ImageController;
use App\Http\Controllers\LimitTopicController;
use App\Http\Controllers\LogController;
use App\Http\Controllers\NewsController;
use App\Http\Controllers\PostBlockController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\RssLinkController;
use App\Http\Controllers\ShowPostListController;
use App\Http\Controllers\StatusHealthController;
use App\Http\Controllers\UsersAppController;
use App\Http\Controllers\ViewUserController;
use App\Http\Controllers\TopicController;
use App\Http\Controllers\UserCommentController;
use App\Http\Controllers\UserFollowController;
use Illuminate\Support\Facades\Auth;
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


Route::get('/status-health/live', [StatusHealthController::class, 'live']);

Route::group(['middleware' => 'auth'], function () {
    Route::delete('/post/comment/{commentId}', [PostController::class, 'deleteComment']);

    Route::get('/dashboard', "HomeController@index");
    /*
     *  topics
     */
    Route::get('/topics/index', [TopicController::class, 'index'])->name('topic');
    Route::put('/topics/category', [TopicController::class, 'changeCategory'])->name('topic.add.category');
    Route::delete('/topics/category', [TopicController::class, 'deleteCategory'])->name('topic.category.delete');
    Route::post('/topics/image', [TopicController::class, 'updateImage'])->name('topic.update-image');
    Route::get('/topics/detail', [TopicController::class, 'getDetail'])->name('topic.detail');

    Route::get('/create-topics', [CreateTopicController::class, 'index'])->name('topic.create');
    Route::POST('/topics/data', [TopicController::class, 'getData'])->name('masterTopics.data');
    Route::POST('/add/topics', [TopicController::class, 'addTopics'])->name('create.topics');
    Route::POST('/show/topics', [TopicController::class, 'showTopics'])->name('add.topics');
    Route::post('/topic/category', [TopicController::class, 'category'])->name('topic.category');
    Route::put('/topic', [TopicController::class, 'update'])->name('topic.update');
    Route::delete('/topic/{id}', [TopicController::class, 'delete'])->name('topic.delete');
    Route::get('/topic/limit', [LimitTopicController::class, 'getData'])->name('topic.limit');
    Route::post('/topic/limit', [LimitTopicController::class, 'create'])->name('topic.limit.create');
    Route::get('/topics/export/', [TopicController::class, 'export'])->name('topic.export');
    Route::post('topics/un-sign', [TopicController::class, 'unSignCategory'])->name('topic.category.un-sign');
    Route::post('topics/sign', [TopicController::class, 'signCategory'])->name('topic.category.sign');
    Route::post('/topic/remove-duplicate', [TopicController::class, 'removeDuplicate'])->name('topic.remove-duplicate');



    /*
     * Locations
     */
    Route::post('/locations/data', 'LocationsController@getData')->name('masterLocations.data');

    Route::post('/locations/add', 'LocationsController@addLocations')->name('masterLocations.add');

    Route::get('/locations/index', function () {
        $data = [
            'category_name' => 'locations',
            'page_name' => 'locations',
            'has_scrollspy' => 0,
            'scrollspy_offset' => '',

        ];
        return view('pages.locations.locations')->with($data);
    });

    Route::get('/create-locations', function () {
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
    Route::get('/view-users', [ViewUserController::class, 'index']);
    Route::POST('/users/data', [UsersAppController::class, 'getData'])->name('masterUsers.data');
    Route::GET('/download-csv', 'UsersAppController@downloadCsv')->name('download');


    /*
     *  Users Detail
     */
    Route::GET('/user-detail', 'UsersAppController@userDetail');
    Route::GET('/user-detail-view', [UsersAppController::class, 'userDetailView']);
    Route::POST('/users/banned/{id}',  [UsersAppController::class, 'bannedUser']);

    //User Follow Data Topic
    Route::get('/follow-topics', 'UserFollowController@index');

    Route::POST("/user/topic", "UserFollowController@getList");



    Route::GET("/user-follow-detail", [UserFollowController::class, 'userFollowDetail']);
    Route::POST("/user/follow/list", [UserFollowController::class, 'getUserFollowList']);

    Route::GET("/change-password", "HomeController@changePasswordIndex");

    Route::POST("/change-password", "Auth\ChangePasswordController@index")->name('change.password');

    Route::GET("/user-show-post-list", [ShowPostListController::class, 'index']);
    Route::POST("/user-show-post-list/data", [ShowPostListController::class, 'getData']);

    Route::GET("/sample-getstream", "SampleGetStream@index");

    Route::prefix('users')->group(function () {
        Route::post('/admin-block-user', [UsersAppController::class, 'blockUserByAdmin'])
            ->name('user.admin-block-user');
        Route::post('/admin-unblock-user', [UsersAppController::class, 'unBlockUserByAdmin'])
            ->name('user.admin-block-user');
        Route::get('/comments', [UserCommentController::class, 'index'])->name('user.comments');
        Route::post('/comments/data', [UserCommentController::class, 'getData'])->name('user.comments.data');
    });



    /*
    *Domain
    */
    Route::prefix('domain')->group(function () {
        Route::get('/index', [DomainController::class, 'index'])->name('domain');
        Route::POST(
            '/' . config('constants.DATA_KEYWORD'),
            [DomainController::class, 'getData']
        )->name('masterDomain.data');
        Route::GET('/form-logo', 'DomainController@formEdit');
        Route::POST('/add-logo', 'DomainController@saveLogo');
        Route::post('/update-status', 'DomainController@updateStatus');
    });

    Route::prefix('news')->group(function () {
        Route::get('/index', [NewsController::class, 'index'])->name('news');
        Route::POST(
            '/' . config('constants.DATA_KEYWORD'),
            'NewsController@getData'
        );
        // Remove this route as it is no longer needed
        Route::GET('/news-link', 'NewsController@readAsJson');
    });



    //Polling
    Route::get('/polling/index', function () {
        $data = [
            'category_name' => 'polling',
            'page_name' => 'polling-list',
            'has_scrollspy' => 0,
            'scrollspy_offset' => '',

        ];
        return view('pages.polling.polling')->with($data);
    });

    Route::POST('/polling/data', 'PollingController@getData');
    Route::GET('/polling/detail', 'PollingController@pollingDetail');

    // POST

    Route::post('/upload-image', [PostController::class, 'uploadImage'])->name('upload.image');

    Route::get('/post', [PostController::class, 'index'])->name('post');
    Route::post('/post/upload-csv', [PostController::class, 'upload'])->name('post.upload');
    Route::post('/post/download-template', [PostController::class, 'downloadTemplate'])->name('post.download-template');
    Route::post('/post/upvote', [PostController::class, 'upvote'])->name('post.upvote');
    Route::post('/post/downvote', [PostController::class, 'downvote'])->name('post.downvote');
    Route::post('/post/banned-user', [PostController::class, 'bannedUserByPost'])->name('post.banned-user');

    Route::prefix('post-blocks')->group(function () {
        Route::get('/', [PostBlockController::class, 'index'])->name('post-block');
        Route::post('/data', [PostBlockController::class, 'data'])->name('post-block.data');
    });
    Route::post('/post/hide/{id}', [PostController::class, 'postHide'])->name('post.hide');
    Route::delete('/post/comment/{id}', [PostController::class, 'deleteComment'])->name('post.comment.delete');

    /**
     * logs
     */
    Route::get('logs', [LogController::class, 'data'])->name('logs');

    Route::get('rss', [RssLinkController::class, 'data'])->name('rss');
    Route::post('rss', [RssLinkController::class, 'add'])->name('rss.add');
    Route::put('rss', [RssLinkController::class, 'edit'])->name('rss.edit');
    Route::delete('rss/{id}', [RssLinkController::class, 'remove'])->name('rss.remove');

    Route::get('/image', [ImageController::class, 'index'])->name('images');
    Route::post('/image/upload', [ImageController::class, 'uploadImage'])->name('images.upload');
    Route::post('/image/data', [ImageController::class, 'data'])->name('images.data');

    Route::post('user-name-by-anonymous-id', [UsersAppController::class, 'getNameByAnonymousId']);
});

Auth::routes();

Route::get('/', 'HomeController@index');


Route::get('/register', function () {
    return redirect('/login');
});
Route::get('/password/reset', function () {
    return redirect('/login');
});

Route::get('/', function () {
    return redirect('/dashboard');
});

Route::get('/forgot-password', function () {
    $data = [
        'category_name' => 'auth',
        'page_name' => 'auth_boxed',
        'has_scrollspy' => 0,
        'scrollspy_offset' => '',
    ];
    return view('auth.passwords.email')->with($data);
});





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
})->name('password.resett');

Route::post('/reset-password', 'ResetPasswordController@resetPassword')->name('reset.password.update');

Route::post('/impression1', 'FormulaController@BenchmarkPostImpression1');
