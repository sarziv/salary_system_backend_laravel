<?php

namespace Tests\Unit;


use Faker\Factory;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class UserLoginTest extends TestCase
{

    protected $url = 'http://salaryapi.local/api/auth/login';
    protected $faker;
    protected $email;

    public function __construct()
    {
        parent::__construct();
        $this->faker = Factory::create();
        $this->email = $this->faker->email;
    }


    /**
     * Test HTTP
     */
    public function testLoginNewUserHTTP()
    {
        $response = $this->get($this->url);
        $response->assertStatus(405);
    }

    /**
     * Login with non-existing user
     */
    public function testLoginUserNotExist()
    {
        $body = [
            "email" => $this->faker->email,
            "password" => "testpassword",
        ];

        $response = $this->withHeaders([
            'X-Header' => 'Value',
        ])->json('POST', $this->url, $body);

        $response
            ->assertStatus(401)
            ->assertJson([
                'message' => 'Unauthorized'
            ]);
    }

    public function testLoginUser()
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
        $response = $this->withHeaders([
            'X-Header' => 'Value',
        ])->json('POST','http://salaryapi.local/api/auth/signup' , $bodyNewUser);
        //Login with new user
        $response = $this->withHeaders([
            'X-Header' => 'Value',
        ])->json('POST', $this->url, $body);

        $response
            ->assertStatus(200)
            ->assertJsonStructure([
                'access_token',
                'token_type' ,
                'expires_at'
            ]);
    }

}
