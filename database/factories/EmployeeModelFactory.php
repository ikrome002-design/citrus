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

/** @var \Illuminate\Database\Eloquent\Factory $factory */
use App\Shop\Employees\Employee;

$factory->define(Employee::class, function (Faker\Generator $faker) {
    static $password='$2y$10$6ELo3zxz3Owxj.srf2hdNe21jyeLho7LpN7VngCXSmsvXcHrtV4O.';
    return [
        'name' => $faker->firstName,
        'email' => $faker->unique()->safeEmail,
        'password' => $password ?: $password = bcrypt('secret'),
        'remember_token' => str_random(10),
        'status' => 1,
        'phone' => 1234567890,
        'bio' => 'Lorum ipsum dolor sit amet, lorum ipsum dolor sit amet, Lorum ipsum dolor sit amet'
    ];
});
