<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Schema;
use Vinkla\Hashids\Facades\Hashids;

class MessagesControllerTest extends TestCase
{
    private $visitor_user, $provider_user, $provider, $visitor, $conversation, $message;

    public function setUp()
    {
        parent::setUp();
        TestCase::clenseDB();

        /****** VISITOR ********/
        $this->visitor_user = factory(App\User::class)->create([
            'user_id' => 1,
            'type' => 'visitor'
        ]);

        $this->visitor = factory(App\Visitor::class)->create([
            'user_id' => $this->visitor_user->user_id,
            'visitor_id' => 3,
            'member' => 1
        ]);

        /******* END VISITOR **********/
        /******* PROVIDER *********/
        $this->provider_user = factory(App\User::class)->create([
            'user_id' => 2,
            'type' => 'provider'
        ]);
        $this->provider = factory(App\Provider::class)->create([
            'user_id' => $this->provider_user->user_id,
            'provider_id' => 4
        ]);

        factory(\App\Credits::class)->create([
            'user_id' => $this->provider_user->user_id,
            'credits' => 1
        ]);

        /******* END PROVIDER **********/

        /***** CONVERSATION ******/
        $this->conversation = factory(\App\Conversations::class)->create([
            'conversation_id' => 1,
            'visitor_id' => $this->visitor_user->user_id,
            'provider_id' => $this->provider_user->user_id,
        ]);

        $this->message = factory(\App\Messages::class)->create([
            'message_id' => 1,
            'conversation_id' => 1,
            'provider_id' => $this->provider_user->user_id,
            'visitor_id' => $this->visitor_user->user_id,
            'who' => 'visitor'
        ]);
        /***** END CONVERSATION ******/
    }

    public function testGetConversation()
    {
        $this->be($this->visitor_user);
        $id = Hashids::encode($this->conversation->conversation_id);
        $this->get('conversation/get?id=' . $id . '&offset=' . 0 . '&size=' . 10, ['HTTP_X-Requested-With' => 'XMLHttpRequest'])
            ->seeJsonStructure([
                '*' => ['message', 'who', 'attachments', 'visitor_id', 'provider_id']
            ])->seeJson(['who' => 'visitor']);
    }

    public function testCreateNewMessage()
    {
        $this->withoutJobs();
        $this->be($this->visitor_user);

        $this->addCreditsToUser(5);
        $str = '\"visitor_id\":1,\"provider_id\":2,\"conversation_id\":\"1\",\"message\":\"hi\",\"who\":\"visitor\",\"attachments\":null';
        $this->postANewMessage($str);
    }

    public function testCreateNewMessageWithoutCredits()
    {
        DB::update('update credits set credits = 0 where user_id = ?', [$this->visitor_user->user_id]);
        $this->be($this->visitor_user);
        $expectedError = '{"errors":1000}';
        $this->postANewMessage($expectedError);
    }

    public function testCreateNewConversationWithoutCredits()
    {
        $this->withoutJobs();
        $this->be($this->visitor_user);
        $this->deleteConversation();
        $notEnoughCreditsError = '{"errors":1000}';
        $this->postANewConversation($notEnoughCreditsError);
    }

    public function testCreateNewConversationWithCredits()
    {
        $this->withoutJobs();
        $this->be($this->visitor_user);
        $this->deleteConversation();
        $this->addCreditsToUser(20);
        $success = '{"status":"Success"}';
        $this->postANewConversation($success);
    }

    public function testCreateNewConversationWithIncompleteProfile()
    {
        DB::update('update visitors set forename = null where user_id = ?', [$this->visitor_user->user_id]);
        $this->be($this->visitor_user);
        $expectedError = '{"errors":3000}';
        $this->postANewConversation($expectedError);
    }

    public function testCheckForNewForSuccess()
    {
        $this->be($this->visitor_user);
        $this->conversation = factory(\App\Conversations::class)->create([
            'conversation_id' => 10,
            'visitor_id' => $this->visitor_user->user_id,
            'provider_id' => $this->provider_user->user_id,
        ]);

        $this->message = factory(\App\Messages::class)->create([
            'message_id' => 10,
            'conversation_id' => 10,
            'provider_id' => $this->provider_user->user_id,
            'visitor_id' => $this->visitor_user->user_id,
            'who' => 'provider',
            'read' => 'no'
        ]);
        $success = '{"message":"{\"message_id\":\"10\",\"provider_id\":2,\"visitor_id\":1';
        $this->get('messages/checkForNew?id=' . Hashids::encode(10), [
            'HTTP_X-Requested-With' => 'XMLHttpRequest'
        ])->see($success);
    }

    public function testCheckForNewForFailure()
    {
        $this->be($this->provider_user);
        $failure = '{"message":"null"';
        $this->get('messages/checkForNew?id=' . Hashids::encode(10), [
            'HTTP_X-Requested-With' => 'XMLHttpRequest'
        ])->see($failure);
    }

    public function testOfferASearch()
    {
        $this->be($this->provider_user);
        $this->post('messages/offerASearch', [
            '_token' => csrf_token(),
            'price' => 20,
            'short-message' => 'Lorem',
            'date-of-completion' => '01-01-2016',
            'conversation_id' => Hashids::encode(1)
        ])->seeInDatabase('offered_searches', [
            'conversation_id' => 1,
            'price' => 20,
            'status' => 'pending'
        ]);
    }

    public function testAcceptASearch()
    {
        $this->be($this->visitor_user);
        $this->offerASearch();
        $this->addCreditsToUser(20);
        $this->get('/messages/acceptSearchOffer?conversation_id=' . Hashids::encode(1),
            ['HTTP_X-Requested-With' => 'XMLHttpRequest'])
            ->seeInDatabase('offered_searches', [
                'conversation_id' => 1,
                'price' => 20,
                'status' => 'accepted'
            ])
            ->see('accepted');
    }

    public function testDeclineASearch(){
        $this->be($this->visitor_user);
        $this->offerASearch();
        $this->addCreditsToUser(20);
        $this->get('/messages/declineSearchOffer?conversation_id=' . Hashids::encode(1),
            ['HTTP_X-Requested-With' => 'XMLHttpRequest'])
            ->seeInDatabase('offered_searches', [
                'conversation_id' => 1,
                'price' => 20,
                'status' => 'declined'
            ])
            ->see('declined');
    }

    public function testCancelASearch(){
        $this->be($this->visitor_user);
        $this->offerASearch();
        $this->addCreditsToUser(20);
        $this->get('/messages/cancelSearchOffer?conversation_id=' . Hashids::encode(1),
            ['HTTP_X-Requested-With' => 'XMLHttpRequest'])
            ->seeInDatabase('offered_searches', [
                'conversation_id' => 1,
                'price' => 20,
                'status' => 'cancelled'
            ])
            ->see('cancelled');
    }

    /** ============ HELPERS =============== */

    private function offerASearch()
    {
        factory(\App\OfferedSearches::class)->create([
            'conversation_id' => 1
        ]);
    }

    private function postANewMessage($expectedResult)
    {
        $this->post('messages/new', [
            '_token' => csrf_token(),
            'message' => 'hi',
            'providerId' => Hashids::encode($this->provider_user->user_id),
            'visitorId' => Hashids::encode($this->visitor_user->user_id),
            'conversationId' => Hashids::encode($this->conversation->conversation_id)
        ], ['HTTP_X-Requested-With' => 'XMLHttpRequest'])->see($expectedResult);
    }

    private function postANewConversation($expectedResult)
    {
        $this->post('/messages/conversation/new', [
            '_token' => csrf_token(),
            'message' => 'hi',
            'providerId' => Hashids::encode($this->provider_user->user_id),
            'visitorId' => Hashids::encode($this->visitor_user->user_id)
        ], ['HTTP_X-Requested-With' => 'XMLHttpRequest'])->see($expectedResult);
    }

    private function addCreditsToUser($amount)
    {
        factory(\App\Credits::class)->create([
            'user_id' => $this->visitor_user->user_id,
            'credits' => $amount
        ]);
    }

    private function deleteConversation()
    {
        if (Schema::hasTable('conversations')) {
            DB::delete('delete from conversations where conversation_id = 1');
        }
    }
}
