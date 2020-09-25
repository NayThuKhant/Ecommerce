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
Route::get('/login/github','Auth\LoginController@loginWithGithub');
Route::get('/login/github/redirect','Auth\LoginController@handleLoginWithGithub');

Route::post('logout', 'Auth\LoginController@logout')->name('logout');
Route::post('/login-firebase', 'Auth\LoginController@firebaseLogin');

Route::get('/{any?}', function () {
    return view('main-spa');
})->where('any', '.*')->middleware('more_info_needed');
//

//
//Route::get('/home', 'HomeController@index')->name('home');

