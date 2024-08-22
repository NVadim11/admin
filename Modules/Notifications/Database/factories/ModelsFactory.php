<?php

use Faker\Generator as Faker;
use Modules\Notifications\Entities\Notification;

$factory->define(Notification::class, function(Faker $faker){
    return [
		'name' => $faker->sentence(2)
    ];
});