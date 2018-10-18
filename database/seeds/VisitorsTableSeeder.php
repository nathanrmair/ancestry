<?php

use Illuminate\Database\Seeder;
use Faker\Factory as Faker;

class VisitorsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker::create();
        $users = DB::table('users')->select('user_id')->where('type', 'visitor')->where('confirmed', '1')->get();
        foreach ($users as $user) {

            if (DB::table('visitors')->where('user_id',$user->user_id)->first()==null) {
                $gender = (rand(0, 1) == '0') ? 'male' : 'female';
                DB::table('visitors')->insert([
                    'forename' => $faker->firstName,
                    'surname' => $faker->lastName,
                    'user_id' => $user->user_id,
                    'member' => 1,
                    'dob' => $faker->date($format = 'Y-m-d', $max = 'now'),
                    'gender' => $gender,
                    'origin' => $faker->city,
                    'description' => $faker->paragraph($nbSentences = 3, $variableNbSentences = true)
                ]);

            }
        }

    }
}
