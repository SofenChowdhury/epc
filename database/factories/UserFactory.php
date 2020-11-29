<?php

use Faker\Generator as Faker;
use Illuminate\Support\Str;

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| This directory should contain each of the model factory definitions for
| your application. Factories provide a convenient way to generate new
| model instances for testing / seeding your application's database.
|
*/

$factory->define(App\User::class, function (Faker $faker) {
    return [
        'name' => $faker->name,
        'email' => $faker->unique()->safeEmail,
        'email_verified_at' => now(),
        'password' => '$2y$10$TKh8H1.PfQx37YgCzwiKb.KjNyWgaHb9cbcoQgdIVFlYg7B77UdFm', // secret
        'remember_token' => Str::random(10),
    ];
});

$factory->define(App\ErpEmployee::class, function (Faker $faker) {
    return [
        'first_name' => $faker->firstName,
        'last_name' => $faker->lastName,
        'email' => $faker->unique()->safeEmail,
        'mobile' => $faker->phoneNumber,
        'date_of_birth' => $faker->date(),
        'joining_date' => $faker->date(),
        'permanent_address' => $faker->address,
        'place_of_birth' => $faker->address,
        'nid' => $faker->randomNumber(6),
        'tin' => $faker->randomNumber(6),
        'employee_type' => 1,
        'employee_category_id' => 1,
        'department_id' => 1,
        'designation_id' => 1,
        'gender_id' => 2,
        'blood_group_id' => 1,
        'active_status' => 1,
        'created_by' => 1,
        'created_at' => now(),
    ];
});

$factory->define(App\ErpEmployeeBank::class, function (Faker $faker) {
    return [
        'bank_name' => $faker->firstName,
        'bank_address' => $faker->address,
        'account_number' => $faker->randomNumber(6),
        'routing_no' => $faker->randomNumber(6),
        'created_by' => 1,
        'created_at' => now(),
    ];
});
$factory->define(App\ErpEmployeeFamily::class, function (Faker $faker) {
    return [
        'father_name' => $faker->name('male'),
        'mother_name' => $faker->name('female'),
        'marital_status' => 0,
        'epc_before' => 0,
        'relative' => 0,
        'created_by' => 1,
        'created_at' => now(),
    ];
});
$factory->define(App\ErpEmployeeSalary::class, function (Faker $faker) {
    return [
        'basic' => 10000,
        'created_by' => 1,
        'created_at' => now(),
    ];
});

