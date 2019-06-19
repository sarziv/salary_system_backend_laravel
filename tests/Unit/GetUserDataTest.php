<?php

namespace Tests\Unit;

use Tests\TestCase;
use Faker\Factory;

class GetUserDataTest extends TestCase
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

    public function testUserDataFullProcess()
    {
        $bodyNewUser = [
            "name" => "UserLogin",
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
        $user = $this->withHeaders([
            'X-Header' => 'Value',
            'Authorization'=>'Bearer '.$token,
        ])->json('GET', 'http://salaryapi.local/api/auth/user');

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

    public function testUserWrongToken() {
        $user = $this->withHeaders([
            'X-Header' => 'Value',
            'Authorization'=>'Bearer '.'fake token',
        ])->json('GET', 'http://salaryapi.local/api/auth/user');

        $user
            ->assertStatus(401)
            ->assertJsonStructure([
                'message',
            ]);
    }

}
