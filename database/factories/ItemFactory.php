<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Item;
use Faker\Generator as Faker;

$factory->define(Item::class, function (Faker $faker) {

    return [];
    /* return [
        'name' => $faker->colorName,
        'description' => $faker->sentence(),
        'image_url' => 'https://i.etsystatic.com/21615986/r/il/6b482e/2454194175/il_1588xN.2454194175_hhhe.jpg',
        'finished_at' => (new DateTime(date('Y-m-d H:i:s')))->add(new \DateInterval('P10D'))->format('Y-m-d H:i:s')
    ]; */
});
