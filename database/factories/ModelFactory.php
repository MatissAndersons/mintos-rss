<?php

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| Here you may define all of your model factories. Model factories give
| you a convenient way to create models for testing and seeding your
| database. Just tell the factory how a default model should look.
|
*/

use App\Models\User;
use Illuminate\Contracts\Hashing\Hasher;

/** @var Hasher $hasher */
$hasher = app()->make(Hasher::class);

$factory->define(User::class, function (Faker\Generator $faker) use ($hasher) {
    return [
        'email' => $faker->email,
        'password' => $hasher->make($faker->password)
    ];
});
