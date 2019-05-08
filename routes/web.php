<?php
use App\Notifications\NewFollower;
use App\User;

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
    return view('welcome');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::get('/u/{user}','ProfileController@index');

Route::get('/x',function(){

    $user=Auth::user();
    $user->notify(new NewFollower(User::findOrFail(2)));

});

Route::post('/follow','ProfileController@followOrUnfollow');

Route::post('/postMessage','HomeController@postMessage');

Route::post('/searchUser','HomeController@searchUser');