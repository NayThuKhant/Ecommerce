<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Item;
use Faker\Generator as Faker;

$factory->define(Item::class, function (Faker $faker) {
    return [
        'order_id' => factory(\App\Models\Order::class),
        'product_id' => factory(\App\Models\Product::class),
        'variant_id' => factory(\App\Models\Variant::class),
        'quantity' => $faker->randomNumber(),
    ];
});
