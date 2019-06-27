<?php

namespace Tests;

use Faker\Factory;
use App\User;

class UserToken
{
    protected $email;
    protected $faker;
    protected $user_id;


    public function __construct()
    {
        $this->faker = Factory::create();
        $this->email = $this->faker->email;

    }

    private function Token()
    {
        //User creation (Singup concept)
        $user = new User([
            'name' => 'GeneratedUser',
            'email' => $this->email,
            'password' => bcrypt('testpassword')
        ]);
        $user->save();
        $this->user_id = $user->id;
        //Token creation (Login concept)
        $tokenResult = $user->createToken('Personal Access Token');

        $token = $tokenResult->token;
        $token->save();
        return $tokenResult->accessToken;
    }

    public function UserId()
    {
        return $this->user_id;
    }

    public function UserToken()
    {
        return $this->Token();
    }


}
