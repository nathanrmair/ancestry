<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\DB;
use Faker\Factory as Faker;

class ProviderOverviewTest extends TestCase
{

    private $user, $noOfProviders, $visitor;

    public function setUp()
    {
        parent::setUp();
        TestCase::clenseDB();
        
        $this->noOfProviders = 10;

        for ($i = 1; $i <= $this->noOfProviders; $i++) {
            $user = factory(App\User::class)->create([
                'type' => 'provider',
                'user_id' => $i,
                'email'=>($i.'@email.com')
            ]);

            factory(App\Provider::class)->create([
                'user_id' => $user->user_id,
                'provider_id'=> (20+$i),
                'name' => ('provider' . chr((65 + $this->noOfProviders) - $i)),//creates reverse alphabetical list
                'description' => ('provider' .$i)

            ]);
            info('provider' . chr((65 + $this->noOfProviders) - $i));
        }

        $this->visitor = factory(App\User::class)->create([
            'type' => 'visitor',
            'user_id' => ($this->noOfProviders + 1)
        ]);

        factory(App\Visitor::class)->create([
            'user_id' => $this->visitor->user_id
        ]);

    }


public function testViewProviderProfile(){
        $this->be($this->visitor);
        $id = rand(1, $this->noOfProviders);
        $this->visit('provider_overview/'.\Vinkla\Hashids\Facades\Hashids::encode($id));
        $this->see('Map');
    }
    
}
