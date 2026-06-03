<?php

use App\Shop\Vendors\Vendor;

$factory->define(Vendor::class, function (Faker\Generator $faker) {
    static $password='$2y$10$6ELo3zxz3Owxj.srf2hdNe21jyeLho7LpN7VngCXSmsvXcHrtV4O.';
	return [
        'first_name' => $faker->name,
        'last_name' => $faker->name,
        'email' => $faker->unique()->safeEmail,
        'phone_number' => $faker->phoneNumber,
        'password' => $password ?: $password = bcrypt('secret'),
        'business_location' => $faker->streetAddress,
        'short_description' => $faker->paragraph,
        'remember_token' => str_random(10),
        'status' => 1
       
    ];
});
