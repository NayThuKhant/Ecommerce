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
Route::get('/user',function() {
    return Auth::user();
});
Route::get('/login/{provider}','Auth\LoginController@loginWithProvider');
Route::get('/login/{provider}/handler','Auth\LoginController@handleLoginWithProvider');

Route::post('logout', 'Auth\LoginController@logout')->name('logout');
Route::post('/login-firebase', 'Auth\LoginController@firebaseLogin');

Route::get('/{any?}', function () {
    return view('main-spa');
})->where('any', '.*')->middleware('more_info_needed');
//

//
//Route::get('/home', 'HomeController@index')->name('home');

