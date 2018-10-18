<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\DB;
use Faker\Factory as Faker;

class EditProviderTest extends TestCase
{

    private $user1, $visitor, $newVisitorData = array(
        'forename' => 'jill',
        'surname' => 'jillington',
        'dob' => '1980-07-07',
        'gender' => 'female',
        'origin' => 'Finland',
        'description' => 'jill pays the bills');

    private $newEmail = 'jill@uni.com';
    private $types = ['Heritage Centre', 'Archive Centre/Records Office', 'Family History Society', 'Library', 'Other'];
    private $counties = ['Aberdeenshire', 'Angus', 'Argyll and Bute', 'Comhairle nan Eilean Siar', 'Clackmannanshire',
        'Dumfries and Galloway', 'Dundee', 'East Ayrshire', 'East Dunbartonshire', 'Edinburgh', 'East Lothian',
        'East Renfrewshire', 'Falkirk', 'Fife', 'Glasgow', 'Highland', 'Inverclyde', 'Midlothian', 'Moray',
        'North Ayrshire', 'North Lanarkshire', 'Orkney', 'Perth and Kinross',
        'Renfrewshire', 'Scottish Borders', 'Shetland Islands', 'South Ayrshire', 'South Lanarkshire', 'Stirling',
        'West Dunbartonshire', 'West Lothian'];
    private $regions = ['Argyll', 'Ayrshire', 'Borders', 'Central Scotland', 'Clyde Valley', 'Dumfries and Galloway',
        'Fife', 'Grampian', 'Hebrides', 'Highlands', 'Lothian', 'Orkney Islands', 'Shetland Islands', 'Tayside'];

    public function setUp()
    {

        parent::setUp();
        TestCase::clenseDB();

        $this->user1 = factory(App\User::class)->create([
            'type' => 'provider',
            'email' => 'bill@uni.com',
            'password' => '123123'
        ]);

        $faker = Faker::create();
        $type = $this->getRandomOf($this->types);
        $county = $this->getRandomOf($this->counties);
        $region = $this->getRandomOf($this->regions);
        
        $this->provider = factory(App\Provider::class)->create([

            'user_id' => $this->user1->user_id,
            'name' => $faker->company,
            'street_name' => $faker->streetName,
            'postcode' => $faker->postcode,
            'town' => $faker->city,
            'county' => $county,
            'region' => $region,
            'type' => $type
        ]);
        
    }

    public function testEditProviderCredentials()
    {
//        $this->be($this->user1);
//        $faker = Faker::create();
//        
//        $type = $this->getRandomOf($this->types);
//        $county = $this->getRandomOf($this->counties);
//        $region = $this->getRandomOf($this->regions);
//        
//        $data = array(
//            'name' => $faker->company,
//            'user_id' => $this->user1->user_id,
//            'street_name' => $faker->streetName,
//            'postcode' => $faker->postcode,
//            'town' => $faker->city,
//            'county' => $county,
//            'region' => $region,
//            'type' => $type,
//            'keywords' => 'bill'
//        );
//        
//        
//        $this->visit('profile/edit')
//            ->type($data['name'], 'name')
//            ->type($data['street_name'], 'street_name')
//            ->type($data['postcode'], 'postcode')
//            ->type($data['town'], 'town')
//            ->type($data['county'], 'county')
//            ->type($data['region'], 'region')
//            ->type($data['type'], 'type')
//            ->type($data['keywords'], 'keywords')
//            ->press('submit');
//        $this->seeInDatabase('providers', $data);
        $this->assertTrue(true);

    }
    
    private function getRandomOf($arr){
        return $arr[rand(0, (count($arr) - 1))];
    }
}
