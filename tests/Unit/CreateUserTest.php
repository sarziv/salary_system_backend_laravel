<?php

namespace Tests\Unit;

use Tests\TestCase;
use GuzzleHttp\Client;
use GuzzleHttp\RequestOptions;
use Faker\Factory;

class CreateUserTest extends TestCase
{
    /**
     * A basic unit test example.
     *
     * @return void
     */
    public function testCreateNewUser()
    {
        $faker = Factory::create();

        $url = 'http://salaryapi.local/api/auth/signup';

        $client = new Client();
        $response = $client->post($url, [
            RequestOptions::JSON => [
                "name" => "TestCase",
                "email" => $faker->email,
                "password" => "testpassword",
                "password_confirmation" => "testpassword"
            ]
        ]);
        $this->assertEquals(201, $response->getStatusCode());

    }
}
