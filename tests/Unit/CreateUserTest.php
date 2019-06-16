<?php

namespace Tests\Unit;

use Tests\TestCase;
use GuzzleHttp\Client;
use GuzzleHttp\RequestOptions;
use Faker\Factory;

class CreateUserTest extends TestCase
{

    protected $email;
    protected $client;

    /**
     * Constructor
     */
    public function __construct()
    {
        parent::__construct();
        $this->client = new Client();
        $faker = Factory::create();
        $this->email = $faker->email;
    }
    /**
     * Test HTTP
     */
    public function testCreateNewUserHTTP()
    {
        $response = $this->get('http://salaryapi.local/api/auth/signup');
        $response->assertStatus(405);
    }

    /**
     *Create unique new user
     */
    public function testCreateNewUser()
    {
        $url = 'http://salaryapi.local/api/auth/signup';

        $response = $this->client->post($url, [
            RequestOptions::JSON => [
                "name" => "TestCase",
                "email" => $this->email,
                "password" => "testpassword",
                "password_confirmation" => "testpassword"
            ]
        ]);
        $this->assertEquals(201, $response->getStatusCode());
        $this->assertEquals("Created", $response->getReasonPhrase());
    }


}