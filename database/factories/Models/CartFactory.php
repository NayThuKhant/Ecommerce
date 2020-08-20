<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Cart;
use Faker\Generator as Faker;

$factory->define(Cart::class, function (Faker $faker) {
    return [
        'user_id' => factory(\App\Models\User::class),
        'product_id' => factory(\App\Models\Product::class),
        'variant_id' => factory(\App\Models\Variant::class),
        'quantity' => $faker->randomNumber(),
    ];
});
