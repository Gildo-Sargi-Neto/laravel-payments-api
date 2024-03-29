<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\User;
use App\Models\Wallet;
use Faker\Generator as Faker;

$factory->define(Wallet::class, function (Faker $faker) {
    return [
        'user_id' => factory(User::class)->create()->id,
        'balance' => 1000,
    ];
});
