<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Address;
use Faker\Generator as Faker;

$factory->define(Address::class, function (Faker $faker) {
    return [
        'user_id' => factory(\App\Models\User::class),
        'full_name' => $faker->word,
        'phone' => $faker->phoneNumber,
        'address' => $faker->word,
        'city' => $faker->city,
        'township' => $faker->word,
        'region' => $faker->word,
    ];
});
