<?php

use Faker\Generator as Faker;
use Modules\Core\Entities\User;

$factory->define(User::class, function (Faker $faker) {

    return [
        'name'        => $faker->firstName,
        'login'       => $faker->unique()->slug(1),
        'avatar'      => $faker->imageUrl(),
        'email'       => $faker->unique()->safeEmail,
        'password'    => bcrypt('secret')
    ];
});

$factory->state(User::class, 'manager', function (){
    return [
        'full_access' => 1
    ];
});
