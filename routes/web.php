<?php
use Illuminate\Http\Request;

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

Route::get('/', function () {
    return view('welcome', [ 'olduri' => 'null' ]);
});

Route::get('/{olduri?}', function ($olduri = null) {
    return view('welcome', [ 'olduri' => urldecode($olduri) ]);
})->name('home');

Auth::routes();

Route::get('/home', 'HomeController@index')->name('homesite');

Route::get('/get/picture/{id}', ['uses' => 'Admin\PictureController@miniShow']);
Route::get('/get/picture/{id}/{resize}', ['uses' => 'Admin\PictureController@show']);
