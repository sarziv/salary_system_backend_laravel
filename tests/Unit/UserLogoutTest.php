<?php

namespace Tests\Unit;

use Faker\Factory;
use Tests\TestCase;

class UserLogoutTest extends TestCase
{
    protected $email;

    public function __construct()
    {
        parent::__construct();
        $this->email = Factory::create()->email;
    }

    /**
     * Test HTTP
     */
    public function testUserHTTP()
    {
        $response = $this->get('http://salaryapi.local/api/auth/user');
        $response->assertStatus(302);
    }

    /**
     * User Details Register -> Login(generate token) -> Get user Details
     */
    public function testUserLogout()
    {
        $bodyNewUser = [
            "name" => "UserLogout",
            "email" => $this->email,
            "password" => "testpassword",
            "password_confirmation" => "testpassword"
        ];
        $body = [
            "email" => $this->email,
            "password" => "testpassword",
            "remember_me"=> true
        ];
        //Create user
        $this->withHeaders([
            'X-Header' => 'Value',
        ])->json('POST','http://salaryapi.local/api/auth/signup' , $bodyNewUser);
        //Login with new user
        $login = $this->withHeaders([
            'X-Header' => 'Value',
        ])->json('POST', 'http://salaryapi.local/api/auth/login' , $body);

        $login
            ->assertStatus(200)
            ->assertJsonStructure([
                'access_token',
                'token_type' ,
                'expires_at'
            ]);
        //new User token
        $token = $login->json('access_token');
        $logout = $this->withHeaders([
            'X-Header' => 'Value',
            'Authorization'=>'Bearer '.$token,
        ])->json('GET', 'http://salaryapi.local/api/auth/logout');

        $logout
            ->assertStatus(200)
            ->assertJson(  ['message' => 'Successfully logged out']);
    }

    public function testUserWrongToken() {
        $user = $this->withHeaders([
            'X-Header' => 'Value',
            'Authorization'=>'Bearer '.'Fake-Token',
        ])->json('GET', 'http://salaryapi.local/api/auth/logout');

        $user
            ->assertStatus(401)
            ->assertJson([
                'message' => 'Unauthenticated.'
            ]);
    }

}
