<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\DB;
use Faker\Factory as Faker;

class VisitorOverviewTest extends TestCase
{

    private $userProvider,$userVisitor,$noOfVisitors;

    public function setUp()
    {
        parent::setUp();
        TestCase::clenseDB();
        
        $this->noOfVisitors = 10;
        $noOfVisitors = $this->noOfVisitors;

        for($i = 1; $i<= $noOfVisitors;$i++){
            
            $user = factory(App\User::class)->create([
                'type' => 'visitor',
                'user_id' => $i
            ]);
            
            factory(App\Visitor::class)->create([
                'user_id' => $user->user_id,
                'visitor_id' => $i,
                'surname'=>('ancestor'.chr((65+$noOfVisitors)-$i))//creates reverse alphabetical list
            ]);
        }

        $this->userProvider = factory(App\User::class)->create([
            'type' => 'provider',
            'user_id' => ($noOfVisitors+1)
        ]);

        $this->userVisitor = factory(App\User::class)->create([
            'type' => 'visitor',
            'user_id' => ($noOfVisitors+2)
        ]);
        
        factory(App\Visitor::class)->create([
            'user_id' => $this->userVisitor->user_id
        ]);

    }
    
    public function testRedirectVisitorAccess(){
        $this->be($this->userVisitor);
        $response = $this->call('GET', 'visitor_overview/1');
        $this->assertNotEquals(200, $response->getStatusCode());
    }
    
    public function getVisitorInConversation(){
        $this->be($this->userProvider);
        $this->visit('visitor_overview/'.($this->noOfVisitors+2));
    }

}
