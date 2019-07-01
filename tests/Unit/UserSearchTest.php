<?php

namespace Tests\Unit;

use Illuminate\Support\Facades\DB;
use Tests\TestCase;
use Tests\UserToken;

class UserSearchTest extends TestCase
{
    protected $user;
    protected $url = 'http://salaryapi.local/api/user/search';

    public function __construct()
    {
        parent::__construct();
        $this->user = new UserToken();
    }

    /**
     * User records search
     */

    public function test_SearchUserRecordsByDate()
    {
        $token = $this->user->UserToken();
        $user_id = $this->user->UserId();


        DB::table('records')->insert([
            "user_id"=>$user_id,
            "pallet"=>$user_id,
            "line"=>$user_id,
            "vip"=>$user_id,
            "extra_hour"=>$user_id,
            "created_at"=>'2020-05-20 00:00:01'
        ]);
        $data = [
            'from' => [
                '0' => [
                    'year' => 2015,
                    'month' => 6,
                    'day' => 24
                ]
            ],
            'to' => [
                '0' => [
                    'year' => 2021,
                    'month' => 6,
                    'day' => 26
                ]
            ]
        ];


        $search = $this->withHeaders([
            'X-Header' => 'Value',
            'Authorization' => 'Bearer ' . $token,
        ])->json('POST', $this->url, $data);

        $search->assertStatus(200)->assertJsonStructure(
            ["0" => [
                "id",
                "pallet",
                "line",
                "vip",
                "extra_hour",
                "created_at"
            ]
            ]
        );
    }

    /**
     * User records empty search
     */
    public function test_SearchUserRecordsByDateEmpty()
    {
        $token = $this->user->UserToken();
        $data = [
            'from' => [
                'year' => 2020,
                'month' => 6,
                'day' => 24,
            ],
            'to' => [
                'year' => 2020,
                'month' => 6,
                'day' => 26,
            ]
        ];
        $search = $this->withHeaders([
            'X-Header' => 'Value',
            'Authorization' => 'Bearer ' . $token,
        ])->json('POST', $this->url, $data);

        //Empty record array
        $search->assertStatus(200)->assertJson(
            []
        );
    }

    /**
     * Search validation error
     */
    public function test_SearchUserRecordsByDateValidation()
    {
        $token = $this->user->UserToken();
        $data = [
            'from' => [
                'year' => "",//Missing
                'month' => 6,
                'day' => 24,
            ],
            'to' => [
                'year' => 2020,
                'month' => 6,
                'day' => "",//Missing
            ]
        ];
        $search = $this->withHeaders([
            'X-Header' => 'Value',
            'Authorization' => 'Bearer ' . $token,
        ])->json('POST', $this->url, $data);


        $search->assertStatus(422)->assertJsonStructure(
            [
                "errors" => [
                    "from.year" => [
                        "0"
                    ],
                    "to.day" => [
                        "0"
                    ]
                ]

            ]
        );
    }

}
