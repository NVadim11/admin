<?php

use Faker\Generator as Faker;
use Modules\Accounts\Entities\Account;

$factory->define(Account::class, function(Faker $faker){
    return [
		'name' => $faker->sentence(2)
    ];
});