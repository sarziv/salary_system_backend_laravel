<?php

namespace Tests\Unit;

use Tests\TestCase;
use Tests\UserToken;

class UserLogoutTest extends TestCase
{
    protected $user;
    protected $url = 'http://salaryapi.local/api/auth/logout';

    public function __construct()
    {
        parent::__construct();
        $this->user = new UserToken();
    }

    /**
     * Test HTTP
     */
    public function testUserHTTP()
    {
        $response = $this->get('http://salaryapi.local/api/auth/logout');
        $response->assertStatus(302);
    }

    /**
     * User Logout
     */
    public function testUserLogout()
    {
        $token = $this->user->NewUser();

        $logout = $this->withHeaders([
            'X-Header' => 'Value',
            'Authorization'=>'Bearer '.$token,
        ])->json('GET', $this->url);

        $logout
            ->assertStatus(200)
            ->assertJson(  ['message' => 'Successfully logged out']);
    }

    public function testUserWrongToken() {
        $user = $this->withHeaders([
            'X-Header' => 'Value',
            'Authorization'=>'Bearer '.'Fake-Token',
        ])->json('GET', $this->url);

        $user
            ->assertStatus(401)
            ->assertJson([
                'message' => 'Unauthenticated.'
            ]);
    }

}
