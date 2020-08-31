<?php

use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});
Route::get('/products', 'API\ProductController@index');
Route::get('/user', function () {
    if (Auth::check()) {
        return Auth::user();
    }
    return null;
});

Route::get('categories',function (){
    return Category::all();
});
Route::get('categories/{slug}', function ($slug) {
    return Category::with('products')->whereSlug($slug)->first();
});

Route::get('products/{product}/variants',function ($id){
    return Product::with('variants','categories')->whereId($id)->first();
});

Route::get('search', function (Request $request) {
    $keyword = $request->q;
    $products = Product::select('name', 'id')->where('name', 'LIKE', "%{$keyword}%")->limit(10)->get()->makeHidden('min_price');
    return $products;
});
Route::get('products/{product}', function (Product $product) {
    return $product->load('variants');
});

Route::middleware('auth:sanctum')->group(function() {

});

