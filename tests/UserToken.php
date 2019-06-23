<?php

namespace Tests;
use Faker\Factory;
use Illuminate\Http\Request;
use phpDocumentor\Reflection\Types\Integer;
use App\User;

class UserToken extends TestCase
{
    protected $email;
    protected $faker;

    public function __construct()
    {
        parent::__construct();
        $this->faker = Factory::create();
        $this->email = $this->faker->email;
    }
    public function NewUser()
    {
        $user = new User([
            'name' => 'GeneratedUser',
            'email' => $this->email,
            'password' => bcrypt('testpassword')
        ]);
        $user->save();

        $tokenResult = $user->createToken('Personal Access Token');
        $token = $tokenResult->token;
        $token->save();

        return  $tokenResult->accessToken;
    }

}
