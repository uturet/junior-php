<?php

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| Here you may define all of your model factories. Model factories give
| you a convenient way to create models for testing and seeding your
| database. Just tell the factory how a default model should look.
|
*/

/** @var \Illuminate\Database\Eloquent\Factory $factory */
$factory->define(App\User::class, function (Faker\Generator $faker) {
    static $password;

    return [
        'name' => $faker->name,
        'email' => $faker->unique()->safeEmail,
        'password' => $password ?: $password = bcrypt('secret'),
        'remember_token' => str_random(60),
    ];
});

/** @var \Illuminate\Database\Eloquent\Factory $factory */
$factory->define(App\Employee::class, function (Faker\Generator $faker) {
    return [
        'name' => $faker->firstName,
        'last_name' => $faker->lastName,
        'patronymic' => $faker->firstName,
        'phone' => $faker->phoneNumber,
        'email' => $faker->email,
        'gender' => $faker->numberBetween(0, 1),
        'burn_date' => $faker->date($format = 'Y-m-d', $max = '-20 years'),
        'photo_url' => 'no_avatar.png',
    ];
});

/** @var \Illuminate\Database\Eloquent\Factory $factory */
$factory->define(App\Position::class, function (Faker\Generator $faker) {
    return [
        'name' => $faker->word,
        'description' => $faker->words(5, true),
    ];
});

/** @var \Illuminate\Database\Eloquent\Factory $factory */
$factory->define(App\Department::class, function (Faker\Generator $faker) {
    return [
        'name' => $faker->word,
        'description' => $faker->words(5, true),
    ];
});

/** @var \Illuminate\Database\Eloquent\Factory $factory */
$factory->define(App\Event::class, function (Faker\Generator $faker) {
    return [
        'description' => $faker->words(5, true),
        'employee_id' => $faker->numberBetween(1, 10),
    ];
});

/** @var \Illuminate\Database\Eloquent\Factory $factory */
$factory->define(App\Mediator::class, function (Faker\Generator $faker) {
    return [
        'employee_id' => $faker->numberBetween(1, 10),
        'position_id' => $faker->numberBetween(1, 10),
        'department_id' => $faker->numberBetween(1, 10),
        'recruitment_event_id' => $faker->numberBetween(1, 10),
        'wage' => $faker->numberBetween(1000, 5000),
    ];
});
