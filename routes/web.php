<?php

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

//image display
Route::get('image/{filename}', 'PostController@displayImage')->name('image.displayImage');

Route::group(['middleware' => ['web']], function() {
    Route::get('store/s/{filename}', function ($filename) {
        return Image::make(storage_path() . '/images/' . $filename)->response();
    });
});

//Route::get('/','FormController@index');
Route::post('upload','FormController@store');

//Login larqavel with google account
Route::get('google', function () {
    return view('googleAuth');
});
Route::get('auth/google', 'Auth\LoginController@redirectToGoogle');
Route::get('auth/google/callback', 'Auth\LoginController@handleGoogleCallback');



//logout laravel in other devices
Route::get('logoutOthers',function () {

    auth()->logoutOtherDevices('password');

    return redirect ('/');
});

//Email verification

Auth::routes();
Route::get('/', function () {
    if (Auth::check()) {
        return Redirect::route('dashboard');
    }
});

Route::group(['middleware' => ['authorize', 'auth']], function () {
    Route::get('/dashboard', [
        'name' => 'Dashboard',
        'as' => 'dashboard',
        'uses' => 'HomeController@dashboard',
    ]);
});
Route::group(['middleware' => ['auth']], function () {
    Route::get('/authorize/{token}', [
        'name' => 'Authorize Login',
        'as' => 'authorize.device',
        'uses' => 'Auth\AuthorizeController@verify',
    ]);
    Route::post('/authorize/resend', [
        'name' => 'Authorize',
        'as' => 'authorize.resend',
        'uses' => 'Auth\AuthorizeController@resend',
    ]);
});


