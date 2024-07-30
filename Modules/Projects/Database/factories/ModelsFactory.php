<?php

use Faker\Generator as Faker;
use Modules\Projects\Entities\Project;

$factory->define(Project::class, function(Faker $faker){
    return [
		'name' => $faker->sentence(2)
    ];
});