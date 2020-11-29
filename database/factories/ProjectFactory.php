<?php

use Faker\Generator as Faker;
use Illuminate\Support\Str;
use App\ErpClient;
use App\ErpProject;

$factory->define(ErpClient::class, function (Faker $faker) {
    return [
        'client_name' => $faker->name,
        'client_phone_1' => $faker->phoneNumber,
        'email' => $faker->unique()->safeEmail,
        'ministry' => $faker->name,
        'website' => 'www.'.Str::random(8).'.com',
        'client_remarks' => $faker->text(50),
        'active_status' => 1,
        'created_by' => 1,
        'created_at' => now(),
    ];
});

$factory->define(ErpProject::class, function (Faker $faker) {
    return [
        'project_name' => $faker->name,
        'project_type' => 0,
        'project_start_date' => $faker->date(),
        'project_due_date' => $faker->date(),
        'project_lead' => 1,
        'client_id' => 1,
        'priority' => 1,
        'project_status' => 'new',
        'project_code' => "LG 1225",
        'project_phase' => 1,
        'description' => $faker->text(50),
        'active_status' => 1,
        'created_by' => 1,
        'created_at' => now(),
    ];
});
