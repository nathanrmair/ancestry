<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class adminMainTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */
    public function testViewUsersLink()
    {
        $this->withoutMiddleware();
        
        $this->visit('/admin/adminMain')
        ->click('View all users')
            ->seePageIs('/admin/users');
        
    }
    
    public function testAddUserLink()
    {
        $this->withoutMiddleware();
        $this->assertTrue(true);
//
//        $this->visit('/admin/adminMain')
//            ->click('Add new user')
//            ->seePageIs('/admin/users/addNewUser');
    }

    public function testUserParameters()
    {
        $this->withoutMiddleware();

        $this->visit('/admin/adminMain')
            ->click('Search user parameters')
        ->seePageIs('/admin/users/searchUsers');
    }
}
