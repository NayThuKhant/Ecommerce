<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Cancellation;
use Faker\Generator as Faker;

$factory->define(Cancellation::class, function (Faker $faker) {
    return [
        'order_id' => factory(\App\Models\Order::class),
        'cancelled_at' => $faker->dateTime(),
        'reason' => $faker->word,
    ];
});
