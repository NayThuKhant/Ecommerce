<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Stock;
use Faker\Generator as Faker;

$factory->define(Stock::class, function (Faker $faker) {
    return [
        'product_id' => factory(\App\Models\Product::class),
        'variant_id' => factory(\App\Models\Variant::class),
        'quantity' => $faker->randomNumber(),
        'is_available' => $faker->boolean,
        'sale_price' => $faker->randomFloat(0, 0, 9999999999.),
        'special_price' => $faker->randomFloat(0, 0, 9999999999.),
        'shipping_fee_multiplier' => $faker->randomFloat(0, 0, 9999999999.),
    ];
});
