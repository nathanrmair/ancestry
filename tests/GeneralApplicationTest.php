<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;

class GeneralApplicationTest extends TestCase
{
    private $visitorMember, $visitorNonMember, $provider;

    /**
     *
     */
    public function setUp()
    {
        parent::setUp();

        TestCase::clenseDB();

        Session::setDefaultDriver('array');
        Session::start();
        /********** VISITOR MEMBER *************/
        $this->visitorMember = factory(App\User::class)->create([
            'type' => 'visitor',
            'user_id' => 1
        ]);

        factory(App\Visitor::class)->create([
            'user_id' => $this->visitorMember->user_id,
            'member' => 1
        ]);

        factory(App\Credits::class)->create([
            'user_id' => $this->visitorMember->user_id
        ]);
        /********** // END VISITOR MEMBER *************/

        /******** VISITOR NOT MEMBER **************/
        $this->visitorNonMember = factory(App\User::class)->create([
            'type' => 'visitor',
            'user_id' => 2
        ]);

        factory(App\Visitor::class)->create([
            'user_id' => $this->visitorNonMember->user_id,
            'member' => 0
        ]);

        /******** // END VISITOR NOT MEMBER **************/

        /*********** PROVIDER **********/
        $this->provider =factory(App\User::class)->create([
            'type' => 'provider',
            'user_id' => 3
        ]);

        factory(\App\Provider::class)->create([
            'user_id' => $this->provider->user_id
        ]);

        factory(App\Credits::class)->create([
            'user_id' => $this->provider->user_id
        ]);

        /*********** END PROVIDER **********/
    }

    public function testApplication(){
        $this->get('/home')->seeStatusCode(200);
    }

    /**
     *
     */
    public function testAsAGuest(){

        $this->visit('profile/dashboard')->seePageIs('login');

        $this->visit('profile/dashboard/messages')->seePageIs('login');

        $this->visit('profile/edit')->seePageIs('login');

        $this->visit('ancestors')->seePageIs('login');

        $this->visit('profile/credits')->seePageIs('login');

        $this->visit('profile/membership')->seePageIs('login');

        $this->visit('profile/searches')->seePageIs('login');

        $this->visit('/cookiesPolicy')->seePageIs('cookiesPolicy');
        $this->visit('/about')->seePageIs('about');
        $this->visit('/search')->seePageIs('search');

        $this->get('provider_overview/' . \Vinkla\Hashids\Facades\Hashids::encode($this->provider->user_id))->seeStatusCode(200);
        $this->get('visitor_overview/' . \Vinkla\Hashids\Facades\Hashids::encode($this->visitorNonMember->user_id))->seeStatusCode(403);
    }

    public function testAsAMember(){
        $this->be($this->visitorMember);
        $this->visit('/home');
        $this->assertResponseOk();

        $this->visit('profile/dashboard');
        $this->assertResponseOk();

        $this->visit('profile/dashboard/messages');
        $this->assertResponseOk();

        $this->visit('profile/edit');
        $this->assertResponseOk();

        $this->visit('ancestors');
        $this->assertResponseOk();

        $this->visit('profile/credits');
        $this->assertResponseOk();

        $this->visit('profile/membership');
        $this->assertResponseOk();

        $this->visit('profile/searches');
        $this->assertResponseOk();

        $this->get('provider_overview/' . \Vinkla\Hashids\Facades\Hashids::encode($this->provider->user_id))->seeStatusCode(200);
        $this->get('visitor_overview/' . \Vinkla\Hashids\Facades\Hashids::encode($this->visitorNonMember->user_id))->seeStatusCode(403);

        $this->visit('/cookiesPolicy')->seePageIs('cookiesPolicy');
        $this->visit('/about')->seePageIs('about');
        $this->visit('/search')->seePageIs('search');

    }

    public function testAsANonMember(){
        $this->be($this->visitorNonMember);
        $this->visit('/home')->seeStatusCode(200);

        $this->visit('profile/dashboard');
        $this->assertResponseOk();

        $this->get('profile/dashboard/messages')->seeStatusCode(403);

        $this->visit('profile/edit');
        $this->assertResponseOk();

        $this->visit('ancestors');
        $this->assertResponseOk();

        $this->get('profile/credits')->seeStatusCode(403);

        $this->get('profile/membership');
        $this->assertResponseOk();

        $this->get('profile/searches')->seeStatusCode(403);
        $this->get('provider_overview/' . \Vinkla\Hashids\Facades\Hashids::encode($this->provider->user_id))->seeStatusCode(200);
        $this->get('visitor_overview/' . \Vinkla\Hashids\Facades\Hashids::encode($this->visitorMember->user_id))->seeStatusCode(403);

        $this->visit('/cookiesPolicy')->seePageIs('cookiesPolicy');
        $this->visit('/about')->seePageIs('about');
        $this->visit('/search')->seePageIs('search');

    }

    public function testAsProvider(){
        $this->be($this->provider);
        $this->visit('/home')->seeStatusCode(200);

        $this->visit('profile/dashboard');
        $this->assertResponseOk();

        $this->visit('profile/dashboard/messages');
        $this->assertResponseOk();

        $this->visit('profile/edit');
        $this->assertResponseOk();

        $this->visit('profile/credits');
        $this->assertResponseOk();

        $this->visit('profile/searches');
        $this->assertResponseOk();

        $this->visit('profile/mygallery');
        $this->assertResponseOk();

        $this->get('visitor_overview/' . \Vinkla\Hashids\Facades\Hashids::encode($this->visitorMember->user_id))->seeStatusCode(403);
        $this->get('provider_overview/' . \Vinkla\Hashids\Facades\Hashids::encode($this->provider->user_id))->seeStatusCode(200);

        $this->visit('/cookiesPolicy')->seePageIs('cookiesPolicy');
        $this->visit('/about')->seePageIs('about');
        $this->visit('/search')->seePageIs('search');

    }
}
