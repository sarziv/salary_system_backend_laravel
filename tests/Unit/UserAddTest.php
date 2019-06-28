<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\UserToken;

class UserAddTest extends TestCase
{
    protected $user;
    protected $url = 'http://salaryapi.local/api/user/add';

    public function __construct()
    {
        parent::__construct();
        $this->user = new UserToken();
    }

    public function test_UserAddRecords(){
        $token = $this->user->UserToken();
        $data = [
            "pallet"=>1,
            "line"=>1,
            "vip"=>1,
            "extra_hour"=>1
        ];
        $records = $this->withHeaders([
            'X-Header' => 'Value',
            'Authorization'=>'Bearer '. $token,
        ])->json('POST', $this->url,$data);
        $records->assertStatus(200)->assertJson(
            ["message"=>"Record successfully created!"]
        );
    }
    public function test_UserAddRecordsValidation(){
        $token = $this->user->UserToken();
        $data = [
            "pallet"=>"String",//Integer error
            "line"=>"",//Required error
            "vip"=>1,
            "extra_hour"=>1
        ];
        $records = $this->withHeaders([
            'X-Header' => 'Value',
            'Authorization'=>'Bearer '. $token,
        ])->json('POST', $this->url,$data);
        //dd($records->json());
        $records->assertStatus(422)->assertJsonStructure(
            [
                "message",
                "errors"=>[
                    "pallet" =>[
                        "0"
                    ],
                    "line" =>[
                        "0"
                    ]
                ]

            ]
        );
    }
}
