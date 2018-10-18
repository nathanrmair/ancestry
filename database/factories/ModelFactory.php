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

$factory->define(App\User::class, function (Faker\Generator $faker) {
    return [
        'user_id' => (int)rand(1, 10000),
        'email' => $faker->safeEmail,
        'password' => bcrypt(str_random(10)),
        'remember_token' => str_random(10),
        'confirmed' => 1,
        'confirmation_code' => null,
        'type' => 'provider'
    ];
});

$factory->define(App\Credits::class, function (Faker\Generator $faker) {
    return [
        'credit_id' => (int)rand(1, 10000),
        'credits' => (int)rand(100,200),
        'cost' => 10,
        'user_id' => 1
    ];
});

$factory->define(App\Visitor::class, function (Faker\Generator $faker) {
    return [
        'visitor_id' => (int)rand(1, 10000),
        'user_id' => 0,
        'forename' => $faker->name,
        'surname' => $faker->name,
        'member' => 0,
        //'dob' => $faker->date($format = 'Y-m-d', $max = 'now'),
        'dob' => $faker->date($format = 'd-m-Y', $max = 'now'),
        'gender' => 'male',
        'origin' => $faker->state,
        'description' => $faker->paragraph($nbSentences = 3, $variableNbSentences = true)
    ];
});

$factory->define(App\Provider::class, function (Faker\Generator $faker) {
    return [
        'provider_id' => (int)rand(1, 10000),
        'user_id' => 0,
        'name' => $faker->name,
        'street_name' => $faker->streetAddress,
        'town' => $faker->city,
        'county' => $faker->state,
        'region' => $faker->state,
        'postcode' => $faker->postcode,
        'type' => 'museum',
        'description' => $faker->paragraph($nbSentences = 3, $variableNbSentences = true),
        'historic_county' => $faker->state,
        'open_hour' => $faker->text($maxNbChars = 10),
        'close_hour' => $faker->text($maxNbChars = 10),
        'prices' => $faker->text($maxNbChars = 100),
        'keywords' => 'some,text,here'
    ];
});

$factory->define(App\Conversations::class, function (Faker\Generator $faker) {
    return [
        'conversation_id' => (int)rand(1, 10000),
        'provider_id' => 0,
        'visitor_id' => 0,
        'date_started' => $faker->date($format = 'Y-m-d', $max = 'now')
    ];
});

$factory->define(App\Messages::class, function (Faker\Generator $faker) {
    return [
        'message_id' => (int)rand(1, 10000),
        'provider_id' => (int)rand(1, 10000),
        'visitor_id' => (int)rand(1, 10000),
        'message' => $faker->paragraph($nbSentences = 3),
        'time' => $faker->dateTime($max = 'now', $timezone = date_default_timezone_get()),
        'read' => 'no',
        'attachments' => null,
        'conversation_id' => 0,
        'who' => 'provider'
    ];
});

$factory->define(App\Ancestor::class, function (Faker\Generator $faker) {
    $dod= $faker->date($format = 'd-m-Y', $max = 'now');
    return [
        //'visitor_id' => 0,
        'ancestor_id' => (int)rand(1, 10000),
        'forename' => $faker->firstName,
        'surname' => $faker->lastName,
        'dob' => $faker->date($format = 'd-m-Y', $max = $dod),
        'dod' => $dod,
        'gender' => (rand(0, 1) == '0') ? 'male' : 'female',
        'place_of_birth' => $faker->city,
        'place_of_death' => $faker->city
    ];
});

$factory->define(App\FAQ::class, function (Faker\Generator $faker) {
    return [
        'question_id' => (int)rand(1, 10000),
        'question' => $faker->paragraph($nbSentences = 1, $variableNbSentences = true),
        'answer' => $faker->paragraph($nbSentences = 3, $variableNbSentences = true)
    ];
});

$factory->define(\App\OfferedSearches::class, function(Faker\Generator $faker){
    return [
        'conversation_id' => (int)rand(1, 10000),
        'status' => 'pending',
        'message' => $faker->paragraph($nbSentences = 1, $variableNbSentences = true),
        'price' => 20,
        'result_message' => $faker->paragraph($nbSentences = 3, $variableNbSentences = true),
        'completion_date' => $faker->date($format = 'Y-m-d')
    ];
});