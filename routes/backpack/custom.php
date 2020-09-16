<?php

// --------------------------
// Custom Backpack Routes
// --------------------------
// This route file is loaded automatically by Backpack\Base.
// Routes you generate using Backpack\Generators will be placed here.

use Illuminate\Support\Facades\Route;

Route::group([
    'prefix'     => config('backpack.base.route_prefix', 'admin'),
    'middleware' => [
        config('backpack.base.web_middleware', 'web'),
        config('backpack.base.middleware_key', 'admin'),
    ],
    'namespace'  => 'App\Http\Controllers\Admin',
], function () { // custom admin routes

    Route::crud('product', 'ProductCrudController');
    Route::crud('category', 'CategoryCrudController');
    Route::crud('voucher', 'VoucherCrudController');
    Route::post('orders/{order}/confirm','AdminOrderController@confirmOrder')->name('confirm-order');
    Route::post('orders/{order}/proceed','AdminOrderController@proceedOrder')->name('proceed-order');
    Route::post('orders/{order}/ship','AdminOrderController@shipOrder')->name('ship-order');
    Route::post('orders/{order}/deliver','AdminOrderController@deliverOrder')->name('deliver-order');
    Route::crud('order', 'OrderCrudController');
}); // this should be the absolute last line of this file
