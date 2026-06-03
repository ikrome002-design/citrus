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
use App\Shop\BannerSetting\BannerSetting;
use Illuminate\Http\UploadedFile;

$factory->define(BannerSetting::class, function (Faker\Generator $faker) {
    $file = UploadedFile::fake()->image('category.png', 600, 600);

    return [
       
        'title' => 'Summer Sale',
        'subtitle' => 'Get up to 60% off',
        'option' => 0,
        'description' => $faker->text,
        'button_link' => 'javascript:void(0)',
        'button_text' => 'Shop Now',
        'option' => $this->faker->numberBetween(1, 2),
        'status' => 1

    ];
});
