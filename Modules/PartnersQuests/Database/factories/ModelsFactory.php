<?php

use Faker\Generator as Faker;
use Modules\PartnersQuests\Entities\PartnersQuest;

$factory->define(PartnersQuest::class, function(Faker $faker){
    return [
		'name' => $faker->sentence(2)
    ];
});