<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class visitorTest extends TestCase
{
    private $user1, $user2, $user3, $user4, $user5, $visitor1, $visitor2, $visitor3, $visitor4, $visitor5;
    public function setUp()
    {
        parent::setUp();
        TestCase::clenseDB();
        $this->user1 = factory(App\User::class)->create([
            'type' => 'visitor'
        ]);
        $this->user2 = factory(App\User::class)->create([
            'type' => 'visitor'
        ]);
        $this->user3 = factory(App\User::class)->create([
            'type' => 'visitor'
        ]);
        $this->user4 = factory(App\User::class)->create([
            'type' => 'visitor'
        ]);
        $this->user5 = factory(App\User::class)->create([
            'type' => 'visitor'
        ]);
        $this->visitor1 = factory(App\Visitor::class)->create([
            'user_id' => $this->user1->user_id
        ]);
        $this->visitor2 = factory(App\Visitor::class)->create([
            'user_id' => $this->user2->user_id
        ]);
        $this->visitor3 = factory(App\Visitor::class)->create([
            'user_id' => $this->user3->user_id
        ]);
        $this->visitor4 = factory(App\Visitor::class)->create([
            'user_id' => $this->user4->user_id
        ]);
        $this->visitor5 = factory(App\Visitor::class)->create([
            'user_id' => $this->user5->user_id
        ]);

    }

    /**
     * A basic test example.
     *
     * @return void
     */
    public function testVisitor()
    {
        $this->seeInDatabase('visitors',['user_id' => $this->user5->user_id] );
        
        
    }
}
