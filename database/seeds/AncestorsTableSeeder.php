<?php

use Illuminate\Database\Seeder;
use Faker\Factory as Faker;
use Carbon\Carbon;

class AncestorsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    private $faker;

    public function run()
    {
        $this->faker = Faker::create();
        $visitors = DB::table('visitors')->select('visitor_id')->get();

        foreach ($visitors as $visitor) {
            $count = 0;
            while (rand(0, 1) == '0' && $count<4){
                    $this->generateAncestor($visitor->visitor_id);

                $count++;
            }
        }

        $this->generateAncestor(2);

        
    }

    private function generateAncestor($id){
        $faker = $this->faker;
        $dod = $faker->date($format = 'Y-m-d', $max = 'now');
        $gender = (rand(0, 1) == '0') ? 'male' : 'female';

        DB::table('ancestors')->insert([
            'forename' => $faker->firstName,
            'surname' => $faker->lastName,
            'visitor_id' => $id,
            'dob' => $faker->date($format = 'Y-m-d', $max = $dod),
            'dod' => $dod,
            'gender' => $gender,
            'place_of_birth' => $faker->city,
            'place_of_death' => $faker->city]);

    }
}
