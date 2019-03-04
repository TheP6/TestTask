<?php

use App\User;
use Illuminate\Support\Str;
use Faker\Generator as Faker;

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

$factory->define(\Domain\Frameworks\Laravel\Data\ActiveRecords\Book::class, function (Faker $faker) {
    return [
        'uuid' => $faker->uuid,
        'title' => $faker->word,

        'publisherUuid' => function () {
            return factory(
                \Domain\Frameworks\Laravel\Data\ActiveRecords\Publisher::class
            )->create()->uuid;
        },
        'authorUuid' => function () {
            return factory(
                \Domain\Frameworks\Laravel\Data\ActiveRecords\Author::class
            )->create()->uuid;
        },
        'genreUuid' => function () {
            return factory(
                \Domain\Frameworks\Laravel\Data\ActiveRecords\Genre::class
            )->create()->uuid;
        },

        'firstPublished' => $faker->year,
        'wordCount' => $faker->randomFloat(0, 1, 1000000),
        'averagePrice' => $faker->randomFloat(2, 0.1, 100),
    ];
});
