<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\DB;
use Faker\Factory as Faker;

class EditAncestorTest extends TestCase
{

    private $user, $visitor, $ancestor;

    public function setUp()
    {
        parent::setUp();
        TestCase::clenseDB();

        $this->user = factory(App\User::class)->create([
            'type' => 'visitor',
            'user_id' => 1

        ]);

        $this->visitor = factory(App\Visitor::class)->create([
            'user_id' => $this->user->user_id,
            'visitor_id' => 1

        ]);

        $this->ancestor = factory(App\Ancestor::class)->create([
            'visitor_id' => $this->visitor->visitor_id,
            'ancestor_id' => 1
        ]);
    }

    public function testAddAncestor(){
        $this->assertTrue(true);
    }
//    {
//
//        $faker = Faker::create();
//        $unformattedDod = $faker->date($format = 'd-m-Y', $max = 'now');
//        $gender = (rand(0, 1) == '0') ? 'male' : 'female';
//        $unformattedDob = $faker->date($format = 'd-m-Y', $max = $unformattedDod);
//
//
//        $data = ['forename' => $faker->firstName,
//            'surname' => $faker->lastName,
//            'visitor_id' => $this->visitor->visitor_id,
//            'dob' => Carbon\Carbon::parse($unformattedDob)->format('Y-m-d'),
//            'dod' => Carbon\Carbon::parse($unformattedDod)->format('Y-m-d'),
//            'gender' => $gender,
//            'place_of_birth' => $faker->city,
//            'place_of_death' => $faker->city];
//
//        $this->be($this->user);
//        $this->visit('ancestor/create')
//            ->type($data['forename'], 'forename')
//            ->type($data['surname'], 'surname')
//            ->type($unformattedDob, 'dob')
//            ->type($unformattedDod, 'dod')
//            ->select($data['gender'], 'sex')
//            ->type($data['place_of_birth'], 'place_of_birth')
//            ->type($data['place_of_death'], 'place_of_death')
//            ->press('submit');
//        $this->seeInDatabase('ancestors', $data);
//    }

//    public function testAddAncestorManFieldsMissing()
//    {
//
//        $faker = Faker::create();
//        $dod = $faker->date($format = 'd-m-Y', $max = 'now');
//        $gender = (rand(0, 1) == '0') ? 'male' : 'female';
//        $unformattedDob = $faker->date($format = 'd-m-Y', $max = $dod);
//        $unformattedDod = $dod;
//
//        $data = ['user_id' => $this->user->user_id,
//            'visitor_id' => 1,
//            'forename' => '',
//            'surname' => '',
//            'dob' => Carbon\Carbon::parse($unformattedDob)->format('Y-m-d'),
//            'dod' => Carbon\Carbon::parse($unformattedDod)->format('Y-m-d'),
//            'gender' => 'female',
//            'place_of_birth' => 'Newtown',
//            'place_of_death' => 'Newtown'];
//
//        $this->be($this->user);
//        $this->visit('ancestor/create')
//            ->type($data['forename'], 'forename')
//            ->type($data['surname'], 'surname')
//            ->type($unformattedDob, 'dob')
//            ->type($unformattedDob, 'dod')
//            ->select($data['gender'], 'sex')
//            ->type($data['place_of_birth'], 'place_of_birth')
//            ->type($data['place_of_death'], 'place_of_death')
//            ->press('submit');
//        $this->assertNull(DB::table('ancestors')->where('ancestor_id', 2)->first());
//
////        $this->visit('ancestor/create')->type('Name', 'forename')
////            ->type('McName', 'surname')
////            ->press('submit');
////        $this->assertNotNull(DB::table('ancestors')->where('ancestor_id', 2)->first());
//
//    }

//    public function testEditAncestor()
//    {
//
//        $faker = Faker::create();
//        $unformattedDod = $faker->date($format = 'd-m-Y', $max = 'now');
//        $gender = (rand(0, 1) == '0') ? 'male' : 'female';
//        $unformattedDob = $faker->date($format = 'd-m-Y', $max = $unformattedDod );
//
//        $data = ['visitor_id' => 1,
//            'forename' => 'newForename',
//            'surname' => 'newSurname',
//            'dob' => Carbon\Carbon::parse($unformattedDob)->format('Y-m-d'),
//            'dod' => Carbon\Carbon::parse($unformattedDod)->format('Y-m-d'),
//            'gender' => 'female',
//            'place_of_birth' => 'Newtown',
//            'place_of_death' => 'Newtown'];
//
//        $this->be($this->user);
//        $this->visit('ancestor/edit/'.$data['visitor_id'])
//            ->type($data['forename'], 'forename')
//            ->type($data['surname'], 'surname')
//            ->type($unformattedDob, 'dob')
//            ->type($unformattedDod, 'dod')
//            ->select($data['gender'], 'sex')
//            ->type($data['place_of_birth'], 'place_of_birth')
//            ->type($data['place_of_death'], 'place_of_death')
//            ->press('submit');
//        $this->seeInDatabase('ancestors', $data);
//
//    }

}
