<?php

use Faker\Generator as Faker;
use App\ErpAccountsCategory;
use App\ErpAccountsClass;
use App\ErpChartOfAccounts;

$factory->define(ErpAccountsCategory::class, function (Faker $faker) {
    return [
        'category_name' => $faker->name,
        'active_status' => 1,
    ];
});
