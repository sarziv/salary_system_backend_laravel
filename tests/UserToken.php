<?php

namespace Tests;

use Faker\Factory;
use App\User;

class UserToken
{
    protected $email;
    protected $faker;

    public function __construct()
    {
        $this->faker = Factory::create();
        $this->email = $this->faker->email;
    }
    public function NewUser()
    {
        //User creation (Singup concept)
        $user = new User([
            'name' => 'GeneratedUser',
            'email' => $this->email,
            'password' => bcrypt('testpassword')
        ]);
        $user->save();

        //Token creation (Login concept)
        $tokenResult = $user->createToken('Personal Access Token');
        $token = $tokenResult->token;
        $token->save();

        return  $tokenResult->accessToken;
    }

}
