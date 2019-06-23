<?php

namespace Tests\Unit;

use Tests\TestCase;
use Tests\UserToken;

class GetUserDataTest extends TestCase
{
    protected $user;
    protected $url = 'http://salaryapi.local/api/auth/user';

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
        $response = $this->get($this->url);
        $response->assertStatus(302);
    }
    /**
     * Get user Details
     */
    public function testUserDetails()
    {
        $token = $this->user->NewUser();

        $user = $this->withHeaders([
            'X-Header' => 'Value',
            'Authorization'=>'Bearer '.$token,
        ])->json('GET', $this->url);

        $user
            ->assertStatus(200)
            ->assertJsonStructure([
                'id',
                'name' ,
                'email',
                'email_verified_at',
                'created_at',
                'updated_at'
            ]);
    }
    /**
     * Using fake token
     */
    public function testUserFakeToken() {
        $user = $this->withHeaders([
            'X-Header' => 'Value',
            'Authorization'=>'Bearer '.'Fake-Token',
        ])->json('GET', $this->url);

        $user
            ->assertStatus(401)
            ->assertJson([
                'message'=>'Unauthenticated.',
            ]);
    }

}
