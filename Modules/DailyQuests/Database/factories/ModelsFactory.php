<?php

use Faker\Generator as Faker;
use Modules\DailyQuests\Entities\DailyQuest;

$factory->define(DailyQuest::class, function(Faker $faker){
    return [
		'name' => $faker->sentence(2)
    ];
});