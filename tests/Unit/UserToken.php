<?php

namespace Tests;

use Faker\Factory;

class UserToken extends TestCase
{
    protected $email;
    protected $faker;

    public function __construct()
    {
        parent::__construct();
        //Faker genetated email
        $this->faker = Factory::create();
        //email
        $this->email = $this->faker->email;
    }
    public function Token()
    {
        $bodyNewUser = [
            "name" => "GeneratedUser",
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
       return $login->json('access_token');
    }
}
