<?php
use App\Shop\Taxes\TaxRates;

$factory->define(TaxRates::class, function (Faker\Generator $faker) {
    return [
        'state_code' => $faker->postcode,
        'rate_percentage' => $faker->randomDigit,
        'tax_name' => $faker->word,
        'description' => 'lorum ipsum dolor sit amet'
    ];
});
