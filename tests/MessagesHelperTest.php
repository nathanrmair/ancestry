<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use app\Libraries\MessagesHelper;

class MessagesHelperTest extends TestCase
{

    private $user1, $user2, $provider, $visitor;
    public function setUp()
    {
        parent::setUp();
        TestCase::clenseDB();
        $this->user1 = factory(App\User::class)->create([
            'type' => 'visitor'
        ]);
        $this->user2 = factory(App\User::class)->create([
            'type' => 'provider'
        ]);
        $this->visitor = factory(App\Visitor::class)->create([
            'user_id' => $this->user1->user_id
        ]);
        $this->provider = factory(App\Provider::class)->create([
            'user_id' => $this->user2->user_id
        ]);
    }


    public function testGetNumberOfUnreadMessages(){

        $conversation = factory(App\Conversations::class)->create([
            'conversation_id' => 1,
            'provider_id' => $this->user2->user_id,
            'visitor_id' => $this->user1->user_id
        ]);
        for($i = 0; $i < 5;$i++){
            $message = factory(App\Messages::class)->create([
                'provider_id' => $this->provider->user_id,
                'visitor_id' => $this->visitor->user_id,
                'conversation_id' => $conversation->conversation_id
            ]);
        }

        $visitorUnreadMessages = \app\Libraries\MessagesHelper::getNumberOfUnreadMessages($this->visitor);
        $providerUnreadMessages = \app\Libraries\MessagesHelper::getNumberOfUnreadMessages($this->provider);
        $this->assertTrue( $visitorUnreadMessages === 5 && $providerUnreadMessages === 0);
    }

    public function testGetNameOfProvider(){
        $this->assertEquals($this->provider->name, MessagesHelper::getNameOfProvider($this->provider->user_id));
    }

    public function testGetNameOfVisitor(){
        $this->assertEquals($this->visitor->name, MessagesHelper::getNameOfVisitor($this->visitor->user_id));
    }

    public function testGetLastMessage(){
        $conversation = factory(App\Conversations::class)->create([
            'conversation_id' => 2,
            'provider_id' => $this->user2->user_id,
            'visitor_id' => $this->user1->user_id
        ]);

        $message1 = factory(App\Messages::class)->create([
            'message_id' => 1,
            'provider_id' => $this->provider->user_id,
            'visitor_id' => $this->visitor->user_id,
            'conversation_id' => $conversation->conversation_id,
            'message' => 'First message'
        ]);

        $message2 = factory(App\Messages::class)->create([
            'message_id' => 2,
            'provider_id' => $this->provider->user_id,
            'visitor_id' => $this->visitor->user_id,
            'conversation_id' => $conversation->conversation_id,
            'message' => 'Last Message'
        ]);
        $this->assertEquals($message2->message, MessagesHelper::getLastMessage(2));
    }
}
