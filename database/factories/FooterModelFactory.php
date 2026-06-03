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
use App\Shop\Footer\Footer;
use Illuminate\Http\UploadedFile;

$factory->define(Footer::class, function (Faker\Generator $faker) {
		return [
    	'type'=>0,
        'title' => $faker->word,
        'link' => 'javascript:void(0)'
        

    ];
});
