<?php

use Illuminate\Database\Seeder;
use Faker\Factory as Faker;

class ProvidersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker::create();
        $users = DB::table('users')->select('user_id')->where('type', 'provider')->where('confirmed', '1')->get();
        $types = ['Heritage Centre', 'Archive Centre/Records Office', 'Family History Society', 'Library', 'Other'];
        
        $counties = ['Aberdeenshire', 'Angus', 'Argyll and Bute', 'Comhairle nan Eilean Siar', 'Clackmannanshire',
        'Dumfries and Galloway', 'Dundee', 'East Ayrshire', 'East Dunbartonshire', 'Edinburgh', 'East Lothian',
        'East Renfrewshire', 'Falkirk', 'Fife', 'Glasgow', 'Highland', 'Inverclyde', 'Midlothian', 'Moray',
        'North Ayrshire', 'North Lanarkshire', 'Orkney', 'Perth and Kinross',
        'Renfrewshire', 'Scottish Borders', 'Shetland Islands', 'South Ayrshire', 'South Lanarkshire', 'Stirling',
        'West Dunbartonshire', 'West Lothian'];

        $regions = ['Argyll', 'Ayrshire', 'Borders', 'Central Scotland', 'Clyde Valley', 'Dumfries and Galloway',
        'Fife', 'Grampian', 'Hebrides', 'Highlands', 'Lothian', 'Orkney Islands', 'Shetland Islands', 'Tayside'];
        
        foreach ($users as $user) {
            if (DB::table('providers')->where('user_id', $user->user_id)->first() == null) {
                $type = $this->getRandomOf($types);
                $county = $this->getRandomOf($counties);
                $region = $this->getRandomOf($regions);

                DB::table('providers')->insert([
                    'name' => $faker->company,
                    'user_id' => $user->user_id,
                    'street_name' => $faker->streetName,
                    'postcode' => $faker->postcode,
                    'town' => $faker->city,
                    'county' => $county,
                    'region' => $region,
                    'type' => $type,
                    'description' => $faker->paragraph($nbSentences = 3, $variableNbSentences = true),
                    'created_at'=> Carbon\Carbon::parse($faker->time())
                ]);

            }
        }
    }

    private function getRandomOf($arr){
        return $arr[rand(0, (count($arr) - 1))];
    }
}
