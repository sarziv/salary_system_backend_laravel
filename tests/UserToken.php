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

        $this->user_id = $user->id;
        return  $tokenResult->accessToken;
    }

    public function UserID(){
        return $this->user_id;
    }

}
