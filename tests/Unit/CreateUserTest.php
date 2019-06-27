<?php

namespace Tests\Unit;

use Tests\TestCase;
use Faker\Factory;

class CreateUserTest extends TestCase
{

    protected $email;
    protected $faker;
    protected $url = 'http://salaryapi.local/api/auth/signup';

    /**
     * Constructor
     */
    public function __construct()
    {
        parent::__construct();
        //Faker email
        $this->faker = Factory::create();
        //Persistent email
        $this->email = $this->faker->email;
    }

    /**
     * Test HTTP
     */
    public function test_SignupHTTP()
    {
        $response = $this->get('http://salaryapi.local/api/auth/signup');
        $response->assertStatus(405);
    }

    /**
     *  Create unique new user
     */
    public function test_CreateNewUser()
    {
        $body = [
            "name" => "CreateUser",
            "email" => $this->email,
            "password" => "testpassword",
            "password_confirmation" => "testpassword"
        ];
        $response = $this->withHeaders([
            'X-Header' => 'Value',
        ])->json('POST', $this->url, $body);

        $response
            ->assertStatus(201)
            ->assertJson([
                'message' => 'Successfully created user!'
            ]);
    }

    /**
     * Create new user password not matching
     */
    public function test_CreateNewUserPasswordDidNotMatch()
    {
        $body = [
            "name" => "CreateUser",
            "email" => $this->faker->email,
            "password" => "testpassword1",
            "password_confirmation" => "testpassword2"
        ];
        $response = $this->withHeaders([
            'X-Header' => 'Value',
        ])->json('POST', $this->url, $body);

        $response
            ->assertStatus(422)
            ->assertJsonStructure( [
                "message",
                    "errors" => [
                    "password"=> [
                        "0",
                        ]
                    ]
            ]);
    }

    /**
     * Create new user with duplicate email
     */
    public function test_CreateNewUserWithSameEmail()
    {
        $body = [
            "name" => "MasterUser",
            "email" => $this->faker->email,
            "password" => "testpassword",
            "password_confirmation" => "testpassword"
        ];
        //Creating user first time
        $this->withHeaders([
            'X-Header' => 'Value',
        ])->json('POST', $this->url, $body);

        //Creating user second time
        $response = $this->withHeaders([
            'X-Header' => 'Value',
        ])->json('POST', $this->url, $body);

        $response
            ->assertStatus(422)
            ->assertJsonStructure( [
                "message",
                "errors" => [
                    "email"=> [
                        "0",
                    ]
                ]
            ]);
    }

}