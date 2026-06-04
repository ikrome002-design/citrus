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
use App\Shop\Products\Product;
use App\Shop\Vendors\Vendor;
use Illuminate\Http\UploadedFile;

$factory->define(Product::class, function (Faker\Generator $faker) {
    $name = $faker->unique()->words(3, true);

    return [
        'sku' => $faker->unique()->bothify('SKU-####'),
        'name' => $name,
        'slug' => str_slug($name),
        'description' => $faker->paragraph,
        'short_description' => $faker->sentence,
        'cover' => null,
        'quantity' => $faker->numberBetween(1, 100),
        'price' => $faker->randomFloat(2, 1, 1000),
        'status' => 1,
        'tax' => 0,
        'tax_id' => 1
    ];
});
