<?php

use Illuminate\Database\Seeder;
use Faker\Factory as Faker;

class FAQsTableSeeder extends Seeder{

    /**
     * Run the database seeds.
     *
     * @return void
     */
    
    public function run()
    {
        $faker = Faker::create();
        for ($i = 0; $i < rand(5, 11); $i++) {
            DB::table('faqs')->insert([
                'question' => $faker->paragraph($nbSentences = 1, $variableNbSentences = true),
                'answer' => $faker->paragraph($nbSentences = 3, $variableNbSentences = true)
            ]);
        }
    }

}
