<?php

use Faker\Generator as Faker;
use Modules\ReferralTransactions\Entities\ReferralTransaction;

$factory->define(ReferralTransaction::class, function(Faker $faker){
    return [
		'name' => $faker->sentence(2)
    ];
});