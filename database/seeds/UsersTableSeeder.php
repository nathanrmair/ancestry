<?php

use Illuminate\Database\Seeder;
use Faker\Factory as Faker;
use App\User;
use App\Credits;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker::create();
        $password = '123123';

        if (DB::table('users')->where('email', 'provider@uni.com')->first() == null) {
            //create test provider
            DB::table('users')->insert([
                'email' => 'provider@uni.com',
                'password' => bcrypt($password),
                'confirmed' => 1,
                'type' => 'provider'
            ]);

        }

        //create test visitor
        if (DB::table('users')->where('email', 'visitor@uni.com')->first() == null) {
            DB::table('users')->insert([
                'email' => 'visitor@uni.com',
                'password' => bcrypt($password),
                'confirmed' => 1,
                'type' => 'visitor'
            ]);

        }

        //create test admin
        if (DB::table('users')->where('email', 'admin@uni.com')->first() == null) {
            DB::table('users')->insert([
                'email' => 'admin@uni.com',
                'password' => bcrypt($password),
                'confirmed' => 1,
                'type' => 'admin'
            ]);
        }

        foreach (range(1, 10) as $index) {
            $email = $faker->safeEmail;

            if (DB::table('users')->where('email', $email)->first() == null) {

                $type = (rand(0, 3) < '3') ? 'visitor' : 'provider';

                DB::table('users')->insert([
                    'email' => $email,
                    'password' => bcrypt($password),
                    'confirmed' => rand(0, 1),
                    'type' => $type
                ]);
            }
        }


        $users = User::get();

        foreach ($users as $user) {
            if ($user->confirmed == 1) {
                $credit = Credits::create([
                    'user_id' => $user->user_id,
                ]);
            }
        }
    }
}
