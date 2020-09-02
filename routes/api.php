<?php

use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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
Route::namespace('API')->group(function () {
    Route::middleware('auth:sanctum')->group(function () {
        Route::post('/update-info', 'UserController@updateInfo');

        Route::get('/cart-counter','CartController@counter');  //for cart counter at nav bar

        Route::get('/product-in-cart','CartController@index');
        Route::post('/add-to-cart/{variant}','CartController@addToCart');
        Route::post('/remove-from-cart/{variant}','CartController@removeFromCart');
        Route::put('/decrease-from-cart/{variant}','CartController@decreaseFormCart');
        Route::put('/increase-to-cart/{variant}','CartController@increaseToCart');
        Route::get('/cart/{variant}/get_current_quantity', 'CartController@getCurrentQuantityInCart');
    });

    Route::get('/products', 'ProductController@index');
    Route::get('search', 'ProductController@search');
    Route::get('products/{product}', 'ProductController@show');
    Route::get('/user', 'UserController@getUser');
    Route::get('categories', 'CategoryController@index');
    Route::get('categories/{slug}', 'CategoryController@getProducts');
    Route::get('products/{product}/variants', function ($id) {
        return Product::with('variants', 'categories')->whereId($id)->first();
    });
});




