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
use App\Shop\FeatureSetting\FeatureSetting;
use Illuminate\Http\UploadedFile;

$factory->define(FeatureSetting::class, function (Faker\Generator $faker) {

    return [
        'title' => $faker->word,
        'subtitle' =>$faker->word,
        'order' => 1,
        'button_link' => 'javascript:void(0)',
        'button_text' => 'Shop Now',
        'status' => 1

    ];
});
