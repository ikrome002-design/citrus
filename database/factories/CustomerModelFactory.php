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
use App\Shop\Customers\Customer;
use Carbon\Carbon;

$factory->define(Customer::class, function (Faker\Generator $faker) {
    static $password='$2y$10$6ELo3zxz3Owxj.srf2hdNe21jyeLho7LpN7VngCXSmsvXcHrtV4O.';
    static $country='99';
    return [
    	
    	'display_name' => $faker->firstName,
        'first_name' => $faker->firstName,
        'last_name' => $faker->lastName,
        'country' =>$country,
        'national_id' => '123457',
        'dob' => '11/02/2000',
        'phone_number' => $faker->mobileNumber,
        'email' => $faker->unique()->safeEmail,
        'password' => $password ?: $password = bcrypt('secret'),
        'remember_token' => str_random(10),
        'status' => 1,
        'email_verified_at'    => Carbon::now()
    ];
});
