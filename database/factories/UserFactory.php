<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\User;
use Faker\Generator as Faker;
use Illuminate\Support\Str;

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
    $prefixnames = ['Mr', 'Mrs', 'Ms'];
    return [
        'prefixname' => $prefixnames[rand(0,2)],
        'firstname' => $faker->name(10),
        'middlename' => $faker->name(10),
        'lastname' => $faker->name(10),
        'suffixname' => Str::random(3),
        'username' => Str::random(10),
        'email' => Str::random(10).'@gmail.com',
        'password' => Hash::make('password'),
        'type' => 'user'
    ];
});
