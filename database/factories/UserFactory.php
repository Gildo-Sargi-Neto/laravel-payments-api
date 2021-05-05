<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use Faker\Factory;
use App\Models\User;
use App\Models\Wallet;
use Illuminate\Support\Str;
use Faker\Generator as Faker;

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| This directory should contain each of the model factory definitions for
| your application. Factories provide a convenient way to generate new
| model instances for testing / seeding your application's database.
|
*/

$factory->define(User::class, function (Faker $faker) {
    $fakerBr = Factory::create("pt_BR");
    return [
        'name' => $faker->name,
        'email' => $faker->unique()->safeEmail,
        'cpf' => $fakerBr->cpf,
        'type' => $faker->randomElement(['COMMON', 'SHOPKEEPER']),
        'password' => bcrypt(Str::random(20)),
    ];
});

$factory->afterMakingState(User::class, 'withWallet', function ($user, $faker) {
    $user->save();
    factory(Wallet::class)->create([
        'user_id' => $user->id
    ]);
});
