<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\facades\Hash;
use Faker\Factory as Faker;
use Carbon\Carbon;
class EditVisitorTest extends TestCase
{

    private $user1, $user1Password = '123123',$visitor, $newEmail = 'newemail@uni.com';

    public function setUp()
    {
        parent::setUp();
        TestCase::clenseDB();

        $this->user1 = factory(App\User::class)->create([
            'user_id'=>1,
            'type' => 'visitor',
            'email' => 'oldmail@uni.com',
            'password' => bcrypt($this->user1Password)
        ]);
        $faker = Faker::create();
        $this->visitor = factory(App\Visitor::class)->create([

            'user_id' => $this->user1->user_id,
            'forename' => 'bill',
            'surname' => 'billington',
            'gender' => 'male',
            'origin' => 'France',
            'description' => 'bill pays the bills'
        ]);
    }

    public function testEditVisitorCredentials()
    {
        $faker = Faker::create();
        $unformattedDob = $faker->date($format = 'd-m-Y', $max = 'now');
        $data = array(
            'forename' => 'jill',
            'surname' => 'jillington',
            'dob' => Carbon::createFromFormat('d-m-Y', $unformattedDob)->format('Y-m-d'),
            'gender' => 'female',
            'origin' => 'Finland',
            'description' => 'jill pays the bills');
        
        $this->be($this->user1);
        $this->visit('profile/edit')
            ->type('123123', 'password')
            ->type($data['forename'], 'forename')
            ->type($data['surname'], 'surname')
            ->select($data['gender'], 'sex')
            ->type($unformattedDob, 'dob')
            ->type($data['origin'], 'country')
            ->type($data['description'], 'description')
            ->press('submit');
        $this->seeInDatabase('visitors', $data);

    }

    public function testEditVisitorEmail()
    {
        $newEmail = $this->newEmail;
        $this->be($this->user1);
        $this->visit('profile/edit')
            ->type($newEmail, 'email')
            ->type($this->user1Password, 'password')
            ->type('','dob')
            ->press('submit');
        $this->assertEquals($newEmail,DB::table('users')->where('user_id',$this->user1->user_id)->value('email'));
        
    }

    public function testEditVisitorEmailWrongPassword()
    {
        $newEmail = $this->newEmail;
        $this->be($this->user1);
        $originalEmail = $this->user1->email;
        $this->visit('profile/edit')
            ->type($newEmail, 'email')
            ->type('incorrect', 'password')
            ->type('','dob')
            ->press('submit');
        $this->assertEquals($originalEmail,DB::table('users')->where('user_id',$this->user1->user_id)->value('email'));
        
    }

    public function testEditVisitorEmailTaken()
    {
        $takenEmail = 'taken@uni.com';
        $user2 = factory(App\User::class)->create([
            'type' => 'visitor',
            'email' => $takenEmail,
            'password' => '123123'
        ]);
        
//        $tempVisitor = factory(App\Visitor::class)->create([
//            'user_id' => $user2->user_id,
//        ]);
//        
//        $newEmail = $this->newEmail;
        $this->be($this->user1);
        $originalEmail = $this->user1->email;
        $this->visit('profile/edit')
            ->type($takenEmail, 'email')
            ->type($this->user1Password, 'password')
            ->type('','dob')
            ->press('submit');
        $this->assertEquals($originalEmail,DB::table('users')->where('user_id',$this->user1->user_id)->value('email'));
    }


}
