<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('/register', [
    'uses'  => 'Auth\RegisterController@register',
]);
Route::post('/signin', [
    'uses'  => 'Auth\LoginController@signin',
]);
Route::get('/user', [
    'uses'  => 'UserController@index'
])->middleware('jwt.auth');


// Visitor
Route::get('/visitor/{page}/articles', [
    'uses' => 'Visitor\ArticleController@index',
])->where(['page' => '[0-9]+']);
Route::get('/visitor/menu', ['uses' => 'Visitor\MenuController@index']);
Route::get('/visitor/menu/{category}/{page}', ['uses' => 'Visitor\MenuController@show']);
Route::get('/visitor/menu/picture/{name}', ['uses' => 'Visitor\MenuController@image']);
Route::get('/visitor/menu/background', ['uses' => 'Visitor\MenuController@background']);
Route::get('/visitor/menu/logo', ['uses' => 'Visitor\MenuController@logo']);

Route::get('/get/picture/{id}', ['uses' => 'Admin\PictureController@show'])->middleware('throttle:1024,1');
Route::get('visitor/courses', ['uses' => 'Visitor\CourseController@index']);
Route::post('visitor/contact', ['uses' => 'Visitor\ContactController@sendMail']);
Route::get('visitor/judoevent', ['uses' => 'Visitor\JudoEventController@index']);
Route::get('visitor/carousel', [ 'uses' => 'Visitor\ArticleController@carousel' ]);

// Admin
//Route::group(['middleware' => ['jwt.auth', 'can:is-admin']], function () {
Route::group(['middleware' => ['jwt.auth']], function () {
    // Categories
    Route::resource('category', 'Admin\CategoryController');

    // Articles
    Route::resource('article', 'Admin\ArticleController');

    // Albums
    Route::resource('album', 'Admin\AlbumController');

    // Pictures
    Route::put('picture/add', [ 'uses' => 'Admin\PictureController@store']);
    Route::get('picture/{picture}/sync/album/{album}', [ 'uses' => 'Admin\AlbumController@syncPicture' ]);
    Route::resource('picture', 'Admin\PictureController');

    // Seasons
    Route::resource('season', 'Admin\SeasonController');
    Route::get('seasons/list', [ 'uses' => 'Admin\SeasonController@getList' ] );

    // Events
    Route::resource('judoevent', 'Admin\JudoeventController');

    // Users
    Route::resource('admin/user', 'Admin\UserController');
    Route::put('user/{user}/toggle/admin', 'Admin\UserController@toggleAdmin');
    Route::put('user/{user}/toggle/teacher', 'Admin\UserController@toggleTeacher');
    Route::put('user/{user}/toggle/debug', 'Admin\UserController@toggleDebug');

    // Courses
    Route::resource('course', 'Admin\CourseController');

    // Results
    Route::resource('result', 'Admin\ResultatController');

    // Age Categories
    Route::resource('age_category', 'Admin\AgeCategoryController');

    
    // Inscriptions
    Route::get('/inscriptions', 'Admin\MemberInscriptionController@index');
    Route::post('/inscriptions/load', 'Admin\MemberInscriptionController@load');
    Route::post('/inscriptions/save', 'Admin\MemberInscriptionController@save');
});
